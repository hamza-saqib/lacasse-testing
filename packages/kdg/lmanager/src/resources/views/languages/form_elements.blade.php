 					
 					 <fieldset class="form-group" >
						
						{{ Form::label('language', LanguageHelper::getphrase('language')) }}
						<span class="text-red">*</span>
						{{ Form::text('language', $value = null , $attributes = array('class'=>'form-control','name'=>'language', 
							'placeholder' => LanguageHelper::getPhrase('language_title'), 
							'ng-model'=>'language', 
							'required'=> 'true', 
							'id'=>'language',
							'ng-class'=>'{"has-error": formLanguage.language.$touched && formLanguage.language.$invalid}',
							'ng-minlength' => '4',
							'ng-maxlength' => '40',
							)) }}
						<div class="validation-error" ng-messages="formLanguage.language.$error" >
	    					{!! LanguageHelper::getValidationMessage()!!}
	    					{!! LanguageHelper::getValidationMessage('minlength')!!}
	    					{!! LanguageHelper::getValidationMessage('maxlength')!!}
						</div>
					</fieldset>


						<fieldset class="form-group" >
						{{ Form::label('code', LanguageHelper::getphrase('code')) }}
						<span class="text-red">*</span>
						{{ Form::text('code', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => LanguageHelper::getPhrase('language_code'),
							'name'=>'code',
							'ng-model'=>'code',
							'id'=>'code', 
							'required'=> 'true', 
							'ng-minlength' => '2',
							'ng-maxlength' => '4',
							'ng-class'=>'{"has-error": formLanguage.code.$touched && formLanguage.code.$invalid}',
						 		
						)) }}
						
						<div class="validation-error" ng-messages="formLanguage.code.$error" >
	    					{!! LanguageHelper::getValidationMessage()!!}
	    					{!! LanguageHelper::getValidationMessage('minlength')!!}
	    					{!! LanguageHelper::getValidationMessage('maxlength')!!}
						</div>


						<a class="pull-right btn btn-success helper_step2" style="margin-top:10px;" href="https://www.loc.gov/standards/iso639-2/php/code_list.php" target="_blank">
						{{LanguageHelper::getPhrase('supported_language_codes')}}
						</a>
					</fieldset>
					  
					  <div class="row helper_step1">
					<fieldset class='form-group col-md-6 '>
						{{ Form::label('is_rtl', LanguageHelper::getphrase('is_rtl')) }}
						<div class="form-group row">
							<!-- <div class="col-md-6"> -->
							<!-- {{ Form::radio('is_rtl', 0, true, array('id'=>'free', 'name'=>'is_rtl')) }} -->
								
<!-- 								<label for="free"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{LanguageHelper::getPhrase('No')}}</label>  -->
								<label class="radio-box">{{LanguageHelper::getPhrase('No')}}
									<!-- <input type="radio" checked="checked" name="radio"> -->
									{{ Form::radio('is_rtl', 0, true, array('id'=>'free', 'name'=>'is_rtl')) }}
									<span class="checkmark"></span>
								</label>
								<label class="radio-box">{{LanguageHelper::getPhrase('Yes')}}
									<!-- <input type="radio" name="radio"> -->
									{{ Form::radio('is_rtl', 1, false, array('id'=>'paid', 'name'=>'is_rtl')) }}
									<span class="checkmark"></span>
								</label>
							</div>
<!-- 							<div class="col-md-6">
							{{ Form::radio('is_rtl', 1, false, array('id'=>'paid', 'name'=>'is_rtl')) }}
								<label for="paid"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{LanguageHelper::getPhrase('Yes')}} 
								</label>
							</div> -->
						</div>
					</fieldset>
 					
					</div>

					
						<div class="buttons text-center" >
							<button class="btn btn-lg btn-primary button" 
							ng-disabled='!formLanguage.$valid'>{{ $button_name }}</button>
						</div>
		 