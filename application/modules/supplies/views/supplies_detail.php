<!-- <pre><?php print_r($supply); ?></pre> -->
<?php
	foreach ($supply as $row): ?>

		<script type="text/javascript">
			var item_id = '<?php echo $row['id']; ?>';
		</script>

		<div class="row">
			<div class="col-md-8">
				<div class="card-box widget-user">
			        <div>
			            <img src="<?php echo base_url(); ?>assets/images/items.png" class="img-responsive img-circle" alt="item">
			            <div class="wid-u-info">
			                <h3 class="m-t-0 m-b-5">
			                	<?php echo $row['DESCRIPTION']; ?>
								<br><small><?php  
								if($row['qty'] < $row['minqty'] && $row['qty'] < $row['maxqty']){
									echo "<span class='text-danger'>critical</span>";
								} 
								else if($row['qty'] > $row['minqty'] && $row['qty'] > $row['maxqty']){
									echo "<span class='text-warning'>overstocked</span>";
								} 
								else{
									echo "<span class='text-success'>normal</span>";
								} ?> </small>
			                </h3>
			            </div>
			        </div>
			    </div>
			</div>

			<div class="col-md-2">
				<div class="card-box widget-user">
                    <div class="text-center">
                        <h5 class="m-t-0">quantity-on-hand</h5>
                        <h2 class="text-custom" data-plugin="counterup"><?php echo number_format($row['qty']); ?></h2>
                        <!-- <h5 class="m-t-0"><?php echo plural($row['UNIT']); ?></h5> -->
                    </div>
                </div>
            </div>
		</div><?php

	endforeach; ?>
	<a id="hidden_item_button" href="#supplies_modal" class="btn btn-info btn-block waves-effect waves-light hidden" data-animation="door" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a" ></a>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default bx-shadow-none">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="">
                            <b>Distribution History</b>
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true" style="">
                    <div class="panel-body">
                        <table id="datatable_distrib_history" class="table table-striped table-hover table-bordered dt-responsive nowrap">
                            <thead>
                                <tr class="center">
                                    <th width="35%">Office</th>
                                    <!-- <th width="15%">Employee</th> -->
                                    <th width="10%">Issued Quantity</th>
                                    <th width="10%">Date Issued</th>
                                    <th width="15%">Issued by</th>
                                    <!-- <th width="10%">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="panel panel-default bx-shadow-none">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <b>Stock History</b>
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false">
                    <div class="panel-body">
                        <table id="datatable_stock_history" class="table table-striped table-hover table-bordered dt-responsive nowrap">
                            <thead>
                                <tr class="center">
                                    <th width="25%">Date Acquired</th>
                                    <th width="15%">Quanity Acquired</th>
                                    <th width="25%">Unit Cost</th>
                                    <th width="15%">Quantity on Hand</th>
									<th width="15%">Queue Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">

            $(document).ready(function () {

                $('#datatable_stock_history').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
                    "serverSide": true,
                    "ajax": base_url + 'supplies/datatable_supply_history/'+item_id,
                    "order": [[ 0, "desc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
						var buttons = "<button class='btn btn-success waves-effect waves-light btn-xs' onclick='toggle_supphist(" + aData[5] + ")'><i class='ti ti-pencil-alt'></i> Edit</button><button class='btn btn-danger waves-effect waves-light btn-xs' onclick='deleteItem(" + aData[5] + ")'><i class='ti zmdi-delete'></i> Delete</button>";
						var onq = "<button class='btn btn-primary waves-effect waves-light btn-xs' onclick='toggle_supphist(" + aData[5] + ")'><i class='ti ti-pencil-alt'></i> Edit</button><button class='btn btn-danger waves-effect waves-light btn-xs' onclick='deleteItem(" + aData[5] + ")'><i class='ti zmdi-delete'></i> Delete</button>";
							
						var queuestatus = "";
						if(aData[4] == 1){
							queuestatus = "On Queue";
						}
						else if(aData[4] == 0 && aData[3] > 0){
							queuestatus = "<button class='btn btn-primary waves-effect waves-light btn-xs' onclick='toggle_onqueue(" + aData[5] + ")'>Set on queue</button>";
						}
						
                        $('td:eq(0)', nRow).html( aData[0] );
                        $('td:eq(1)', nRow).html( add_commas(aData[1]) );
                        $('td:eq(2)', nRow).html( 'Php '+add_commas(parseFloat(aData[2]).toFixed(2)) );
						$('td:eq(3)', nRow).html( '<b>'+add_commas(aData[3])+'</b>' );
						$('td:eq(4)', nRow).html( queuestatus );
                        $('td:eq(5)', nRow).html( buttons );
                    },
                    "aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "aoColumns": [ 
                        {"sClass": "text-left"},
                        {"sClass": "text-right"},
                        {"sClass": "text-right"},
                        {"sClass": "text-right"},
						{"sClass": "text-center"},
						{"sClass": "text-center"},
                    ]
                });
                // datatable_filter_overrides('datatable_purchase');

                $('#dt-search').keyup(function(){
                    $('#datatable_purchase_history').DataTable().search($(this).val()).draw() ;
                });

                $('#datatable_distrib_history').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
                    "serverSide": true,
                    "ajax": base_url + 'supplies/datatable_distrib_history/'+item_id,
                    "order": [[ 2, "desc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
                        var buttons = "<a class='btn btn-info btn-xs btn-icon icon-left' href='" + base_url + 'inventory/supplies/acquisitions/' + aData[6] + "'><i class='ti ti-info-alt'></i> View Detail</a> " + "<button class='btn btn-success waves-effect waves-light btn-xs' onclick='toggle_office(" + aData[6] + ")'><i class='ti ti-pencil-alt'></i> Edit</button>",
                            buttons = null;

                        $('td:eq(0)', nRow).html( aData[0] );
                        $('td:eq(1)', nRow).html( '<b>'+add_commas(aData[1])+'</b>' );
                        $('td:eq(2)', nRow).html( aData[2] );
                        $('td:eq(3)', nRow).html( aData[3] );
                        // $('td:eq(5)', nRow).html( buttons );
                    },
                    "aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "aoColumns": [ 
                        {"sClass": "text-left"},
                        {"sClass": "text-right"},
                        {"sClass": "text-right"},
                        {"sClass": "text-center"},
                        // {"sClass": "text-left"},
                    ]
				});
				
				$("#form_supplies").validate({
                    ignore:'',
                    rules: {
                        hidden_supp_id: {
                            required: true,
                            maxlength: 11,
                            number: true,
                        },
                        items: {
                            required: true,
                            maxlength: 250,
                        },
                        unit_cost: {
                            required: false,
                            maxlength: 11,
                        },
                        qty_acquired: {
                            required: true,
                            maxlength: 250,
						},
						dateacquired: {
                            required: true,
                            maxlength: 250,
                        },
                    },

                    errorPlacement: function (error, element) {
                        $(element).closest('.form-group').find('.error-message').html(error);
                    },

                    submitHandler: function() {
                        $.ajax({
							url: base_url + 'supplies/validate_supplies',
							method: 'POST',
							data: $('#form_supplies').serialize(),
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
                                        $('#datatable_supplies').DataTable().ajax.reload(null, false);
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
	
	function toggle_supphist( supphist_id )
	{
		$('#hidden_supp_id').val('0');
		$('#action').val("insert");
		$('#items').val('').trigger('change');
		$('#unit_cost').val('');
		$('#qty_acquired').val('');
		$('#dateacquired').val('');
		$('#estimated_useful_life').val('');
		$('#eul_unit').val('');

		if( supphist_id )
		{
			$.ajax({
				url: base_url + 'supplies/load_supp',
				method: 'POST',
				data: {supphist_id: supphist_id},
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
						$('#hidden_supp_id').val(response[0]['ID']);
						$('#action').val("update");
						$('#items').val(response[0]['ITEMS']).trigger('change');
						$('#unit_cost').val(response[0]['UNITCOST']);
						$('#qty_acquired').val(response[0]['QTYACQUIRED']);
						$('#dateacquired').val(response[0]['DATEACQUIRED']);
						$('#estimated_useful_life').val(response[0]['EST_USEFUL_LIFE']);
						$('#eul_unit').val(response[0]['EUL_UNIT']);
					}
				}
			});
		}

		$('#hidden_item_button').click();
	}

	function toggle_onqueue( supp_id )
		{
			var item = item_id;
			$.ajax({
				url: base_url + 'supplies/validate_supplies',
				method: 'POST',
				cache: false,
				dataType: 'json',
				data: {supp_id: supp_id, action: "onqueue", item: item},
				async: true,
				error: function(response)
				{
					alert('error');
				},
				success: function(response)
				{
					window.location.reload();
				}
			});
		}

	function deleteItem( id )
    {
        $.ajax({
            url: base_url + 'supplies/validate_supplies',
            method: 'POST',
            cache: false,
            dataType: 'json',
            data: {supp_id: id, action: "delete"},
            async: true,
            error: function(response)
            {
                alert('error');
            },
            success: function(response)
            {
                window.location.reload();
            }
        });
    }
        </script>
