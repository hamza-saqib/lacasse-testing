@extends('layouts.front.app')
@section('og')
 {{--  <meta property="og:type" content="product"/>
    <meta property="og:title" content="{{ $product->name }}"/>
    <meta property="og:description" content="{{ strip_tags($product->description) }}"/>
    @if(!is_null($product->cover))
        <meta property="og:image" content="{{ asset("storage/$product->cover") }}"/>
    @endif  --}}
@endsection
@section('css')

@endsection
@section('content')
   <!-- ========  Main  ======== -->
   <main>
      <div class="row  prefference-tabs">
         <div class="col-md-12 prefference-tabs-content">
            <ul class="nav nav-pills mb-3 prefference" id="pills-tab" role="tablist">
               <li class="nav-item prefference-box" role="presentation">
                  <a class="nav-link" href= "{{ route('front.subcategory.slug') }}">
                     <h2><span>1</span>{{LanguageHelper::getPhrase('cat_make')}}</h2>
                     <section>
                        <label>{{LanguageHelper::getPhrase('cat_selected_make')}}:</label>
                        <span class="car-model"><img src="{{asset('images/ico_arrow_right.png')}} "> {{ ucwords($make) }}</span>
                        <span>{{LanguageHelper::getPhrase('cat_change_make')}}</span>
                     </section>
                  </a>
               </li>
               <li class="nav-item prefference-box" role="presentation">
                  <a class="nav-link" href= "{{ route('front.subcategory.slug',[$make]) }}">
                     <h2><span>2</span>{{LanguageHelper::getPhrase('cat_model')}}</h2>
                     <section>
                        <label>{{LanguageHelper::getPhrase('cat_selected_make')}}:</label>
                        <span class="car-model"><img src="{{asset('images/ico_arrow_right.png')}} "> {{ ucwords($model) }}</span>
                        <span>{{LanguageHelper::getPhrase('cat_change_model')}}</span>
                     </section>
                  </a>
               </li>
               <li class="nav-item prefference-box" role="presentation">
                  <a class="nav-link" href= "{{ route('front.getpartgroups.slug',[$model]) }}?b={{$b}}&m={{$m}}&s={{$s}}&p={{$p}}">
                     <h2><span>3</span>{{LanguageHelper::getPhrase('cat_part_group')}}</h2>
                     <section>
                        <label>{{LanguageHelper::getPhrase('cat_selected_part_group')}}:</label>
                        <span class="car-model"><img src="{{asset('images/ico_arrow_right.png')}}">{{ ucwords($partgroupname) }}</span>
                        <span>{{LanguageHelper::getPhrase('cat_change_part_group')}}</span>
                     </section>
                  </a>
               </li>
               <li class="nav-item prefference-box" role="presentation">
                  <a class="nav-link" href= "{{ route('front.show.all.partgroups',[$ispart, $make, $model]) }}?b={{$b}}&m={{$m}}&s={{$s}}&p={{$p}}">
                     <h2><span>4</span>{{LanguageHelper::getPhrase('cat_part')}}</h2>
                     <section>
                        <label>{{LanguageHelper::getPhrase('cat_selected_part')}}:</label>
                        <span class="car-model"><img src="{{asset('images/ico_arrow_right.png')}}">{{ ucwords($partsname) }}</span>
                        <span>{{LanguageHelper::getPhrase('cat_change_part')}}</span>
                     </section>
                  </a>
               </li>
            </ul>
         </div>
      </div>
      <!-- =========  Caategory List  =========== -->
      <div class="category-list list_pro">
         <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th scope="col">#</th>
                  <th scope="col">{{LanguageHelper::getPhrase('pt_product_image')}}</th>
                  <th scope="col">{{LanguageHelper::getPhrase('pr_information')}}</th>
                  <th scope="col">{{LanguageHelper::getPhrase('pr_engine_code')}}</th>
                  <th scope="col" class="quantity">{{LanguageHelper::getPhrase('pr_quality')}}</th>
                  <!-- <th scope="col">{{LanguageHelper::getPhrase('pr_model_year')}}</th> -->

                  <th scope="col">Item Number</th> 
                  <th scope="col">{{LanguageHelper::getPhrase('pr_price')}}</th>
               </tr>
            </thead>
            <tbody>
               @foreach($products as $product)

               <tr>
                  <th scope="row" class="product-code">
                     <a class="read_more" href="{{route('front.show.product',[$product->slug])}}">{{LanguageHelper::getPhrase('pr_read_more')}}</a>
                     <!-- <h5>W47011</h5> -->
                     <!-- <a href="#"><img src="{{asset('images/folder.svg')}}" alt="">Save Part</a> -->
                     <a class="Addtowishlist" data-productid="{{$product->id}}" href="javascript:void(0);"><img src="{{asset('images/folder.svg')}}" alt="">{{LanguageHelper::getPhrase('pr_add_to_wishlist')}}</a>
                  </th>
                  <td class="product-img">
                     @if(isset($product->cover))
                       <a href="{{route('front.show.product',[$product->slug])}}">
                        <img src="{{asset("storage/$product->cover")}}" alt="{{$product->name}}" />
                     </a>
                     @else
                     <a href="{{route('front.show.product',[$product->slug])}}">
                        <img src="https://via.placeholder.com/150" alt="{{ $product->name }}">
                     </a>
                     @endif
                     
                  </td>
                  <td>
                     <h2>{{$product->name}} </h2>
                     <!-- <small>BMW 525 IX </small>
                     <small>FRAM </small> -->
                     <p>{{$product->summary}}</p>
                  </td>
                  <td class="engine-code"><a href="#">{!! $product->sku !!}</a></td>
                  <td class="quantity">
                     {{$product->quality}}
                  </td>
                  <!-- <td>1993</td> -->
                  <td>  {{$product->item_number}}</td>
                  <td class="price">
                     {{ config('cart.currency')." ".$product->price}}
                     @if(!is_null($product->transportation_price))
                        <div class="transportation_price">
                           Transport Dupuis:<br/>
                           {{ config('cart.currency')." ".$product->transportation_price}}
                        </div>
                     @endif
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </main>
@endsection
@section('js')
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script type="text/javascript">
   $(".Addtowishlist").on("click", function(){
      var  productid = $(this).data('productid');
      $.ajax({
         type:'POST',
         url:"{{route('front.add.addwishlist')}}",
         data:{
            _token:"{{ csrf_token()  }}",
            productid:productid
         },
         success:function(data) {
           alert(data);
         }
      });
   });
</script>

@endsection