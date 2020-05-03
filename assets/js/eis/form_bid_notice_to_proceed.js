
	$(document).ready(function() {
		load_bidder_proceed_dynamic( lot_id );
	});

	function load_bidder_proceed_dynamic( lot_id )
	{
		$('#div_load_bidder_proceed').load( base_url + 'procurement/bidding/load_bidder_proceed/' + lot_id );
	}

	function toggle_bidder_proceed( matrix_id, proceeded )
	{
		var alert_type = (proceeded==1) ? 'info' : 'warning';

		swal({
            title: "Are you sure?",
            text: "This action is reversible",
            type: alert_type,
            showCancelButton: true,
            confirmButtonClass: 'btn-'+alert_type+' waves-effect waves-light',
            confirmButtonText: 'YES',
        },
        function (isConfirm) {
            if(isConfirm){
                toggle_bidder_proceed_yes( matrix_id, proceeded );
            }
        });
	}

	function toggle_bidder_proceed_yes( matrix_id, proceeded )
	{
		$.ajax({
			url: base_url + 'procurement/bidding/save_bidder_proceed',
			method: 'POST',
			data: {matrix_id: matrix_id, proceeded: proceeded},
			cache: false,
			dataType: 'json',
			async: true,
			error: function(response)
			{
				alert('error');
			},
			success: function(response)
			{
				switch( response['result'] )
				{
					case 'success':
						setTimeout(function(){
							swal(response['header'], response['message'], "success");
							load_bidder_proceed_dynamic( lot_id );
						},	500 );
						break;

					default:
						// financerLogin.resetProgressBar(true);
						break;
				}
			}
		});

		$('#modal_proceed').modal('show');
	}