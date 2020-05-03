
	$(document).ready(function() {

		$("#form_distribute_supply").validate({
			ignore:'',
			rules: {
				hidden_distrib_id: {
					required: true,
					maxlength: 11,
				},
				hidden_action: {
					required: true,
					maxlength: 10,
				},
				item: {
					required: true,
					maxlength: 11,
				},
				office: {
					required: true,
					maxlength: 11,
				},
				quantity: {
					required: true,
					maxlength: 11,
				},
				dateissued: {
					required: true,
					maxlength: 50,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'distribution/validate_issuance_of_supply',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_distribute_supply").serialize(),
					error: function(response)
					{
						// toggleError(response);
						// alert('error');
					},
					success: function(response)
					{
						switch( response['result'] )
						{
							case 'success':
								swal(response['header'], response['message'], "success");
								setTimeout(function() {
									if( response['popup'] )
										popup_window( response['popup'] );
								}, 	1000);
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