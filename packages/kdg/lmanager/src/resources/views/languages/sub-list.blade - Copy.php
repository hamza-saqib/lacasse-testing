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
	</style>
@stop
@section('content')

	<div id="page-wrapper">
		<div class="container-fluid">
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<ol class="breadcrumb">
						<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
						<li><a href="{{URL_LANGUAGES_LIST}}">{{ LanguageHelper::getPhrase('languages')}}</a> </li>
						<li>{{ $title }}</li>
					</ol>
					<div class="pull-right messages-buttons">
						<button type="button" class="btn btn-primary  button helper_step1" data-toggle="modal" data-target="#myModal">{{LanguageHelper::getPhrase('create_token')}}</button>
						<!-- <a href="javascript:" class="btn  btn-primary button helper_step1">{{ </a> -->
					</div>
				</div>
			</div>
			<?php
			$language_data = json_decode($record->phrases,true);
			$language_data['sqlstate'] ="dd";
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
								<div class="row">
									@if(count($language_data))
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
								</div>
							</ul>
						</div>
						@if(count($language_data))
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
	<!-- The Modal -->
	<div class="modal" id="myModal" ng-app="academia">
	  	<div class="modal-dialog modal-dialog-centered">
	    	<div class="modal-content">
	    		{!! Form::open(array('url' => URL_LANGUAGES_CREATE_STRING, 'method' => 'PATCH', 
					'novalidate'=>'','name'=>'createToken')) !!}
				<!-- Modal Header -->
		      	<div class="modal-header text-center">
			        <h4 class="modal-title w-100 font-weight-bold">{{LanguageHelper::getPhrase('create_token')}}</h4>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          	<span aria-hidden="true">&times;</span>
			        </button>
			    </div>
			    <div class="modal-body mx-3">
			        <div class="md-form mb-5">
			          	<fieldset class="form-group" >
							
							{{ Form::label('token_label', LanguageHelper::getphrase('token_label')) }}
							<span class="text-red">*</span>
							{{ Form::text('token_label', $value = null , $attributes = array('class'=>'form-control','name'=>'token_label', 
								'placeholder' => LanguageHelper::getPhrase('token_label'), 
								'ng-model'=>'token_label', 
								'required'=> 'true', 
								'id'=>'token_label',
								'ng-class'=>'{"has-error": createToken.token_label.$touched && createToken.token_label.$invalid}',
								'ng-minlength' => '2',
								'ng-maxlength' => '40',
								)) }}
							<div class="validation-error" ng-messages="createToken.token_label.$error" >
		    					{!! LanguageHelper::getValidationMessage()!!}
		    					{!! LanguageHelper::getValidationMessage('minlength')!!}
		    					{!! LanguageHelper::getValidationMessage('maxlength')!!}
							</div>
						</fieldset>

			          	<!-- <input type="email" id="defaultForm-email" class="form-control validate">
			          	<label data-error="wrong" data-success="right" for="defaultForm-email">{{LanguageHelper::getPhrase('token_label')}}</label> -->
			        </div>
			        <div class="md-form mb-4">
			        	<!-- <fieldset class="form-group" >
							
							{{ Form::label('default_value', LanguageHelper::getphrase('default_value')) }}
							<span class="text-red">*</span>
							{{ Form::text('default_value', $value = null , $attributes = array('class'=>'form-control','name'=>'default_value', 
								'placeholder' => LanguageHelper::getPhrase('default_value'), 
								'ng-model'=>'default_value', 
								'required'=> 'true', 
								'id'=>'default_value',
								'ng-class'=>'{"has-error": createToken.default_value.$touched && createToken.default_value.$invalid}',
								'ng-minlength' => '4',
								'ng-maxlength' => '40',
								)) }}
							<div class="validation-error" ng-messages="createToken.default_value.$error" >
		    					{!! LanguageHelper::getValidationMessage()!!}
		    					{!! LanguageHelper::getValidationMessage('minlength')!!}
		    					{!! LanguageHelper::getValidationMessage('maxlength')!!}
							</div>
						</fieldset> -->
			          	<input type="text" id="defaultForm-pass" class="form-control validate">
			          	<label data-error="wrong" data-success="right" for="defaultForm-pass">{{LanguageHelper::getPhrase('default_value')}}</label>
			        </div>
				</div>
				<!-- Modal footer -->
		      	<div class="modal-footer">
		      		<button class="btn btn-default" ng-disabled='!createToken.$valid'>{{LanguageHelper::getPhrase('submit')}}</button>
		        	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		      	</div>
		      	{!! Form::close() !!}
			</div>
	  	</div>
	</div>
@endsection
@section('footer_scripts')
	@include('lmanager::common.validations');
@stop