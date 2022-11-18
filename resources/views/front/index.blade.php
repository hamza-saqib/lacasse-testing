@extends('layouts.front.app')

@section('og')
    <meta property="og:type" content="home"/>
    <meta property="og:title" content="{{ config('app.name') }}"/>
    <meta property="og:description" content="{{ config('app.name') }}"/>
@endsection

@section('content')

{{--
    @include('layouts.front.home-slider')

    @if($cat1->products->isNotEmpty())
        <section class="new-product t100 home">
            <div class="container">
                <div class="section-title b50">
                    <h2>{{ $cat1->name }}</h2>
                </div>
                @include('front.products.product-list', ['products' => $cat1->products->where('status', 1)])
                <div id="browse-all-btn"> <a class="btn btn-default browse-all-btn" href="{{ route('front.category.slug', $cat1->slug) }}" role="button">browse all items</a></div>
            </div>
        </section>
    @endif
    <hr>
    @if($cat2->products->isNotEmpty())
        <div class="container">
            <div class="section-title b100">
                <h2>{{ $cat2->name }}</h2>
            </div>
            @include('front.products.product-list', ['products' => $cat2->products->where('status', 1)])
            <div id="browse-all-btn"> <a class="btn btn-default browse-all-btn" href="{{ route('front.category.slug', $cat2->slug) }}" role="button">browse all items</a></div>
        </div>
    @endif
    <hr />
    @include('mailchimp::mailchimp')
     --}}

       <div class="banner">
          <img src="images/banner-image.jpg" alt="">
       </div>
       <!-- ==============  About  ============== -->
       <div class="tabs">
          <div class="row">
             <div class="col-md-12">
                <div class="top-link">
                   <span><a href="#"> {{LanguageHelper::getPhrase('make_model')}}</a></span>
                 <!--   <span><a href="#"> MC</a></span>
                   <span><a href="#"> Truck</a></span> -->
                </div>
                <div class="tab-link">
                   <ul class="first-tab">
                      @foreach($make as $m)
                        <!-- <li><a href="{{ url('category/'.$m->slug) }}">{{ $m->name }}</a></li> -->
                        <li><a href="{{ url('getsubcategory/'.$m->slug) }}">{{ $m->name }}</a></li>
                      @endforeach
                   </ul>
                   <p>
                      <a href="#">{{LanguageHelper::getPhrase('show_all_makes')}} </a>
                      <a href="#">{{LanguageHelper::getPhrase('search_all_makes')}}</a>
                   </p>
                </div>
             </div>
             {{--
              <div class="col-md-3">
                <div class="top-link-2">
                   <span><a href="#"> Sök RegNr</a></span>
                </div>
                <div class="tab-link-2">
                   <ul class="second-tab">
                      <li><img src="{{asset('images/eu_s.svg')}}" alt=""> <input type="text" placeholder="ert"></li>
                      <li><img src="{{asset('images/se.png')}}" alt=""> <a href="#">Alfa</a></li>
                      <li><img src="{{asset('images/no.png')}}" alt=""><a href="#">Alfa</a></li>
                      <li><img src="{{asset('images/dk.png')}}" alt=""><a href="#">Alfa</a></li>
                   </ul>
                </div>
              </div>
              --}}
              {{--
              <div class="col-md-3">
              <div class="top-link-2">
              <span><a href="#">Article no. / Other codes</a></span>
              </div>
              <div class="tab-link-2">
              <form>
              <div class="radio">
              <label><input type="radio" name="optradio" checked>Article no.</label>
              </div>
              <div class="radio">
              <label><input type="radio" name="optradio">Engine code</label>
              </div>
              <div class="radio">
              <label><input type="radio" name="optradio">Gear box code</label>
              </div>                             
              <span>
              <input class="form-control mr-sm-2" type="search" placeholder="Ert Z-Nummer" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button></span>
              </form>
              </div>
              
             </div>--}}
          </div>
          <!-- <p class="bottom-tab-link">Sök även: 
             <a href="#">Däck</a>
             <a href="#">MC-delar</a>
             <a href="#">Husvagnsdelar</a>
             <a href="#">Lastbilsdelar</a>
             <a href="#">Skoterdelar</a>
             <a href="#">Övrigt</a>
          </p> -->
       </div>
        {{--
        <!-- ==============  About  ============== -->
        <div class="about">
          <h2>Bildelsbasen.se</h2>
          <p>Welcome to the new Bildelsbasen.se - The leading Swedish marketplace for used auto / car parts. You will find over 5 million car parts in our database and the affiliated companies offer fast and reliable deliveries. Please have in mind that there are affiliated companies which only delivers within the borders of Sweden. Start your search by selecting a make in the box to the left. You can then select the correct model / part group and eventually filter on your vehicles model year.</p>
        </div>
        <!-- ==============  New Vehicles  ============== -->
       <div class="new-vehicles">
          <h2>New vehicles</h2>
          <div class="row pb-2 first-row">
             <div class="col-md-4 vehicles-box">
                <div class="media">
                   <img src="{{asset('images/car.jpg')}}" class="mr-2" alt="...">
                   <div class="media-body">
                      <h5 class="mt-0">Media heading</h5>
                      <p>18847 Milage, Arrived:<span>today</span></p>
                      <p>Södertälje Bil och Alldemo...</p>
                   </div>
                </div>
             </div>
             <div class="col-md-4 vehicles-box">
                <div class="media">
                   <img src="{{asset('images/car.jpg')}}" class="mr-2" alt="...">
                   <div class="media-body">
                      <h5 class="mt-0">Media heading</h5>
                      <p>18847 Milage, Arrived:<span>today</span></p>
                      <p>Södertälje Bil och Alldemo...</p>
                   </div>
                </div>
             </div>
             <div class="col-md-4 vehicles-box">
                <div class="media">
                   <img src="{{asset('images/car.jpg')}}" class="mr-2" alt="...">
                   <div class="media-body">
                      <h5 class="mt-0">Media heading</h5>
                      <p>18847 Milage, Arrived:<span>today</span></p>
                      <p>Södertälje Bil och Alldemo...</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="row pt-2">
             <div class="col-md-4 vehicles-box">
                <div class="media">
                   <img src="{{asset('images/car.jpg')}}" class="mr-2" alt="...">
                   <div class="media-body">
                      <h5 class="mt-0">Media heading</h5>
                      <p>18847 Milage, Arrived:<span>today</span></p>
                      <p>Södertälje Bil och Alldemo...</p>
                   </div>
                </div>
             </div>
             <div class="col-md-4 vehicles-box">
                <div class="media">
                   <img src="{{asset('images/car.jpg')}}" class="mr-2" alt="...">
                   <div class="media-body">
                      <h5 class="mt-0">Media heading</h5>
                      <p>18847 Milage, Arrived:<span>today</span></p>
                      <p>Södertälje Bil och Alldemo...</p>
                   </div>
                </div>
             </div>
             <div class="col-md-4 vehicles-box">
                <div class="media">
                   <img src="{{asset('images/car.jpg')}}" class="mr-2" alt="...">
                   <div class="media-body">
                      <h5 class="mt-0">Media heading</h5>
                      <p>18847 Milage, Arrived:<span>today</span></p>
                      <p>Södertälje Bil och Alldemo...</p>
                   </div>
                </div>
             </div>
          </div>
       </div>
       <!-- ==============  Client  ============== -->
       <div class="client">
          <section>
             <img src="{{asset('images/img_logo_biltorget_small.gif')}}" alt="">
             <ul>
                <li><a href="#">Begagnade bilar</a></li>
                <li><a href="#">Bilhandlare</a></li>
                <li><a href="#">Nya bilar</a></li>
                <li><a href="#">Prissänkta bilar</a></li>
             </ul>
          </section>
          <section>
             <img src="{{asset('images/img_logo_skrotauktion_small.gif')}}" alt="">
             <ul>
                <li><a href="#">Skrota bilen</a></span></li>
                <li><a href="#">Nya auktioner</a></span></li>
             </ul>
          </section>
          <section>
             <img src="{{asset('images/img_logo_husvagnstorget_small.gif')}} " alt="">
             <ul>
                <li><a href="#">Husvagnsdelar</a></li>
             </ul>
          </section>
          <section>
             <img src="{{asset('images/img_logo_mctorget_small.gif')}}" alt="">
             <ul>
                <li><a href="#">MC- / mopeddelar</a></li>
             </ul>
          </section>
          <section>
             <img src="{{asset('images/img_logo_fbt_small_2.gif')}}" alt="">
             <ul>
                <li><a href="#">Sök</a></li>
                <li><a href="#">Företag</a></li>
                <li><a href="#">Registrera</a></li>
                <li><a href="#">Fordon</a></li>
                <li><a href="#">Forum</a></li>
             </ul>
          </section>
       </div>
       --}}
@endsection