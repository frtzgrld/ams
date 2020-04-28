
	$(document).ready(function() {
		$("#form_client").validate({
			ignore:'',
			rules: {
				hidden_client_id: {
					required: true,
					maxlength: 11,
					number: true,
				},
				action: {
					required: true,
					maxlength: 11,
				},
				clientname: {
					required: true,
					maxlength: 250,
				},
				location: {
					required: false,
					maxlength: 250,
				},
				barangay: {
					required: true,
					maxlength: 11,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'billing/validate_client',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_client").serialize(),
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
								setTimeout(function(){
									$('#hidden_client_button').click();
									$('#'+($('#datatable_clients').val())).DataTable().ajax.reload(null, false);
								},	1000);
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