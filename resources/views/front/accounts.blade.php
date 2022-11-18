@extends('layouts.front.app')



@section('content')

    <!-- Main content -->

    <style type="text/css">

        .detail-box.detail-box {

            margin-bottom: 30px;

        }

        p.card-text {

            font-size: 14px;

            line-height: 28px;

            margin-bottom: 0;

        }

        .card-title {

            margin-bottom: 10px;

            text-transform: capitalize;

            font-size: 16px;

            font-weight: 700;

            color: #000;

        }

        form.form-horizontal {

            margin-top: 15px;

        }

        button.btn.btn-danger {

            font-size: 14px;

        }

        a.btn.btn-primary.btn-edit.card-link {

            font-size: 14px;

        }

        @media only screen and (max-width: 575px) {

            .detail-box.detail-box {

                margin-bottom: 30px;

            }

        }

    </style>

    <section class="container content">

        <div class="row">

            <div class="box-body">

                @include('layouts.errors-and-messages')

            </div>

            <div class="col-md-12">

                <h2 class="ac-heading"> <i class="fa fa-home"></i> {{LanguageHelper::getPhrase('ma_my_account')}}</h2>

                <hr>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">

                <div>

                    <!-- Nav tabs -->

                    <ul class="nav nav-tabs user-tabs" role="tablist">

                        <li role="presentation" @if(request()->input('tab') == 'profile') class="active" @endif><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">{{LanguageHelper::getPhrase('ma_profile')}}</a></li>

                        <li role="presentation" @if(request()->input('tab') == 'orders') class="active" @endif><a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">{{LanguageHelper::getPhrase('ma_orders')}}</a></li>

                        <li role="presentation" @if(request()->input('tab') == 'address') class="active" @endif><a href="#address" aria-controls="address" role="tab" data-toggle="tab">{{LanguageHelper::getPhrase('ma_addresses')}}</a></li>

                    </ul>



                    <!-- Tab panes -->

                    <div class="tab-content customer-order-list">

                        <div role="tabpanel" class="tab-pane @if(request()->input('tab') == 'profile')active @endif" id="profile">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="edit-acount">

                                        <h3>{{LanguageHelper::getPhrase('ma_edit_account')}}</h3> 

                                        <form method="post" action="{{ route('update.accounts') }}" autocomplete="off">

                                            @csrf

                                            <div class="form-group">

                                                <label for="username">{{LanguageHelper::getPhrase('ma_name')}}</label>

                                                <input type="text" class="form-control" id="username" name="name" value="{{$customer->name}}">

                                            </div>

                                            <div class="form-group">

                                                <label for="phone">{{LanguageHelper::getPhrase('ad_your_phone')}}</label>

                                                <input type="text" class="form-control" id="phone" name="phone" value="{{$customer->phone}}">

                                            </div>

                                            <div class="form-group">

                                                <label for="national_id_no">{{LanguageHelper::getPhrase('ma_national_id_no')}}</label>

                                                <input type="text" class="form-control" id="national_id_no" name="national_id_no" value="{{$customer->national_id_no}}">

                                            </div>

                                            <div class="form-group">

                                                <label for="useremail">{{LanguageHelper::getPhrase('ma_email')}}</label>

                                                <input type="text"  value ="{{$customer->email}}" class="form-control" id="useremail" name="email">

                                            </div>

                                            <button type="submit" class="btn btn-primary">{{LanguageHelper::getPhrase('ma_update')}}</button>

                                        </form>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="change-password">

                                        <h3>{{LanguageHelper::getPhrase('ma_change_password')}}</h3>

                                        <form method="post" action="{{ route('update.password') }}" autocomplete="off">

                                            @csrf

                                            <div class="form-group">

                                                <label for="old_password">{{LanguageHelper::getPhrase('ma_current_password')}}</label>

                                                <input type="password" class="form-control" id="old_password" name="old_password" value="">

                                            </div>

                                            <div class="form-group">

                                                <label for="userpassword">{{LanguageHelper::getPhrase('ma_new_password')}}</label>

                                                <input type="password"  value ="" class="form-control" id="userpassword" name="password">

                                            </div>

                                            <div class="form-group">

                                                <label for="password_confirmation">{{LanguageHelper::getPhrase('ma_confirm_new_password')}}</label>

                                                <input type="password"  value ="" class="form-control" id="password_confirmation" name="password_confirmation">

                                            </div>

                                            <button type="submit" class="btn btn-primary">{{LanguageHelper::getPhrase('ma_change_password_button')}}</button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div role="tabpanel" class="tab-pane @if(request()->input('tab') == 'orders')active @endif" id="orders">

                            @if(!$orders->isEmpty())

                                <table class="table">

                                <tbody>

                                <tr>

                                    <td>{{LanguageHelper::getPhrase('ma_date')}}</td>

                                    <td>{{LanguageHelper::getPhrase('ma_total')}}</td>

                                    <td>{{LanguageHelper::getPhrase('ma_status')}}</td>

                                </tr>

                                </tbody>

                                <tbody>

                                @foreach ($orders as $order)

                                    <tr>

                                        <td>

                                            <a data-toggle="modal" data-target="#order_modal_{{$order['id']}}" title="Show order" href="javascript: void(0)">{{ date('M d, Y h:i a', strtotime($order['created_at'])) }}</a>

                                            <!-- Button trigger modal -->

                                            <!-- Modal -->

                                            <div class="modal fade" id="order_modal_{{$order['id']}}" tabindex="-1" role="dialog" aria-labelledby="MyOrders">

                                                <div class="modal-dialog" role="document">

                                                    <div class="modal-content">

                                                        <div class="modal-header">

                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                                                            <h4 class="modal-title" id="myModalLabel">{{LanguageHelper::getPhrase('ma_reference')}} #{{$order['reference']}}</h4>

                                                        </div>

                                                        <div class="modal-body">

                                                            <table class="table">

                                                                <thead>

                                                                    <th>{{LanguageHelper::getPhrase('ma_address')}}</th>

                                                                    <th>{{LanguageHelper::getPhrase('ma_payment_method')}}</th>

                                                                    <th>{{LanguageHelper::getPhrase('ma_total')}}</th>

                                                                    <th>{{LanguageHelper::getPhrase('ma_status')}}</th>

                                                                </thead>

                                                                <tbody>

                                                                    <tr>

                                                                        <td>

                                                                            <address>

                                                                                <strong>{{$order['address']->alias}}</strong><br />

                                                                                {{$order['address']->address_1}} {{$order['address']->address_2}}<br>

                                                                            </address>

                                                                        </td>

                                                                        <td>{{$order['payment']}}</td>

                                                                        <td>{{ config('cart.currency_symbol') }} {{$order['total']}}</td>

                                                                        <td><p class="text-center" style="color: #ffffff; background-color: {{ $order['status']->color }}">{{ $order['status']->name }}</p></td>

                                                                    </tr>

                                                                </tbody>

                                                            </table>

                                                            <hr>

                                                            <p>{{LanguageHelper::getPhrase('ma_order_details')}}:</p>

                                                            <table class="table">

                                                              <thead>

                                                                  <th>{{LanguageHelper::getPhrase('ma_name')}}</th>

                                                                  <th>{{LanguageHelper::getPhrase('ma_quantity')}}</th>

                                                                  <th>{{LanguageHelper::getPhrase('ma_price')}}</th>

                                                                  <th>{{LanguageHelper::getPhrase('ma_cover')}}</th>

                                                              </thead>

                                                              <tbody>
                                                                  @foreach ($order['products'] as $product)
                                                                  
                                                                  <tr>

                                                                      <td>{{$product['name']}}</td>

                                                                      <td>{{$product['pivot']['quality']??''}}</td>

                                                                      <td>{{$product['price']}}</td>

                                                                      <td><img src="{{ asset("storage/".$product['cover']) }}" width=50px height=50px alt="{{ $product['name'] }}" class="img-orderDetail"></td>

                                                                  </tr>

                                                              @endforeach

                                                              </tbody>

                                                            </table>

                                                        </div>

                                                        <div class="modal-footer">

                                                            <button type="button" class="btn btn-default" data-dismiss="modal">{{LanguageHelper::getPhrase('ma_close')}}</button>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </td>

                                        <td><span class="label @if($order['total'] != $order['total_paid']) label-danger @else label-success @endif">{{ config('cart.currency') }} {{ $order['total'] }}</span></td>

                                        <td><p class="text-center" style="color: #ffffff; background-color: {{ $order['status']->color }}">{{ $order['status']->name }}</p></td>

                                    </tr>

                                @endforeach

                                </tbody>

                            </table>

                                {{ $orders->links() }}

                            @else

                                <p class="alert alert-warning">{{LanguageHelper::getPhrase('ma_no_orders_yet')}}. <a href="{{ route('home') }}">{{LanguageHelper::getPhrase('v')}}!</a></p>

                            @endif

                        </div>

                        <div role="tabpanel" class="tab-pane @if(request()->input('tab') == 'address')active @endif" id="address">

                            <div class="row">

                                <div class="col-md-6">

                                    <a href="{{ route('customer.address.create', auth()->user()->id) }}" class="btn btn-primary create-address">{{LanguageHelper::getPhrase('ma_create_your_address')}}</a>

                                </div>

                            </div>

                            @if(!$addresses->isEmpty())

                                <div class="row">

                                    @foreach($addresses as $address)

                                        <div class="col-lg-4 col-md-6 col-sm-6 detail-box detail-box">

                                            <div class="card">

                                                <div class="card-body">

                                                    <h5 class="card-title">{{$address->alias}}</h5>

                                                    <p class="card-text">{{$address->address_1}}</p>

                                                    <p class="card-text">{{$address->country->name}}</p>

                                                    <p class="card-text">{{$address->zip}}</p>

                                                    <p class="card-text">{{$address->phone}}</p>

                                                    <form method="post" action="{{ route('customer.address.destroy', [auth()->user()->id, $address->id]) }}" class="form-horizontal">

                                                        <div class="btn-group">

                                                            <input type="hidden" name="_method" value="delete">

                                                            {{ csrf_field() }}

                                                            <a href="{{ route('customer.address.edit', [auth()->user()->id, $address->id]) }}" class="btn btn-primary btn-edit card-link"> <i class="fa fa-pencil"></i> {{LanguageHelper::getPhrase('ma_edit')}}</a>

                                                            <button onclick="return confirm('{{LanguageHelper::getPhrase('ma_are_you_sure')}}?')" type="submit" class="btn btn-danger"> <i class="fa fa-trash"></i> {{LanguageHelper::getPhrase('ma_delete')}}</button>

                                                        </div>

                                                    </form>

                                                    <!-- <a href="#" class="card-link">Card link</a>

                                                    <a href="#" class="card-link">Another link</a> -->

                                              </div>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                                <table class="table" style="display: none;">

                                <thead>

                                    <th>{{LanguageHelper::getPhrase('ma_allias')}}</th>

                                    <th>{{LanguageHelper::getPhrase('ma_addresss_1')}}</th>

                                    <!-- <th>{{LanguageHelper::getPhrase('ma_addresss_2')}}</th>

                                    <th>{{LanguageHelper::getPhrase('ma_city')}}</th> -->

                                    @if(isset($address->province))

                                    <th>{{LanguageHelper::getPhrase('ma_province')}}</th>

                                    @endif

                                    <!-- <th>{{LanguageHelper::getPhrase('ma_state')}}</th> -->

                                    <th>{{LanguageHelper::getPhrase('ma_country')}}</th>

                                    <th>{{LanguageHelper::getPhrase('ma_zip')}}</th>

                                    <th>{{LanguageHelper::getPhrase('ma_phone')}}</th>

                                    <th>{{LanguageHelper::getPhrase('ma_actions')}}</th>

                                </thead>

                                <tbody>

                                    @foreach($addresses as $address)

                                        <tr>

                                            <td>{{$address->alias}}</td>

                                            <td>{{$address->address_1}}</td>

                                            {{--<td>{{$address->address_2}}</td>

                                            <td>{{$address->city}}</td>--}}

                                            @if(isset($address->province))

                                            <td>{{$address->province->name}}</td>

                                            @endif

                                            {{--<td>{{$address->state_code}}</td>--}}

                                            <td>{{$address->country->name}}</td>

                                            <td>{{$address->zip}}</td>

                                            <td>{{$address->phone}}</td>

                                            <td>

                                                <form method="post" action="{{ route('customer.address.destroy', [auth()->user()->id, $address->id]) }}" class="form-horizontal">

                                                    <div class="btn-group">

                                                        <input type="hidden" name="_method" value="delete">

                                                        {{ csrf_field() }}

                                                        <a href="{{ route('customer.address.edit', [auth()->user()->id, $address->id]) }}" class="btn btn-primary btn-edit"> <i class="fa fa-pencil"></i> {{LanguageHelper::getPhrase('ma_edit')}}</a>

                                                        <button onclick="return confirm('{{LanguageHelper::getPhrase('ma_are_you_sure')}}?')" type="submit" class="btn btn-danger"> <i class="fa fa-trash"></i> {{LanguageHelper::getPhrase('ma_delete')}}</button>

                                                    </div>

                                                </form>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                            @else

                                <br /> <p class="alert alert-warning">{{LanguageHelper::getPhrase('ma_no_address_created_yet')}}.</p>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- /.content -->

@endsection

