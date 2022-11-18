@extends('layouts.front.app')
@section('og')

@endsection
@section('css')

@endsection
@section('content')
<div class="row">
   <div class="col-md-7 product-detail">
      <div class="detail">
         <h2>{{ ucwords($product->name) }}</h2>
         <div class="pprice">{{ config('cart.currency')." ".$product->price }}</div>
         <br>
         {{-- @if(!is_null($product->transportation_price) && $product->transportation_price > 0) 
            <div class="tprice">Transport depuis: {{ config('cart.currency')." ".$product->transportation_price }}</div>
         @endif --}}
         <!-- <form>
            <input type="button" name="Inquiry" value="Inquiry">
         </form> -->
         <form action="{{ route('cart.store') }}" class="form-inline" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="quantity" value="1" />
            <input type="hidden" name="product" value="{{ $product->id }}">
            <button id="add-to-cart-btn" type="submit" class="btn btn-warning" data-toggle="modal" data-target="#cart-modal"> <i class="fa fa-cart-plus"></i> {{LanguageHelper::getPhrase('pd_add_to_cart')}}</button>
        </form>
        <br>
         <section>
            {{--
               @php
               dd($product);
               @endphp
            --}}
            @php
               $exclude = ["id"];
            @endphp
            @foreach($product->getAttributes() as $key => $val)
               @if(in_array($key, ['id','shop_id','price','sale_price','length','width','height','distance_unit','transportation_price' ,'name', 'car_model','car_submodel','sub_part','pieces','item_number', 'brand_id', 'is_part', 'slug', 'cover', 'status', 'created_at', 'updated_at', 'description'  ]))
                  @continue
               @endif
               @php
                  if($key == 'sku' ) $key = 'article_number';
               @endphp
               <label><span class="pkey">{{ucwords(str_replace('_', ' ',$key))}}:</span><span class="pval">{{ucwords($val)}}</span></label>
            @endforeach
            <label><br/><span class="pkey">Description:</span><br/><br/><span class="pval">{!!$product->description!!}</span></label>
            <!-- <label><span>Shipping price from:</span></label>
            <label><span>Shipping time:</span> </label>
            <label><span>Stock no.:</span><b>W571776</b> (State when contact)</label>
            <label><span>Quality:</span> <b class="green">OK</b> Yta/Plåt: Utan anmärkning</label>
            <label><span>Typ:</span>Begagnad</label> -->
         </section>
      </div>
      {{--
      <div class="payment-providers">
         <ul>
            <li><img src="" alt="">Card payment / Bank payment <span>0 SEK</span></li>
            <li><img src="" alt="">Fortus faktura / Delbetala <span>29 SEK</span></li>
            <li><img src="" alt="">Swish Handel <span>0 SEK</span></li>
         </ul>
      </div>
      <div class="company-information">
         <h2>Atracco AB - Linköping</h2>
         <ul>
            <li><span>Telefontid:</span> Mån-Fre 7:30-16:30. Lunchstängt 12:00-12:30</li>
            <li><span>Phone: </span> 013-397024</li>
            <li><span>Customer Service:</span>  <img src="{{asset('images/no.png')}}" alt="product-image">
               <img src="{{asset('images/dk.png')}}" alt="product-image">
               <img src="{{asset('images/se.png')}}" alt="product-image">
            </li>
            <li><span>Butikens öppettider :</span> Mån-Fre 7:30-16:30. Lunchstängt 12:00-12:30</li>
            <li><span>OrganisationsNr:</span>556130-4519</li>
         </ul>
      </div>

      <div class="Heating fan">
         <h2>Part - Heating fan</h2>
         <div class="Heating-fan-table">
         <table class="table">
            <tbody>
               <tr>
                  <td>Stock no.:</td>
                  <td>Position:</td>
                  <td>Quality:</td>
                  <td>Fits fr./to m.y</td>
               </tr>                           
               <tr>
                  <td scope="row">W571776</td>
                  <td>Front</td>
                  <td>1</td>
                  <td>-</td>
               </tr>
                <tr class="border-top">
                  <td scope="row">W571776</td>
                  <td>Front</td>
                  <td>1</td>
                  <td>-</td>
               </tr>
                <tr>
                  <td scope="row">W571776</td>
                  <td>Front</td>
                  <td>1</td>
                  <td>-</td>
               </tr>
            </tbody>
         </table>
         </div>
      </div>

      <div class="Heating fan">
         <h2>Part - Heating fan</h2>
         <div class="Heating-fan-table">
         <table class="table">
            <tbody>
               <tr>
                  <td>Stock no.:</td>
                  <td>Position:</td>
                  <td>Quality:</td>
                  <td>Fits fr./to m.y</td>
               </tr>                           
               <tr>
                  <td scope="row">W571776</td>
                  <td>Front</td>
                  <td>1</td>
                  <td>-</td>
               </tr>
                <tr class="border-top">
                  <td scope="row">W571776</td>
                  <td>Front</td>
                  <td>1</td>
                  <td>-</td>
               </tr>
                <tr>
                  <td scope="row">W571776</td>
                  <td>Front</td>
                  <td>1</td>
                  <td>-</td>
               </tr>
            </tbody>
         </table>
         </div>
      </div>
      --}}
   </div>
   <div class="col-md-5 product-img">
      @if(isset($product->cover))
         <a href="{{route('front.show.product',[$product->slug])}}">
            <img src="{{asset("storage/$product->cover")}}" alt="{{$product->name}}" />
         </a>
      @endif
      @if(!empty($images))
         @foreach($images as $image)
            <img src="{{asset("storage/$image->src")}}">
         @endforeach
      @endif
   </div>
</div>
@endsection
@section('js')

@endsection