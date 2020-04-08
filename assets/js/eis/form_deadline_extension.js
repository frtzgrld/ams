
	$(document).ready(function() {

		$("#form_deadline_extension").validate({
			ignore:'',
			rules: {
				hidden_procedure_id: {
					required: false,
					maxlength: 11,
					number: true,
				},
				hidden_action: {
					required: true,
					maxlength: 10,
				},
				hidden_lot_no: {
					required: true,
					maxlength: 30,
				},
				date: {
					required: true,
					maxlength: 11,
				},
				notes: {
					required: true,
					maxlength: 5000,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'file/quotations/extend_deadline',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_deadline_extension").serialize(),
					error: function(response)
					{
						// toggleError(response);
						alert('error');
					},
					success: function(response)
					{
						switch( response['result'] )
						{
							case 'success':
								Custombox.close();
								swal({
									title: response['header'],
									text: response['message'],
									timer: 2000
								});
								setTimeout(function() {
									window.location.reload();
								}, 	3000);
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