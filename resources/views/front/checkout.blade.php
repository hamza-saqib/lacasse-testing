@extends('layouts.front.app')

@section('content')
    <div class="container product-in-cart-list">
        @if(!$products->isEmpty())
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}"> <i class="fa fa-home"></i> {{ LanguageHelper::getPhrase('home')}}</a></li>&nbsp;/&nbsp;
                        <li class="active">{{ LanguageHelper::getPhrase('shopping_cart')}}</li>
                    </ol>
                </div>
                <div class="col-md-12 content">
                    <div class="box-body">
                        @include('layouts.errors-and-messages')
                    </div>
                    @if(count($addresses) > 0)
                        <div class="row">
                            <div class="col-md-12">
                                @include('front.products.product-list-table', compact('products'))
                            </div>
                        </div>
                        @if(isset($addresses))
                            <div class="row">
                                <div class="col-md-12">
                                    <legend><i class="fa fa-home"></i> Shipping Address</legend>
                                    <table class="table table-striped">
                                        <thead>
                                            <th>{{ LanguageHelper::getPhrase('sc_alias')}}</th>
                                            <th>{{ LanguageHelper::getPhrase('sc_address')}}</th>
                                            <th>{{ LanguageHelper::getPhrase('sc_billing')}}</th>
                                            <th>{{ LanguageHelper::getPhrase('sc_delivery_address')}}</th>
                                        </thead>
                                        <tbody>
                                            @foreach($addresses as $key => $address)
                                                <tr>
                                                    <td>{{ $address->alias }}</td>
                                                    <td>
                                                        {{ $address->address_1 }} {{ $address->address_2 }} <br />
                                                        @if(!is_null($address->province))
                                                            {{ $address->city }} {{ $address->province->name }} <br />
                                                        @endif
                                                        {{ $address->city }} {{ $address->state_code }} <br>
                                                        {{ $address->country->name }} {{ $address->zip }}
                                                    </td>
                                                    <td>
                                                        <label class="col-md-6 col-md-offset-3">
                                                        <input
                                                                    type="radio"
                                                                    value="{{ $address->id }}"
                                                                    name="billing_address"
                                                                    @if($billingAddress->id == $address->id) checked="checked"  @endif>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        @if($billingAddress->id == $address->id)
                                                            <label for="sameDeliveryAddress">
                                                                <input type="checkbox" id="sameDeliveryAddress" checked="checked"> {{ LanguageHelper::getPhrase('sc_same_as_billing')}}
                                                            </label>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tbody style="display: none" id="sameDeliveryAddressRow">
                                            @foreach($addresses as $key => $address)
                                                <tr>
                                                    <td>{{ $address->alias }}</td>
                                                    <td>
                                                        {{ $address->address_1 }} {{ $address->address_2 }} <br />
                                                        @if(!is_null($address->province))
                                                            {{ $address->city }} {{ $address->province->name }} <br />
                                                        @endif
                                                        {{ $address->city }} {{ $address->state_code }} <br>
                                                        {{ $address->country->name }} {{ $address->zip }}
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <label class="col-md-6 col-md-offset-3">
                                                            <input
                                                                    type="radio"
                                                                    value="{{ $address->id }}"
                                                                    name="delivery_address"
                                                                    @if(old('') == $address->id) checked="checked"  @endif>
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        @if(!is_null($rates))
                            <div class="row">
                                <div class="col-md-12">
                                    <legend><i class="fa fa-truck"></i> {{ LanguageHelper::getPhrase('sc_courier')}}</legend>
                                    <ul class="list-unstyled">
                                        @foreach($rates as $rate)
                                            <li class="col-md-4">
                                                <label class="radio">
                                                    <input type="radio" name="rate" data-fee="{{ $rate->amount }}" value="{{ $rate->object_id }}">
                                                </label>
                                                <img src="{{ $rate->provider_image_75 }}" alt="courier" class="img-thumbnail" /> {{ $rate->currency }} {{ $rate->amount }}<br />
                                                {{ $rate->servicelevel->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div> <br>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr class="">
                                            <td>{{ LanguageHelper::getPhrase('sc_shipping')}}</td>
                                            <td>{{ config('cart.currency')." ".$shippingFee }}</td>
                                        </tr>
                                        <tr class="">
                                            <td>{{ LanguageHelper::getPhrase('sc_total')}}</td>
                                            <td>{{ config('cart.currency')." ".($total + $shippingFee) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <a href="{{route('checkout.cashondelivery')}}"  class="btn btn-success paymentwall">Submit<i class="far fa-money-bill-alt"></i></a>

                        {{-- <div class="row">
                            <div class="col-md-12">
                                <legend><i class="fa fa-credit-card"></i> {{ LanguageHelper::getPhrase('sc_payment')}}</legend>
                                @if(isset($payments) && !empty($payments))
                                    <table class="table table-striped">
                                        <thead>
                                        <th class="">{{ LanguageHelper::getPhrase('sc_name')}}</th>
                                        <th class="">{{ LanguageHelper::getPhrase('sc_description')}}</th>
                                        <th class="">{{ LanguageHelper::getPhrase('sc_choose_payment')}}</th>
                                        </thead>
                                        <tbody>
                                        <!--<tr class="">
                                            <td>Paymentwall</td>
                                            <td>Paymentwall</td>
                                            <td>
                                            <a href="{{route('checkout.paymentwall')}}"  class="btn btn-success pull-right paymentwall">{{ LanguageHelper::getPhrase('sc_pay_with')}} Paymentwall<i class="far fa-money-bill-alt"></i></a>
                                            </td>
                                        </tr>-->

                                        <tr class="">
                                            <td>Paiement à la livraison</td>
                                            <td>Paiement à la livraison</td>
                                            <td> 
                                            <a href="{{route('checkout.cashondelivery')}}"  class="btn btn-success pull-right paymentwall">Submit<i class="far fa-money-bill-alt"></i></a>
                                            </td>
                                        </tr>



                                        <!-- @foreach($payments as $payment)
                                            @include('layouts.front.payment-options', compact('payment', 'total', 'shipment_object_id'))
                                        @endforeach -->
                                        </tbody>
                                    </table>
                                @else
                                    <p class="alert alert-danger">{{ LanguageHelper::getPhrase('sc_no_payment_methos_set')}}</p>
                                @endif
                            </div>
                        </div> --}}
                    @else
                        <p class="alert alert-danger"><a href="{{ route('customer.address.create', [$customer->id]) }}">{{ LanguageHelper::getPhrase('sc_no_address_found')}}.</a></p>
                    @endif
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <p class="alert alert-warning">{{ LanguageHelper::getPhrase('cart_no_products')}}. <a href="{{ route('home') }}">{{ LanguageHelper::getPhrase('cart_shop_now')}}!</a></p>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('js')
    <script type="text/javascript">

        function setTotal(total, shippingCost) {
            let computed = +shippingCost + parseFloat(total);
            $('#total').html(computed.toFixed(2));
        }

        function setShippingFee(cost) {
            el = '#shippingFee';
            $(el).html(cost);
            $('#shippingFeeC').val(cost);
        }

        function setCourierDetails(courierId) {
            $('.courier_id').val(courierId);
        }

        $(document).ready(function () {

            let clicked = false;

            $('#sameDeliveryAddress').on('change', function () {
                clicked = !clicked;
                if (clicked) {
                    $('#sameDeliveryAddressRow').show();
                } else {
                    $('#sameDeliveryAddressRow').hide();
                }
            });

            let billingAddress = 'input[name="billing_address"]';
            $(billingAddress).on('change', function () {
                let chosenAddressId = $(this).val();
                $('.address_id').val(chosenAddressId);
                $('.delivery_address_id').val(chosenAddressId);
            });

            let deliveryAddress = 'input[name="delivery_address"]';
            $(deliveryAddress).on('change', function () {
                let chosenDeliveryAddressId = $(this).val();
                $('.delivery_address_id').val(chosenDeliveryAddressId);
            });

            let courier = 'input[name="courier"]';
            $(courier).on('change', function () {
                let shippingCost = $(this).data('cost');
                let total = $('#total').data('total');

                setCourierDetails($(this).val());
                setShippingFee(shippingCost);
                setTotal(total, shippingCost);
            });

            if ($(courier).is(':checked')) {
                let shippingCost = $(courier + ':checked').data('cost');
                let courierId = $(courier + ':checked').val();
                let total = $('#total').data('total');

                setShippingFee(shippingCost);
                setCourierDetails(courierId);
                setTotal(total, shippingCost);
            }
        });
    </script>
@endsection