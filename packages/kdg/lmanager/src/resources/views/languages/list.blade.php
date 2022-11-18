@extends('lmanager::layouts.app')
@section('header_scripts')
	<script src="{{asset('backend/assets/js/sweetalert-dev.js')}}"></script>
	<link rel="stylesheet" href="{{asset('backend/assets/css/sweetalert.css')}}" id="theme-styles">
	<style type="text/css">
		a#dLabel {border: 1px solid #000;}
	</style>
@stop
@section('content')

<div id="page-wrapper">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{--PREFIX--}}"><i class="mdi mdi-home"></i></a> </li>
							<li>{{ $title }}</li>
						</ol>
					</div>
				</div>
								
				<!-- /.row -->
				<div class="panel panel-custom">
					<div class="panel-heading">
						
						<div class="pull-right messages-buttons">
							 
							<a href="{{URL_LANGUAGES_ADD}}" class="btn  btn-primary button helper_step1" >{{ LanguageHelper::getPhrase('create')}}</a>
							 
						</div>
						<h1>{{ $title }}</h1>
					</div>
					<div class="panel-body packages">
						<div> 
						<table class="table table-striped table-bordered datatable" cellspacing="0" width="100%">
							<thead>
								<tr>
									 
									<th>{{ LanguageHelper::getPhrase('language')}}</th>
									<th>{{ LanguageHelper::getPhrase('code')}}</th>
									<th>Is RTL</th>
									<th id="helper_step2">{{ LanguageHelper::getPhrase('default_language')}}</th>
							 		<th id="helper_step3">{{ LanguageHelper::getPhrase('action')}}</th>
								  
								</tr>
							</thead>
							 
						</table>
						</div>

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
@endsection
 

@section('footer_scripts')
  	@include('lmanager::common.datatables', array('route'=>'languages.dataTable'))
 	@include('lmanager::common.deletescript', array('route'=>URL_LANGUAGES_DELETE))
@stop