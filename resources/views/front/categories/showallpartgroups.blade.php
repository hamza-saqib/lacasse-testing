@extends('layouts.front.app')
@section('og')

@endsection
@section('css')

@endsection
@section('content')
<main>
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
               <a class="nav-link" href= "{{ route('front.subcategory.slug', [$make]) }}">
                  <h2><span>2</span>{{LanguageHelper::getPhrase('cat_model')}}</h2>
                  <section>
                     <label>{{LanguageHelper::getPhrase('cat_selected_make')}}:</label>
                     <span class="car-model"><img src="{{asset('images/ico_arrow_right.png')}} "> {{ ucwords($model) }}</span>
                     <span>{{LanguageHelper::getPhrase('cat_change_model')}}</span>
                  </section>
               </a>
            </li>
            <li class="nav-item prefference-box no-make" role="presentation">
              <a class="nav-link" href= "{{ route('front.getpartgroups.slug', [$model]) }}?b={{$b}}&m={{$m}}&s={{$s}}&p={{$p}}">
                  <h2><span>3</span>{{LanguageHelper::getPhrase('cat_part_group')}}</h2>
                  <section>
                      <label>{{LanguageHelper::getPhrase('cat_selected_part_group')}}:</label>
                     <span class="car-model"><img src="{{asset('images/ico_arrow_right.png')}}">{{ ucwords($partgroupname)}}</span>
                      <span>{{LanguageHelper::getPhrase('cat_change_part_group')}}</span>
                  </section>
               </a>
            </li>
            <li class="nav-item prefference-box no-select" role="presentation">
               <a class="nav-link active" href= "{{ route('front.getpartgroups.slug', [$model]) }}">
                  <h2><span>4</span>{{LanguageHelper::getPhrase('cat_part')}}</h2>
                  <section>
                     <span class="car-model">{{LanguageHelper::getPhrase('cat_select_part_below')}}</span>
                  </section>
               </a>
            </li>
         </ul>
         <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade active show" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
               <div class="row cart-part-2">
                  <div class="col-md-8 part-list">
                     <h3 class="most_searched_parts">{{LanguageHelper::getPhrase('cat_most_searched_parts')}}</h3>
                     <ul>
                        @foreach($mostSearchedParts as $part)
                           @php
                           //echo $part->id;
                           //echo $make;
                           //$makeProducts = countMakeProducts($make, $part->id);
                           $makeProducts = countMakeProducts2($b, $m, $s, $p, $part->parent_id, $part->id);
                           @endphp
                           <li class="part-subcat @if($makeProducts) has-products @endif ">
                              <a href="{{route('front.show.all.products',[$ispart,$part->id,$make,$model])}}?b={{$b}}&m={{$m}}&s={{$s}}&p={{$p}}" >
                                 {{$part->name}}
                              </a>
                           </li>
                        @endforeach
                     </ul>
                  </div>
                  <div class="col-md-4 cart-part-pic">
                     <img src="{{asset('storage/'.$partgroup->cover)}}" alt="">
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12 part-list">
                     @foreach($partgroups as $part)
                        <div class="list-heading"><h6>{{$part->name}}</h6></div>
                        <div class="parts-categories">
                           @php
                           //dd($partgroupsSubCats[$part->id]);
                           @endphp
                           @foreach($partgroupsSubCats[$part->id] as $key => $value)
                              @php
                              //echo $key;
                              // Count products in this make and part category
                              //$makeProducts = countMakeProducts($make, $key);
                              $makeProducts = countMakeProducts2($b, $m, $s, $p, $part->id, $key);
                              @endphp
                              <div class="part-subcat @if($makeProducts) has-products @endif">
                                 <a href="{{route('front.show.all.products',[$ispart,$key,$make,$model])}}?b={{$b}}&m={{$m}}&s={{$s}}&p={{$p}}">{{$value}}</a>
                              </div>
                           @endforeach
                        </div>
                     @endforeach
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</main>
@endsection
@section('js')

@endsection