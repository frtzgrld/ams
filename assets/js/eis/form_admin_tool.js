
	$(document).ready(function() {

		$("#form_admin_tool").validate({
			ignore:'',
			rules: {
				document: {
					required: true,
					maxlength: 250,
				},
				accounting: {
					required: true,
					maxlength: 11,
					number: true,
				},
				treasurer: {
					required: true,
					maxlength: 11,
					number: true,
				},
				agency_head: {
					required: true,
					maxlength: 11,
					number: true,
				},
				na: {
					required: true,
					maxlength: 30,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'offices/validate_document_sign',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_admin_tool").serialize(),
					error: function(response)
					{
						alert('error');
					},
					success: function(response)
					{
						switch( response['result'] )
						{
							case 'success':
								$('#admin_tool_result').html('<span class="text-success">'+response['message']+'</span>');
								break;

							case 'error':
								$('#admin_tool_result').html('<span class="text-danger">'+response['message']+'</span>');
								break;

							default:
								$('#admin_tool_result').html('<span class="text-info">'+response['message']+'</span>');
								break;
						}

						setTimeout(function(){
							$('#admin_tool_result').empty();
						}, 3000);
					}
				});
			}
		});
	});