<?php

namespace App\Http\Controllers\Front;

use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Orders\Order;
use App\Shop\Orders\Transformers\OrderTransformable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class AccountsController extends Controller
{
    use OrderTransformable;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepo;

    /**
     * @var CourierRepositoryInterface
     */
    private $courierRepo;

    /**
     * AccountsController constructor.
     *
     * @param CourierRepositoryInterface $courierRepository
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        CourierRepositoryInterface $courierRepository,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepo = $customerRepository;
        $this->courierRepo = $courierRepository;
    }

    public function index()
    {
        $customer = $this->customerRepo->findCustomerById(auth()->user()->id);

        $customerRepo = new CustomerRepository($customer);
        $orders = $customerRepo->findOrders(['*'], 'created_at');

        $orders->transform(function (Order $order) {
            return $this->transformOrder($order);
        });

        $orders->load('products');

        $addresses = $customerRepo->findAddresses();

        return view('front.accounts', [
            'customer' => $customer,
            'orders' => $this->customerRepo->paginateArrayResults($orders->toArray(), 15),
            'addresses' => $addresses
        ]);
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        //echo "<pre>";print_r($request->all());die;
        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    // public function updatepassword(PasswordRequest $request)
    // {
    //     auth()->user()->update(['password' => Hash::make($request->get('password'))]);

    //     return back()->withPasswordStatus(__('Password successfully updated.'));
    // }
    public function passwordupdate(Request $request)
    {   $hashedPassword = \Auth::user()->password;
        if(Hash::check($request->old_password, $hashedPassword)){
            if($request->get('password')===$request->get('password_confirmation')){
                auth()->user()->update(['password' => Hash::make($request->get('password'))]);
                return back()->with('message','Password successfully updated.');
            }else{
                return back()->with('error', 'password confirmation not match');
            }
        }else{
             return back()->with('error', 'Current Password not match');
        }
    }
}
