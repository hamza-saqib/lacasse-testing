<fieldset class="form-group" >
	{{ Form::label('token_label', LanguageHelper::getphrase('token_label')) }}
	<span class="text-red">*</span>
	{{ Form::text('token_label', $value = null , $attributes = array('class'=>'form-control','name'=>'token_label', 
		'placeholder' => LanguageHelper::getPhrase('token_label'), 
		'ng-model'=>'token_label', 
		'required'=> 'true', 
		'id'=>'token_label',
		'ng-class'=>'{"has-error": formLanguage.token_label.$touched && formLanguage.token_label.$invalid}',
		'ng-minlength' => '2',
		'ng-maxlength' => '400',
		))
	}}
	<div class="validation-error" ng-messages="formLanguage.token_label.$error" >
		{!! LanguageHelper::getValidationMessage()!!}
		{!! LanguageHelper::getValidationMessage('minlength')!!}
		{!! LanguageHelper::getValidationMessage('maxlength')!!}
	</div>
</fieldset>

<fieldset class="form-group" >
	{{ Form::label('default_value', LanguageHelper::getphrase('default_value')) }}
	<span class="text-red">*</span>
	{{ Form::text('default_value', $value = null , $attributes = array('class'=>'form-control', 
		'placeholder' => LanguageHelper::getPhrase('default_value'),
		'name'=>'default_value',
		//'ng-model'=>'default_value',
		'id'=>'default_value', 
		'required'=> 'false', 
		//'ng-minlength' => '0',
		//'ng-class'=>'{"has-error": formLanguage.default_value.$touched && formLanguage.default_value.$invalid}',
		))
	}}
	<div class="validation-error" ng-messages="formLanguage.default_value.$error" >
		{!! LanguageHelper::getValidationMessage()!!}
		{!! LanguageHelper::getValidationMessage('minlength')!!}
		{!! LanguageHelper::getValidationMessage('maxlength')!!}
	</div>
</fieldset>
<fieldset class="form-group">
	@php
	$languagePages = \App\LanguagePage::where('is_active', 1)->get();
	$selected = '';
	@endphp
	{{ Form::label('language', LanguageHelper::getphrase('add_pages')) }}
	<span class="text-red">*</span>
	<select class="form-control" name="lpage">
		<option value="0">{{LanguageHelper::getphrase('select_page')}}</option>
		@foreach($languagePages as $lp)
			@php
				$selected = '';
				if($record)
					if($record->language_pages_id == $lp->id)
					{
						$selected = 'selected="selected"';
					}
			@endphp
			
	    	<option value="{{$lp->id}}" {{$selected}}>{{$lp->title}}</option>
	    @endforeach
	</select>
</fieldset>

<div class="buttons text-center" >
	<button class="btn btn-lg btn-primary button" ng-disabled='!formLanguage.$valid'>{{ $button_name }}</button>
</div>	 