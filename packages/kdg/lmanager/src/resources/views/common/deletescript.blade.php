<script>
	function deleteRecord(slug) {
		swal({
			  title: "{{LanguageHelper::getPhrase('are_you_sure')}}?",
			  text: "{{LanguageHelper::getPhrase('you_will_not_be_able_to_recover_this_record')}}!",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "{{LanguageHelper::getPhrase('yes').', '.LanguageHelper::getPhrase('delete_it')}}!",
			  cancelButtonText: "{{LanguageHelper::getPhrase('no').', '.LanguageHelper::getPhrase('cancel_please')}}!",
			  preConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm) {
			  	if (isConfirm) {
			  		var token = '{{ csrf_token()}}';
				  	route = '{{$route}}'+slug;  
				    $.ajax({
				        url:route,
				        type: 'post',
				        data: {_method: 'delete', _token :token},
				        success:function(msg){
				        	result = $.parseJSON(msg);
				        	if(typeof result == 'object')
				        	{
				        		status_message = '{{LanguageHelper::getPhrase('deleted')}}';
				        		status_symbox = 'success';
				        		status_prefix_message = '';
				        		if(!result.status) {
				        			status_message = '{{LanguageHelper::getPhrase('sorry')}}';
				        			status_prefix_message = '{{LanguageHelper::getPhrase("cannot_delete_this_record_as")}}\n';
				        			status_symbox = 'info';
				        		}
				        		swal(status_message+"!", status_prefix_message+result.message, status_symbox);
				        	}
				        	else {
					        	swal("{{LanguageHelper::getPhrase('deleted')}}!", "{{LanguageHelper::getPhrase('your_record_has_been_deleted')}}", "success");
				        	}
				        	tableObj.ajax.reload();
				        }
				    });
				} else {
				    swal("{{LanguageHelper::getPhrase('cancelled')}}", "{{LanguageHelper::getPhrase('your_record_is_safe')}} :)", "error");
			}
		});
	}
</script>