
	$(document).ready(function() {

		$("#form_checklist_item").validate({
			ignore:'',
			rules: {
				hidden_chk_id: {
					required: true,
					maxlength: 11,
					number: true,
				},
				action: {
					required: true,
					maxlength: 10,
				},
				chk_desc: {
					required: true,
					maxlength: 250,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'vouchers/validate_checklist_item',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_checklist_item").serialize(),
					error: function(response)
					{
						alert('error');
					},
					success: function(response)
					{
						Custombox.close();
						switch( response['result'] )
						{
							case 'success':
								swal({
									title: response['header'],
									text: response['message'],
									timer: 1000
								});
								break;

							default:
								// financerLogin.resetProgressBar(true);
								break;
						}
					}
				});
			}
		});
	});