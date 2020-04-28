
	$(document).ready(function() {

		$("#form_quotation").validate({
			ignore:'',
			rules: {
				hidden_quotation_id: {
					required: true,
					maxlength: 11,
					number: true,
				},
				hidden_action: {
					required: true,
					maxlength: 10,
				},
				rq_quot_no: {
					required: true,
					maxlength: 30,
				},
				rq_pr_no: {
					required: true,
					maxlength: 11,
					number: true,
				},
				rq_app: {
					required: true,
					maxlength: 11,
					number: true,
				},
				rq_canvas_no: {
					required: true,
					maxlength: 10,
				},
				rq_date: {
					required: true,
					maxlength: 50,
				},
				rq_authority: {
					required: true,
					maxlength: 11,
				},
				rq_auth_no: {
					required: true,
					maxlength: 50,
				},
				rq_auth_date: {
					required: true,
					maxlength: 50,
				},
				rq_deadline: {
					required: true,
					maxlength: 50,
				}
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'file/quotations/validate_quotation',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_quotation").serialize(),
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
								swal({
									title: response['header'],
									text: response['message'],
									timer: 1000
								});
								setTimeout(function() {
									if( response['redirect'] != null )
										window.location.replace = response['redirect'];
								}, 	2500);
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