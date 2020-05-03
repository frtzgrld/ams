
	$(document).ready(function()
	{
		$("#form_bidding_procedure").on('submit',(function(e) 
		{
			e.preventDefault();

			if($('#form_bidding_procedure').valid())
			{
				// Loader();
				$.ajax({
					url: base_url + 'procurement/bidding/validate_procedure',
					type: "POST",
					data: new FormData(this),
					contentType: false, 
					cache: false, 
					processData:false,
					dataType: 'JSON',
					error: function(response)
					{
						alert('error');
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
		}));
	});
	/*
	$(document).ready(function() {

		$("#form_bidding_procedure").validate({
			ignore:'',
			rules: {
				hidden_procedure_id: {
					required: true,
					maxlength: 11,
				},
				hidden_bidding_id: {
					required: true,
					maxlength: 11,
				},
				hidden_lot_id: {
					required: true,
					maxlength: 11,
				},
				hidden_lot_no: {
					required: true,
					maxlength: 11,
				},
				sessiondate: {
					required: true,
					maxlength: 50,
				},
				notes: {
					required: false,
					maxlength: 1000,
				},
				attachment: {
					required: false,
					maxlength: 300,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function(e) {

			    // var formData = new FormData();
				
				// var formData = $('#form_bidding_procedure').serialize();
				// e.preventDefault();
				$.ajax({
					url: base_url + 'procurement/bidding/validate_procedure',
					method: 'POST',
					data: new FormData(),
					cache: false,
					dataType: 'json',
					async: true,
					processData: false, // Don't process the files
					contentType: false, // Set content type to false as jQuery will tell the server its a query string request
					error: function(response)
					{
						alert('error');
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
	*/