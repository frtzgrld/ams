
	$(document).ready(function() {

		$("#form_purchase_request").validate({
			ignore:'',
			rules: {
				hidden_pr_id: {
					required: true,
					maxlength: 11,
					number: true,
				},
				hidden_office_id: {
					required: true,
					maxlength: 11,
					number: true,
				},
				action: {
					required: true,
					maxlength: 6,
				},
				pr_no: {
					required: true,
					maxlength: 30,
	                remote: {
	                    url: base_url+'purchase_requests/unique_pr_number',
	                    type: "post",
	                    data: {
	                        hidden_pr_id: function() {
	                            return $("#hidden_pr_id").val();
	                        }
	                    }
	                }
				},
				pr_date: {
					required: true,
					maxlength: 30,
				},
				resp_center: {
					required: true,
					maxlength: 150,
				},
				// sai_no: {
				// 	required: false,
				// 	maxlength: 25,
				// },
				// sai_date: {
				// 	required: false,
				// 	maxlength: 30,
				// },
				purpose: {
					required: true,
					maxlength: 1000,
				},
				requested_by: {
					required: true,
					maxlength: 250,
				},
				req_design: {
					required: true,
					maxlength: 250,
				},
				approved_by: {
					required: false,
					maxlength: 250,
				},
				app_desig: {
					required: false,
					maxlength: 250,
				},
			},

			messages: {
				pr_no: {
					maxlength: "The SAI number should not exceed 30 characters long"
				},
				sai_no: {
					required: "Please provide SAI no.",
					maxlength: "The SAI number should not exceed 25 characters long"
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'purchase_requests/validate_purchase_request_form',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_purchase_request").serialize(),
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