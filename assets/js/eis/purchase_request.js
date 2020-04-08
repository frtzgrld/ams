
		$(document).ready(function()
		{
			$("#form_purchase_request").validate({
				rules: {
					form_billing_option: {
						required: true,
					},
					form_enter_key: {
						required: true,
					},
				},
				
				// highlight: function(element){
				// 	$(element).closest('.form-group').addClass('has-error');
				// },
				
				// unhighlight: function(element)
				// {
				// 	$(element).closest('.form-group').removeClass('has-error');
				// },

				// errorPlacement: function (error, element)
				// {
				// 	if(element.closest('.input-group').length)
				// 	{
				// 		error.insertAfter(element.closest('.input-group'));
				// 	}
				// 	else 
				// 	{
				// 		error.insertAfter(element);
				// 	}
				// },
				
				submitHandler: function(ev)
				{
					alert();
					$.ajax({
						url: base_url + 'wrd/annual_water_charge/validate_form_billing_option',
						method: 'POST',
						dataType: 'json',
						async: true,   
						data: $('#form_purchase_request').serialize(),
						error: function(response)
						{
							alert('Error');
						},
						success: function(response)
						{

						}
					});
							
				}
			});
			
		});
	