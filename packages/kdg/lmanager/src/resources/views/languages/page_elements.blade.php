<fieldset class="form-group" >
	{{ Form::label('title', LanguageHelper::getphrase('page_title')) }}
	<span class="text-red">*</span>
	{{ Form::text('title', $value = null , $attributes = array('class'=>'form-control','name'=>'title', 
		'placeholder' => LanguageHelper::getPhrase('page_title'), 
		'ng-model'=>'title', 
		'required'=> 'true', 
		'id'=>'title',
		'ng-class'=>'{"has-error": formLanguage.title.$touched && formLanguage.title.$invalid}',
		)) }}
	<div class="validation-error" ng-messages="formLanguage.title.$error" >
		{!! LanguageHelper::getValidationMessage()!!}
	</div>
</fieldset>
<div class="row helper_step1">
	<fieldset class='form-group col-md-6 '>
		{{ Form::label('is_rtl', LanguageHelper::getphrase('is_active')) }}
		<div class="form-group row">
			<label class="radio-box">{{LanguageHelper::getPhrase('No')}}
				{{ Form::radio('is_active', 0, true, array('id'=>'free', 'name'=>'is_active')) }}
				<span class="checkmark"></span>
			</label>
			<label class="radio-box">{{LanguageHelper::getPhrase('Yes')}}
				{{ Form::radio('is_active', 1, false, array('id'=>'paid', 'name'=>'is_active')) }}
				<span class="checkmark"></span>
			</label>
		</div>
	</fieldset>
</div>
<div class="buttons text-center" >
	<button class="btn btn-lg btn-primary button" ng-disabled='!formLanguage.$valid'>{{ $button_name }}</button>
</div>