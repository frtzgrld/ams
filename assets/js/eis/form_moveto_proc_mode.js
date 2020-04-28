
	$(document).ready(function() {

		$("#form_assign_proc_mode").validate({
			ignore:'',
			rules: {
				hidden_pr_id: {
					required: true,
					maxlength: 10,
				},
				hidden_mode_id: {
					required: true,
					maxlength: 30,
				},
				description: {
					required: true,
					maxlength: 250,
				},
				class: {
					required: true,
				},
				proc_id: {
					required: true,
					maxlength: 11,
					number: true,
				},
				proc_dates: {
					required: true,
					maxlength: 30,
				},
				remark: {
					required: false,
					maxlength: 5000,
				}
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'procurement/validate_procurement',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_assign_proc_mode").serialize(),
					error: function(response)
					{
						alert();
					},
					success: function(response)
					{
						switch( response['result'] )
						{
							case 'success':
								swal(response['header'], response['message'], "success");
								if( response['redirect'] )
									setTimeout(function(){
										window.location.href = response['redirect'];
									},	1500);
								break;

							default:
								
								break;
						}
					}
				});
			}
		});
	});