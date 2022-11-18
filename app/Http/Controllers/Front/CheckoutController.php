<?php

namespace App\Http\Controllers\Front;

use App\Shop\Addresses\Address;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use App\Shop\Checkout\CheckoutRepository;

use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Cart\Requests\CartCheckoutRequest;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Carts\Requests\PayPalCheckoutExecutionRequest;
use App\Shop\Carts\Requests\StripeExecutionRequest;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;

use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\Orders\Repositories\OrderRepository;

use App\Shop\PaymentMethods\Paypal\Exceptions\PaypalRequestError;
use App\Shop\PaymentMethods\Paypal\Repositories\PayPalExpressCheckoutRepository;
//use App\Shop\PaymentMethods\Paymentwall\Repositories\PaymentwallRepository;
use App\Shop\PaymentMethods\Stripe\Exceptions\StripeChargingErrorException;
use App\Shop\PaymentMethods\Stripe\StripeRepository;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Shipping\ShippingInterface;
use Exception;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use PayPal\Exception\PayPalConnectionException;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Ramsey\Uuid\Uuid;
class CheckoutController extends Controller
{
    use ProductTransformable;

    /**
     * @var CartRepositoryInterface
     */
    private $cartRepo;

    /**
     * @var CourierRepositoryInterface
     */
    private $courierRepo;

    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepo;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepo;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepo;

    /**
     * @var PayPalExpressCheckoutRepository
     */
    private $payPal;

    private $paymentwall;

    /**
     * @var ShippingInterface
     */
    private $shippingRepo;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        CourierRepositoryInterface $courierRepository,
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        ProductRepositoryInterface $productRepository,
        OrderRepositoryInterface $orderRepository,
        ShippingInterface $shipping
    ) {
        $this->cartRepo = $cartRepository;
        $this->courierRepo = $courierRepository;
        $this->addressRepo = $addressRepository;
        $this->customerRepo = $customerRepository;
        $this->productRepo = $productRepository;
        $this->orderRepo = $orderRepository;
        $this->payPal = new PayPalExpressCheckoutRepository;
        //$this->paymentwall = new PaymentwallRepository;
        $this->shippingRepo = $shipping;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->cartRepo->getCartItems();
        //dd($products);
        $shippingFee = 0.00;
        foreach($products as $cartItem){
            $shippingFee += $cartItem->product->transportation_price;
        }
        $customer = $request->user();
        $rates = null;
        $shipment_object_id = null;

        if (env('ACTIVATE_SHIPPING') == 1) {
            $shipment = $this->createShippingProcess($customer, $products);
            if (!is_null($shipment)) {
                $shipment_object_id = $shipment->object_id;
                $rates = $shipment->rates;
            }
        }

        // Get payment gateways
        $paymentGateways = collect(explode(',', config('payees.name')))->transform(function ($name) {
            return config($name);
        })->all();
        //dd($paymentGateways);
        $billingAddress = $customer->addresses()->first();

        return view('front.checkout', [
            'customer' => $customer,
            'billingAddress' => $billingAddress,
            'addresses' => $customer->addresses()->get(),
            'products' => $this->cartRepo->getCartItems(),
            'subtotal' => $this->cartRepo->getSubTotal(),
            'tax' => $this->cartRepo->getTax(),
            'total' => $this->cartRepo->getTotal(2),
            'payments' => $paymentGateways,
            'cartItems' => $this->cartRepo->getCartItemsTransformed(),
            'shipment_object_id' => $shipment_object_id,
            'rates' => $rates,
            'shippingFee' => $shippingFee
        ]);
    }

    /**
     * Checkout the items
     *
     * @param CartCheckoutRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Shop\Addresses\Exceptions\AddressNotFoundException
     * @throws \App\Shop\Customers\Exceptions\CustomerPaymentChargingErrorException
     * @codeCoverageIgnore
     */
    public function store(CartCheckoutRequest $request)
    {
        $shippingFee = 0;

        switch ($request->input('payment')) {
            case 'paypal':
                return $this->payPal->process($shippingFee, $request);
                break;
            case 'stripe':

                $details = [
                    'description' => 'Stripe payment',
                    'metadata' => $this->cartRepo->getCartItems()->all()
                ];

                $customer = $this->customerRepo->findCustomerById(auth()->id());
                $customerRepo = new CustomerRepository($customer);
                $customerRepo->charge($this->cartRepo->getTotal(2, $shippingFee), $details);
                break;
            default:
        }
    }

    /**
     * Execute the PayPal payment
     *
     * @param PayPalCheckoutExecutionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function executePayPalPayment(PayPalCheckoutExecutionRequest $request)
    {
        try {
            $this->payPal->execute($request);
            $this->cartRepo->clearCart();

            return redirect()->route('checkout.success');
        } catch (PayPalConnectionException $e) {
            throw new PaypalRequestError($e->getData());
        } catch (Exception $e) {
            throw new PaypalRequestError($e->getMessage());
        }
    }

    /**
     * @param StripeExecutionRequest $request
     * @return \Stripe\Charge
     */
    public function charge(StripeExecutionRequest $request)
    {
        try {
            $customer = $this->customerRepo->findCustomerById(auth()->id());
            $stripeRepo = new StripeRepository($customer);

            $stripeRepo->execute(
                $request->all(),
                Cart::total(),
                Cart::tax()
            );
            return redirect()->route('checkout.success')->with('message', 'Stripe payment successful!');
        } catch (StripeChargingErrorException $e) {
            Log::info($e->getMessage());
            return redirect()->route('checkout.index')->with('error', 'There is a problem processing your request.');
        }
    }

    /**
     * Cancel page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cancel(Request $request)
    {
        return view('front.checkout-cancel', ['data' => $request->all()]);
    }

    /**
     * Success page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success()
    {
        return view('front.checkout-success');
    }

    /**
     * @param Customer $customer
     * @param Collection $products
     *
     * @return mixed
     */
    private function createShippingProcess(Customer $customer, Collection $products)
    {
        $customerRepo = new CustomerRepository($customer);

        if ($customerRepo->findAddresses()->count() > 0 && $products->count() > 0) {

            $this->shippingRepo->setPickupAddress();
            $deliveryAddress = $customerRepo->findAddresses()->first();
            $this->shippingRepo->setDeliveryAddress($deliveryAddress);
            $this->shippingRepo->readyParcel($this->cartRepo->getCartItems());

            return $this->shippingRepo->readyShipment();
        }
    }

    public function paymentwall(Request $request)
    {
        $products = $this->cartRepo->getCartItems();
        $shippingFee = 0.00;
        foreach($products as $cartItem){
            $shippingFee += $cartItem->product->transportation_price;
        }
        //echo"<pre>";print_r($products);die;
        $customer = $request->user();
        //dd($products);
        $rates = null;
        $shipment_object_id = null;

        if (env('ACTIVATE_SHIPPING') == 1) {
            $shipment = $this->createShippingProcess($customer, $products);
            if (!is_null($shipment)) {
                $shipment_object_id = $shipment->object_id;
                $rates = $shipment->rates;
            }
        }

        // // Get payment gateways
        // $paymentGateways = collect(explode(',', config('payees.name')))->transform(function ($name) {
        //     return config($name);
        // })->all();

        $billingAddress = $customer->addresses()->first();
        $cartRepo = new CartRepository(new ShoppingCart);
        $orderTotal = $cartRepo->getTotal();
        //echo $orderTotal;
        $orderTotal = number_format($orderTotal + $shippingFee, 2);
        //dd($orderTotal);
        $checkoutRepo = new CheckoutRepository;
        $preOrder = $checkoutRepo->buildCheckoutItems([
            //'reference' => Uuid::uuid4()->toString(),
            'reference' => Uuid::uuid4()->toString(),
            'courier_id' => 1,
            'customer_id' => $customer->id,
            'address_id' => $billingAddress->id,
            'order_status_id' => 6,
            'payment' => 'paymentwall',
            'discounts' => 0,
            'total_products' => $this->cartRepo->getTotal(2),
            'paymentwall_ref_id' => '',
            //'total' => $this->cartRepo->getTotal(2),
            //'total_paid' => $this->cartRepo->getTotal(2),
            'total' => $orderTotal,
            'total_paid' => $orderTotal,
            'tax' => $this->cartRepo->getTax()
        ]);
        //dd($preOrder);
        $this->cartRepo->clearCart();
        return view('front.checkout.paymentwall', compact('customer', 'billingAddress', 'orderTotal', 'preOrder', 'shippingFee'));
    }

      public function cashondelivery(Request $request)
    {

        $products = $this->cartRepo->getCartItems();
        $shippingFee = 0.00;
        foreach($products as $cartItem){
            $shippingFee += $cartItem->product->transportation_price;
        }
        //echo"<pre>";print_r($products);die;
        $customer = $request->user();
        //dd($products);
        $rates = null;
        $shipment_object_id = null;

        if (env('ACTIVATE_SHIPPING') == 1) {
            $shipment = $this->createShippingProcess($customer, $products);
            if (!is_null($shipment)) {
                $shipment_object_id = $shipment->object_id;
                $rates = $shipment->rates;
            }
        }

        // // Get payment gateways
        // $paymentGateways = collect(explode(',', config('payees.name')))->transform(function ($name) {
        //     return config($name);
        // })->all();

        $billingAddress = $customer->addresses()->first();
        $cartRepo = new CartRepository(new ShoppingCart);
        $orderTotal = $cartRepo->getTotal();
        $orderTotal = str_replace(',','',$orderTotal);
        // $orderTotal; 
       
        //echo $orderTotal;

        //$orderTotal = number_format($orderTotal + $shippingFee, 2);

        //echo $orderTotal; die;

        //echo $orderTotal; die;
        //dd($orderTotal);
        $checkoutRepo = new CheckoutRepository;
        $preOrder = $checkoutRepo->buildCheckoutItems([
            //'reference' => Uuid::uuid4()->toString(),
            'reference' => Uuid::uuid4()->toString(),
            'courier_id' => 1,
            'customer_id' => $customer->id,
            'address_id' => $billingAddress->id,
            'order_status_id' => 6,
            'payment' => 'cod',
            'discounts' => 0,
            'total_products' => $this->cartRepo->getTotal(2),
            'paymentwall_ref_id' => '',
            //'total' => $this->cartRepo->getTotal(2),
            //'total_paid' => $this->cartRepo->getTotal(2),
            'total' => $orderTotal,
            'total_paid' => $orderTotal,
            'tax' => $this->cartRepo->getTax()
        ]);
        //dd($preOrder);
        $this->cartRepo->clearCart();

       // return redirect()->route('checkout.thank_you')->with('message', 'Your order has been successfully placed');

       // return redirect('/checkout/thank-you');

        return view('front.checkout.thankyou');
        
        //return view('front.checkout.cashondelivery', compact('customer', 'billingAddress', 'orderTotal', 'preOrder', 'shippingFee'));
    }





    public function paymentwallresponse(Request $request){
        //dd($request)
        $log = ['description' => $request->input()];
        //Log::useDailyFiles(storage_path().'/logs/name-of-log.log');
        //Log::info($log);
        $orderLog = new Logger('order');
        $orderLog->pushHandler(new StreamHandler(storage_path('logs/order.log')), Logger::INFO);
        $orderLog->info('OrderLog', $log);
        
        /*$payment = PayPalPayment::get($request->input('paymentId'), $this->payPal->getApiContext());
        $execution = $this->payPal->setPayerId($request->input('PayerID'));
        $trans = $payment->execute($execution, $this->payPal->getApiContext());*/

        /*"uid":"user40012","goodsid":"product301","slength":null,"speriod":null,"type":"0","ref":"t1600150553","is_test":"1","sign_version":"4","sig":"1119ad87bdfec4932171dec9c2f086fb23c14c0e0752605282d5cd2e0210e2e2"*/
        $orderId = $request->input('uid');
        
        //Get Order info and update order status and transaction
        $order = $this->orderRepo->findOrderById($orderId);
        $orderRepo = new OrderRepository($order);
        $params['paymentwall_ref_id']   = $request->input('ref');
        $params['order_status_id']      = 1;
        //$order = $this->orderRepo->findOrderById($orderId);
        $orderRepo->updateOrder($params);

        //Login this customer and clear cart for this user
        /*$customer = $this->customerRepo->findCustomerById($customer_id);
        $billingAddress = $customer->addresses()->first();
        //$this->paymentwall->execute($request, $request->input(), $customer, $billingAddress);
        $cartRepo = new CartRepository(new ShoppingCart);
        $customer_id = $request->input('uid');
        $customer = $this->customerRepo->findCustomerById($customer_id);
        $billingAddress = $customer->addresses()->first();
        $checkoutRepo = new CheckoutRepository;
        $checkoutRepo->buildCheckoutItems([
            //'reference' => Uuid::uuid4()->toString(),
            'reference' => $request->input('ref'),
            'courier_id' => 1,
            'customer_id' => $request->input('uid'),
            'address_id' => $billingAddress->id,
            'order_status_id' => 1,
            'payment' => 'paymentwall',
            'discounts' => 0,
            'total_products' => Cart::total(),
            'total' => Cart::total(),
            'total_paid' => Cart::total(),
            'tax' => Cart::tax()
        ]);*//**/

        $this->cartRepo->clearCart();
        
        die;
        /*Paymentwall_Config::getInstance()->set(array(
        'public_key' => 't_adb0dbfbc2d22767f99502c3c1faa1',
        'private_key' => 't_a02af752cbfdd821d7de7444d933d2'
        ));
        $parameters = $request->all();
        $cardInfo = array(
            'email' =>$parameters['email'],
            'amount' => 9.99,
            'currency' => 'USD',
            'token' => $parameters['brick_token'],
            'fingerprint' => $parameters['brick_fingerprint'],
            'description' => 'Order #123'
        );

        if (isset($parameters['brick_charge_id']) AND isset($parameters['brick_secure_token'])) {
            $cardInfo['charge_id'] = $parameters['brick_charge_id'];
            $cardInfo['secure_token'] = $parameters['brick_secure_token'];
        }

        $charge = new Paymentwall_Charge();
        $charge->create($cardInfo);
        $responseData = json_decode($charge->getRawResponseData(),true);
        $response = $charge->getPublicData();

        if ($charge->isSuccessful() AND empty($responseData['secure'])) {
            if ($charge->isCaptured()) {
                // deliver a product
            } elseif ($charge->isUnderReview()) {
                // decide on risk charge
            }
        } elseif (!empty($responseData['secure'])) {
            $response = json_encode(array('secure' => $responseData['secure']));
        } else {
            $errors = json_decode($response, true);
        }

        echo $response;*/
    }
    public function thank_you(){
        return view('front.checkout.thankyou');
    }
    public function payment_failed(){
        return view('front.checkout.paymentfailed');
    }
}
