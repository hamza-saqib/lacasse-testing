<?php
//require_once('./paymentwall/paymentwall-php/lib/paymentwall.php');
require_once(app_path() . '/paymentwall/paymentwall-php/lib/paymentwall.php');
Paymentwall_Config::getInstance()->set(array(
    'api_type' => Paymentwall_Config::API_GOODS,
    'public_key' => '973cc57f4d88eedc6390d7dcaae4db93',
    'private_key' => '8419ec323cb8150badf13a949f982a6b'
));

$widget = new Paymentwall_Widget(
    $preOrder->id, // Order Id
    'p1', // widget
    array(
        new Paymentwall_Product(
        'product301', // ag_external_id
        $orderTotal, // amount
        'USD', // currencyCode
        'Order', // ag_name
        Paymentwall_Product::TYPE_FIXED // ag_type
        )
    ),
    array(
        'email' => $customer->email, 
        'history[registration_date]' => strtotime($customer->created_at),
        'ps' => 'test', // Replace it with specific payment system short code for single payment methods
        //'addtional_param_name' => 'addtional_param_value',
        'billing_address' => $billingAddress->id,
        'success_url' => url('thank-you'),
        'failure_url' => url('payment-failed')
    )
);
?>
<script type="text/javascript">
  location.href = '<?php echo $widget->getUrl();?>';
</script>
<?php
/*
<script src="https://api.paymentwall.com/brick/build/brick-default.1.5.0.min.js"> </script>
<div id="payment-form-container"> </div>
{{-- 
 _token: "{{ csrf_token() }}"
 {{route('checkout.paymentwallresponse')}}
 --}}
<script>
  var brick = new Brick({
    public_key: 't_adb0dbfbc2d22767f99502c3c1faa1', // please update it to Brick live key before launch your project
    //public_key: '973cc57f4d88eedc6390d7dcaae4db93', // please update it to Brick live key before launch your project
    amount: 9.99,
    currency: 'USD',
    container: 'payment-form-container',
    action: "{{ asset('testpay.php') }}",
    //action: '{{url("paymentwallresponse")}}',
    form: {
      merchant: 'YOUR COMPANY',
      product: 'Product Name',
      pay_button: 'Pay',
      show_zip: true, // show zip code field 
      show_cardholder: true // show card holder name field
    }
  });

  brick.showPaymentForm(function(data) {
    // handle success
    console.log(data)
    if(data.captured == 1){
      location.href = "{{ url('success-payment') }}";
    }
  }, function(errors) {
    // handle errors
    console.log(errors)
  });
</script>
*/?>