@extends('lmanager::layouts.app')
@section('header_scripts')
	<style type="text/css">
		.list-group .row {
   			 margin: 0;
		}
		#myModal .modal .modal-dialog .modal-content{
			border-radius: 8px;
		}
		#myModal .form-control{
			background-color: transparent;
			border: 1px solid #4c5a67;
			border-width: 0 0 1px 0;
			border-radius: 0;
			color:#666!important;
		}
		#myModal .form-control:focus{
			background: transparent;
		}
		form .buttons.text-center {
		    position: fixed;
		    bottom: 10px;
		    z-index: 1;
		    right: 35%;
		    transform: translateX(-50%);
		}
		/* clear fix */
		.isotope:after {
		  content: '';
		  display: block;
		  clear: both;
		}
	</style>
@stop
@section('content')

	<div id="page-wrapper">
		<div class="container-fluid">
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-6">
					<ol class="breadcrumb">
						<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
						<li><a href="{{URL_LANGUAGES_LIST}}">{{ LanguageHelper::getPhrase('languages')}}</a> </li>
						<li>{{ $title }}</li>
					</ol>
				</div>
				<div class="col-lg-6">
					<fieldset class="form-group">
						@php
						$items = \App\LanguagePage::where('is_active', 1)->get();
						@endphp
						{{ Form::label('language', LanguageHelper::getphrase('add_pages')) }}
						<span class="text-red">*</span>
						<select class="form-control filters-select" name="lpage">
							<option value="*">{{LanguageHelper::getphrase('select_page')}}</option>
							@foreach($items as $pages)
						    	<option value=".grid-item-{{$pages->id}}">{{$pages->title}}</option>
						    @endforeach
						</select>
					</fieldset>
				</div>
			</div>
			<?php
			$language_data = json_decode($record->phrases,true);
			//$language_data['sqlstate'] ="dd";
			/*echo '<pre>';
			print_r($language_data);
			die;*/
			?>			
			<!-- /.row -->
			<div class="panel panel-custom">
				<div class="panel-heading">
					<h1>{{ $title }}</h1>
				</div>
				<div class="panel-body packages">
					{!! Form::open(array('url' => URL_LANGUAGES_UPDATE_STRINGS.'/'.$record->slug, 'method' => 'PATCH', 
					'novalidate'=>'','name'=>'formSettings ', 'files'=>'true')) !!}
						<div class="table-responsive"> 
							<ul class="list-group">

								<div class="row grid"  data-isotope="">
									@if($defaults)
										@foreach($defaults as $key=>$value)
											<?php
											$token_value = isset($language_data[$value['token_label']])?$language_data[$value['token_label']]:$value['default_value'];
											?>
											<div class="col-md-6 grid-item-{{$value['language_pages_id']}}" data-category="grid-item-{{$value['language_pages_id']}}">
												<fieldset class="form-group">
					   								{{ Form::label($value['token_label'], $value['token_label']) }}
													<input type="text" class="form-control" name="{{$value['token_label']}}" required="true" value = "{{$token_value}}" >
												</fieldset>
											</div>
										@endforeach
									@else
						  				<li class="list-group-item">{{ LanguageHelper::getPhrase('no_settings_available')}}</li>
					  				@endif

									{{--@if(count($language_data))
										@foreach($language_data as $key=>$value)
				 							<div class="col-md-6">
												<fieldset class="form-group">
					   								{{ Form::label($key, $key) }}
													<input type="text" class="form-control" name="{{$key}}" required="true" value = "{{$value}}" >
												</fieldset>
											</div>
										@endforeach
									@else
						  				<li class="list-group-item">{{ LanguageHelper::getPhrase('no_settings_available')}}</li>
					  				@endif
					  				--}}
								</div>
							</ul>
						</div>
						@if($language_data)
							<div class="buttons text-center">
								<button class="btn btn-lg btn-primary button" ng-disabled='!formTopics.$valid'>{{ LanguageHelper::getPhrase('update') }}</button>
							</div>
						@endif
					{!! Form::close() !!}
				</div>
			</div>
		</div>
		<!-- /.container-fluid -->
	</div>
	
@endsection
@section('footer_scripts')
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script type="text/javascript">
    $('.grid').isotope({
      itemSelector: '.grid-item',
      layoutMode: 'masonry',
      percentPosition: true,
      stamp: '.stamp',
      originLeft: true,
      originTop: true,
      filter: null,
      getSortData: null,
      sortBy: 'number',
      sortAscending: true,
      stagger: 30,
      transitionDuration: '0.4s',
      containerStyle: null,
      resize: true
    });
    var $grid = $('.grid').isotope({
	  itemSelector: '.element-item',
	  layoutMode: 'fitRows'
	});
    $('.filters-select').on( 'change', function() {
      // get filter value from option value
      var filterValue = this.value;
      $grid.isotope({ filter: filterValue });
    });
</script>
@stop