
	$(document).ready(function()
	{
		$("#form_distribution_property").validate({
			rules: {
				hidden_action: {
					required: true,
					maxlength: 6,
				},
				hidden_distribution_id: {
					required: true,
					number: true,
				},
				property: {
					required: true,
				},
				quantity: {
					required: true,
					number: true,
				},
				propertyno: {
					required: true,
				},
				assignedto: {
					required: true,
				},
				assigneddate: {
					required: true,
				}
			},
			
			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},
			
			submitHandler: function(ev)
			{
				$.ajax({
					url: base_url + 'distribution/validate_distribution_of_property',
					method: 'POST',
					dataType: 'json',
					async: true,   
					data: $('#form_distribution_property').serialize(),
					error: function(response)
					{
						alert('Error');
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

    function getPropertyNos( status )
    {
        var itemid = $('#property').val();

        $.ajax({
            url: base_url + 'inventory/property_and_equipment/get_property_nos',
            method: 'POST',
            dataType: 'json',
            async: true,
            data: {itemid: itemid, status: status},
            error: function(response)
            {
                alert('error');
            },
            success: function(response)
            {
                if(response.length == 0) {
                    $('#propertyno').html("No record found");
                } else {
                    $('#propertyno').empty();
                    $.each(response, function(index, value){
                        $('#propertyno').append($("<option selected></option>").attr("value",response[index]['PROPERTYNO'])
                            .text(response[index]['PROPERTYNO']));
                    });
                }
            }
        });
    }