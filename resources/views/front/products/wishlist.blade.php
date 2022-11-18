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

  <main>
    <!-- =========  Caategory List  =========== -->
    <div class="category-list">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">{{LanguageHelper::getPhrase('pt_product_image')}}</th>
            <th scope="col">{{LanguageHelper::getPhrase('pr_information')}}</th>
            <th scope="col">{{LanguageHelper::getPhrase('pr_engine_code')}}</th>
            <th scope="col" class="quantity">{{LanguageHelper::getPhrase('pr_quality')}}</th>
            <th scope="col">{{LanguageHelper::getPhrase('pr_model_year')}}</th>
            <th scope="col">{{LanguageHelper::getPhrase('pr_milage')}}</th>
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
                <a class="Addtowishlist" data-productid="{{$product->id}}" href="javascript:void(0);"><img src="{{asset('images/folder.svg')}}" alt="">{{LanguageHelper::getPhrase('pr_remove_from_wishlist')}}</a>
              </th>
              <td class="product-img">
                @if(isset($product->cover))
                  <a href="{{route('front.show.product',[$product->slug])}}">
                    <img src="{{$product->cover}}" alt="{{$product->name}}" />
                  </a>
                @else
                  <a href="{{route('front.show.product',[$product->slug])}}">
                    <img src="https://via.placeholder.com/150" alt="{{ $product->name }}">
                  </a>
                @endif
              </td>
              <td>
                <h2>{{$product->name}} </h2>
                <small>BMW 525 IX </small>
                <small>FRAM </small>
                <p><?php echo $product->description; ?></p>
              </td>
              <td class="engine-code"><a href="#">M50-B25</a></td>
              <td class="quantity">{{$product->quantity}}</td>
              <td>1993</td>
              <td>{{$product->quantity}}</td>
              <td class="price">{{$product->price}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </main>
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.4.1.min.js" 
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script type="text/javascript">
   $(".Addtowishlist").on("click", function(){
      var  productid = $(this).data('productid');
      $.ajax({
        type:'POST',
        url:"{{route('front.remove.wishlist')}}",
        data:{
          _token:"{{ csrf_token()  }}",
          productid:productid
        },
        success:function(data) {
          //alert(data);
          location.reload(true);
        }
      });
   });
</script>
@endsection