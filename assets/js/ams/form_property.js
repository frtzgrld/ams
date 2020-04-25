$(document).ready(function () {
	$("#form_prop").validate({
		ignore:'',
		rules: {
			hidden_prop_id: {
				required: true,
				maxlength: 11,
				number: true,
			},
			property_no: {
				required: true,
				maxlength: 250,
			},
			property: {
				required: true,
				maxlength: 250,
			},
			description: {
				required: true,
				maxlength: 250,
			},
			unit_cost: {
				required: true,
				maxlength: 250,
			}
		},

		errorPlacement: function (error, element) {
			$(element).closest('.form-group').find('.error-message').html(error);
		},

		submitHandler: function() {
			$.ajax({
				url: base_url + 'properties_and_equipment/validate_property',
				method: 'POST',
				data: $('#form_prop').serialize(),
				cache: false,
				dataType: 'json',
				async: true,
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
							$('#datatable_properties').DataTable().ajax.reload(null, false);
							setTimeout(function(){
								swal(response['header'], response['message'], "success");
							},  500 );
							break;

						default:
							break;
					}
				}
			});
		}
	});
});

function toggleDeleteAlert( office_id )
{
	swal({
		title: "Are you sure?",
		text: "You will not be able to recover this imaginary file!",
		type: "error",
		showCancelButton: true,
		confirmButtonClass: 'btn-danger waves-effect waves-light',
		confirmButtonText: 'Delete!'
	});
}

	function toggle_prop( prop_id )
	{
		$('#hidden_prop_id').val('0');
		$('#action').val("insert");
		$('#property').val('').trigger('change');
		$('#property_no').val('');
		$('#unit_cost').val('');
		$('#estimated_useful_life').val('');
		$('#eul_unit').val('');
		$('#date_acquired').val('');

		if( prop_id )
		{
			$.ajax({
				url: base_url + 'properties_and_equipment/load_prop',
				method: 'POST',
				data: {prop_id: prop_id},
				cache: false,
				dataType: 'json',
				async: true,
				error: function(response)
				{
					alert('error');
				},
				success: function(response)
				{
					if( response )
					{
						$('#hidden_prop_id').val(response[0]['ID']);
						$('#action').val("update");
						$('#property').val(response[0]['ITEMS']).trigger('change');
						$('#property_no').val(response[0]['PROPERTYNO']);
						$('#unit_cost').val(response[0]['UNITCOST']);
						$('#description').val(response[0]['DESCRIPTION']);
						$('#estimated_useful_life').val(response[0]['EST_USEFUL_LIFE']);
						$('#eul_unit').val(response[0]['EUL_UNIT']);
						$('#date_acquired').val(response[0]['DATEACQUIRED']);
					}
				}
			});
		}

		$('#hidden_item_button').click();
	}
