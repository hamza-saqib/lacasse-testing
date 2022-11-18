@extends('layouts.front.app')
@section('content')
@section('css')
<style type="text/css">
   .Thumbnail img {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 150px;
}
/*.imgclass{
  width: 400px
}*/
.imgclass img{
  width: 100%
}
.Thumbnail img:hover {
  box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
.imgclass {
    width: 100%;
    float: left;
}

.imgclass img {
    width: 100%;
    max-width: 500px;
    margin: 50px auto;
    display: block;
}
</style>
@endsection
  <!-- ========  Main  ======== -->
  <div class="row  prefference-tabs">
    <div class="col-md-12 prefference-tabs-content">
      <ul class="nav nav-pills mb-3 prefference" id="pills-tab" role="tablist">
        <li class="nav-item prefference-box" role="presentation">
          <a class="nav-link" href= "{{ route('front.subcategory.slug') }}">
            <h2><span>1</span>{{LanguageHelper::getPhrase('cat_make')}}</h2>
            <section>
              <label>{{LanguageHelper::getPhrase('cat_selected_make')}}:</label>
              <span class="car-model">
                <img src="{{asset('images/ico_arrow_right.png')}} "> {{ ucwords($make) }}
              </span>
              <span>{{LanguageHelper::getPhrase('cat_change_make')}}</span>
            </section>
          </a>
            </li>
            <li class="nav-item prefference-box" role="presentation">
               <a class="nav-link" href= "{{ route('front.subcategory.slug', $makeSlug) }}">
               <!-- <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#" role="tab" aria-controls="pills-home" aria-selected="false"> -->
                  <h2><span>2</span>{{LanguageHelper::getPhrase('cat_model')}}</h2>
                  <section>
                     <label>{{LanguageHelper::getPhrase('cat_selected_make')}}:</label>
                     <span class="car-model"><img src="{{asset('images/ico_arrow_right.png')}} "> {{ ucwords($model) }}</span>
                     <span>{{LanguageHelper::getPhrase('cat_change_model')}}</span>
                  </section>
               </a>
            </li>
            <li class="nav-item prefference-box no-make" role="presentation">
              <a class="nav-link active" href= "#">
               <!-- <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"> -->
                  <h2><span>3</span>{{LanguageHelper::getPhrase('cat_part_group')}}</h2>
                  <section>
                     <span class="car-model">{{LanguageHelper::getPhrase('cat_select_part_group_below')}}</span>
                  </section>
               </a>
            </li>
            <li class="nav-item prefference-box no-select" role="presentation">
               <a class="nav-link" href= "#">
               <!-- <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false"> -->
                  <h2><span>4</span>{{LanguageHelper::getPhrase('cat_part')}}</h2>
                  <section>
                     <span class="car-model"></span>
                  </section>
               </a>
            </li>
         </ul>
         <div class="tab-content" id="pills-tabContent">
            <!-- =================  Tab 2 ================= -->
            <div class="tab-pane active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
               <div class="row cart-part">
                  <div class="col-md-3 cart-part-box" >
                     <div class="cart-part-list">
                        <form >
                           <ul class="check-list">
                              <li>
                                 <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                 <label for="vehicle1">Used pars - <span>325</span></label>
                              </li>
                              <li>
                                 <input type="checkbox" id="vehicle2" name="vehicle1" value="Bike">
                                 <label for="vehicle2">New alt. parts - <span>325</span></label>
                              </li>
                              <li>
                                 <input type="checkbox" id="vehicle3" name="vehicle1" value="Bike">
                                 <label for="vehicle3">Renovated parts -  <span>325</span></label>
                              </li>
                              <li>
                                 <input type="checkbox" id="vehicle4" name="vehicle1" value="Bike">
                                 <label for="vehicle4">New original parts -  <span>325</span></label>
                              </li>
                           </ul>
                        </form>
                        <form class="form-inline my-lg-0">
                           <h6>Text search part name:</h6>
                           <input class="form-control " type="search" placeholder="Ert Z-Nummer" aria-label="Search">
                        </form>
                        <ul>
                          <?php
                          $available_parts = explode(',', $category->available_part);
                          //print_r($available_parts);
                          ?>
                          @foreach($subcategory as $value)
                            @if(in_array($value->id, $available_parts))
                              @php
                                $class = 'highlighted';
                                $getTotalProducts = getTotalProducts($b, $m, $s, $value->id);
                                if($getTotalProducts == 0) $class = 'not-highlight';
                              @endphp
                              <li class="hoverchange available_part {{$class}}" id="{{$value->id}}" data-src="{{asset("storage/$value->cover")}}">
                                <a href="{{route('front.show.all.partgroups',[$value->id,$makeSlug,$model])}}?b={{$b}}&m={{$m}}&s={{$s}}&p={{$value->id}}">{{$value->name}}</a></li>
                            @else
                              <li class="hoverchange" id="{{$value->id}}" data-src="{{asset("storage/$value->cover")}}" ><a href="{{route('front.show.all.partgroups',[$value->id,$makeSlug,$model])}}?b={{$b}}&m={{$m}}&s={{$s}}&p={{$value->id}}">{{$value->name}}</a></li>
                            @endif
                          @endforeach
                           <!-- <li><a href="#">Air conditioning / Heating</a></li>
                           <li><a href="#">Air conditioning / Heating</a></li>
                           <li><a href="#">Air conditioning / Heating</a></li>
                           <li><a href="#">Air conditioning / Heating</a></li>
                           <li><a href="#">Air conditioning / Heating</a></li>
                           <li><a href="#">Air conditioning / Heating</a></li>
                           <li><a href="#">Air conditioning / Heating</a></li>
                           <li><a href="#">Air conditioning / Heating</a></li>
                           <li><a href="#">Air conditioning / Heating</a></li>
                           <li><a href="#">Air conditioning / Heating</a></li> -->
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-9">
                     <div class="imgclass">
                       <img src=" {{asset('images/parts/126.png')}}" alt="Forest">
                    </div>
                     <div class="Thumbnail">
                      @foreach($subcategory as $value)
                      <a href="{{route('front.show.all.partgroups',[$value->id,$makeSlug,$model])}}?b={{$b}}&m={{$m}}&s={{$s}}&p={{$value->id}}">
                        <img class="ishover" id="img-{{$value->id}}" src="{{asset("storage/$value->cover")}}" alt="Forest" style="width:150px">
                      </a>
                      @endforeach
                        </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('js')
<script type="text/javascript">
  $( ".Thumbnail img" ).mouseover(function() {
    $('.imgclass img').attr('src',$(this).attr('src'));
    var imgid = $(this).attr('id');
    var id = imgid.replace('img-','');
    $('.hoverchange').css('text-decoration','');
    $('#'+id).css('text-decoration','underline');
  });
  $( ".hoverchange" ).mouseover(function() {
    var img = $(this).data('src');
    $('.imgclass img').attr('src',img);
    $('.ishover').css('box-shadow','');
    $('#img-'+$(this).attr('id')).css('box-shadow','0 0 2px 1px rgba(0, 140, 186, 0.5)');
  });
  $( ".Thumbnail img" ).click(function() {
    var imgid  = $(this).attr('id');
    var linkid = imgid.replace('img-','');
  });
</script>
@endsection