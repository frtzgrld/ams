
	$(document).ready(function() {

		$("#form_receive_property").validate({
			ignore:'',
			rules: {
				hidden_property_id: {
					required: true,
					maxlength: 11,
					number: true,
				},
				hidden_return_address: {
					required: false,
					maxlength: 250,
				},
				hidden_action: {
					required: true,
					maxlength: 10,
				},
				item: {
					required: true,
					maxlength: 11,
					number: true,
				},
				property_category: {
					required: true,
					maxlength: 30,
				},
				model: {
					required: false,
					maxlength: 150,
				},
				propertyno: {
					required: true,
					maxlength: 50,
				},
				serialno: {
					required: false,
					maxlength: 50,
				},
				unitcost: {
					required: true,
					maxlength: 30,
					number: true,
				},
				quantity: {
					required: true,
					maxlength: 30,
					number: true,
				},
				dateacquired: {
					required: true,
					maxlength: 30,
				},
				useful_life: {
					required: true,
					maxlength: 4,
					number: true,
				},
				eul_unit: {
					required: true,
					maxlength: 30,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'inventory/property_and_equipment/validate_received_properties',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_receive_property").serialize(),
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
									if( response['redirect'] )
										window.location.href = response['redirect'];
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