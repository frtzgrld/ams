
	$(document).ready(function() {
		$("#form_property_disposal").validate({
			ignore:'',
			rules: {
				disposing_item: {
					required: true,
					maxlength: 11,
					number: true,
				},
				disp_type: {
					required: true,
					maxlength: 11,
					number: true,
				},
				disposing_qty: {
					required: false,
					maxlength: 11,
					number: true,
				},
				propertyno: {
					required: true,
					maxlength: 11,
				},
				remark: {
					required: false,
					maxlength: 3000,
				},
			},

			errorPlacement: function (error, element) {
				alert();
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'inventory/validate_disposal',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_property_disposal").serialize(),
					error: function(response)
					{
						alert('error');
					},
					success: function(response)
					{
						Custombox.close();
						switch( response['result'] )
						{
							case 'success':
								swal({
									title: response['header'],
									text: response['message'],
									timer: 1000
								});

								$('#'+($('#datatable_reload').val())).DataTable().ajax.reload(null, false);
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

	function toggle_disposal( item_id=null, category=null, datatable_reload=null, status=null )
    {
		$("#disposing_qty").val(1);
		$("#remark").val('');

		$.ajax({
			url: base_url + 'items/get_items',
			method: 'POST',
			dataType: 'json',
			async: true,
			data: {category: category, leafonly: true, itemid: item_id},
			error: function(response)
			{
				alert('error');
			},
			success: function(response)
			{
				if(response.length == 0) {
                    $('#disposing_item').html("No record found");
                } else {
                    $('#disposing_item').empty();
                    $.each(response, function(index, value){
                        $('#disposing_item').append($("<option selected></option>").attr("value",response[index]['ID'])
                        	.text(response[index]['DESCRIPTION'])); 

                        if( item_id )
                        {
                        	$('#disposing_item').select2('val', response[index]['ID']);
                        	getPropertyNos( status );
                        }
                    });

                    $("#disposing_qty").TouchSpin({
                    	min: 1,
                    	max: parseInt(response[0]['NO_OF_STOCKS']),
			            buttondown_class: "btn btn-danger btn-trans",
			            buttonup_class: "btn btn-success btn-trans"
			        });
                }
			}
		});

    	if( datatable_reload )
    	{
    		$('#datatable_reload').val(datatable_reload);
    	}

        $('#hidden_disp_button').click();
    }

    function getPropertyNos( status )
    {
    	var itemid = $('#disposing_item').val();

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
                        	.text(response[index]['PROPERTYNO'] + ': ' + (response[index]['ASSIGNEDTO']==null?'':response[index]['ASSIGNEDTO'])));
                    });
                }
			}
		});
    }