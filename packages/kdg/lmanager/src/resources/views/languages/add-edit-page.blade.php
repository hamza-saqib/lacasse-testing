@extends('lmanager::layouts.app')
@section('header_scripts')
	<style type="text/css">
		.validation-error.ng-active p {
    		color: #ffb0b0 !important;
		}
		/* The container */
		.form-group .radio-box {
			display: inline-block;
			position: relative;
			padding-left: 35px;
			margin-bottom: 12px;
			cursor: pointer;
			font-size: 22px;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
			margin-left: 21px;
		}

		/* Hide the browser's default radio button */
		.form-group .radio-box input {
			position: absolute;
			opacity: 0;
			cursor: pointer;
		}

		/* Create a custom radio button */
		.form-group .checkmark {
			position: absolute;
			top: 9px;
			left: 0;
			height: 19px;
			width: 19px;
			background-color: #eee;
			border-radius: 50%;
		}

		/* On mouse-over, add a grey background color */
		.form-group .radio-box:hover input ~ .checkmark {
			background-color: #ccc;
		}

		/* When the radio button is checked, add a blue background */
		.form-group .radio-box input:checked ~ .checkmark {
			background-color: #00b19d;
		}

		/* Create the indicator (the dot/circle - hidden when not checked) */
		.form-group .checkmark:after {
			content: "";
			position: absolute;
			display: none;
		}

		/* Show the indicator (dot/circle) when checked */
		.form-group .radio-box input:checked ~ .checkmark:after {
			display: block;
		}

		/* Style the indicator (dot/circle) */
		.form-group .radio-box .checkmark:after {
		 	top: 6px;
			left: 6px;
			width: 8px;
			height: 8px;
			border-radius: 50%;
			background: white;
		}
	</style>
@stop
@section('content')
	<div id="page-wrapper" ng-app="academia">
		<div class="container-fluid" >
			<!-- Page Heading -->
			<div class="row">
				<div class="col-md-6 offset-md-3">
					<ol class="breadcrumb">
						<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
						<li><a href="{{URL_LANGUAGE_PAGE_LIST}}">{{LanguageHelper::getPhrase('language_pages')}}</a> </li>
						<!-- <li class="active">{{isset($title) ? $title : ''}}</li> -->
					</ol>
				</div>
			</div>
			@include('lmanager::errors.errors')	
			<div class="panel panel-custom col-md-6 offset-md-3" >
				<div class="panel-heading">
					<div class="pull-right messages-buttons">
						<a href="{{URL_LANGUAGE_PAGE_LIST}}" class="btn  btn-primary button" >{{ LanguageHelper::getPhrase('language_pages')}}</a>
					</div>
				<h1>{{ $title }}  </h1>
				</div>
				<div class="panel-body form-auth-style" >
				<?php $button_name = LanguageHelper::getPhrase('create'); ?>
				@if ($record)

				 <?php $button_name = LanguageHelper::getPhrase('update'); ?>
					{{ Form::model($record, 
					array('url' => URL_LANGUAGES_EDIT_PAGE.'/'. $record->id, 
					'method'=>'patch','novalidate'=>'','name'=>'formLanguage')) }}
				@else
					{!! Form::open(array('url' => URL_LANGUAGE_PAGE_ADD, 'method' => 'POST', 'name'=>'formLanguage ', 'novalidate'=>'')) !!}
				@endif

				 @include('lmanager::languages.page_elements', 
				 array('button_name'=> $button_name),
				 array('record' => $record))
				{!! Form::close() !!}
				</div>

			</div>
		</div>
		<!-- /.container-fluid -->
	</div>
	<!-- /#page-wrapper -->
@stop
@section('footer_scripts')
	@include('lmanager::common.validations');
@stop