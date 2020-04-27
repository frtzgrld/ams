        
        
<div class="row m-b-10">
            <div class="col-md-4">
                <button onclick="toggle_supplies(null)" class="btn btn-success btn-block waves-effect waves-light" type="button"><i class="fa fa-plus"></i> ADD NEW SUPPLIES</button>
                <a id="hidden_item_button" href="#supplies_modal" class="btn btn-info btn-block waves-effect waves-light hidden" data-animation="door" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a" ></a>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-12">
                <div class="card-box">
                    <table id="datatable_supplies" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr class="table-eis">
                                <th width="25%">Supplies</th>
                                <th width="10%">Stock</th>
                                <th width="10%">Unit</th>
                                <th width="8%">Min Qty</th>
                                <th width="8%">Max Qty</th>
                                <th width="10%">Stock Status</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        

        <script type="text/javascript">

            $(document).ready(function () {

                $('#datatable_supplies').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
					"serverSide": true,
					"columnDefs": [
						{ 
							"searchable": false, 
							"targets": 1 
						}
					],
                    "ajax": base_url + 'supplies/datatable_supplies',
                    "order": [[ 0, "asc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
                        var buttons = "<a class='btn btn-info btn-xs btn-icon icon-left' href='" + base_url + 'supplies/acquisitions/' + aData[5] + "'><i class='ti ti-info-alt'></i> Detail</a> ";
						var qtystat = "";
						if(parseInt(aData[4]) < parseInt(aData[2]) && parseInt(aData[4]) < parseInt(aData[3])){
							$('td:eq(5)', nRow).html( "<span class='text-danger'>critical</span>" );
							
						}
						else if (parseInt(aData[4]) > parseInt(aData[2]) && parseInt(aData[4]) > parseInt(aData[3])){
							$('td:eq(5)', nRow).html( "<span class='text-warning'>overstocked</span>" );
						}
						else if (parseInt(aData[4]) >= parseInt(aData[2]) && parseInt(aData[4]) <= parseInt(aData[3])) {
							$('td:eq(5)', nRow).html( "<span class='text-success'>normal</span>" );
						}

                        $('td:eq(0)', nRow).html( aData[0] );
                        $('td:eq(1)', nRow).html( aData[4] );
                        $('td:eq(2)', nRow).html( aData[1] );
                        $('td:eq(3)', nRow).html( aData[2] );
                        $('td:eq(4)', nRow).html( aData[3] );
                        
                        $('td:eq(6)', nRow).html( buttons );
                    },
                    "aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "aoColumns": [ 
                        {"sClass": "text-left"},
                        {"sClass": "text-right"},
                        {"sClass": "text-center"},
                        {"sClass": "text-right"},
                        {"sClass": "text-right"},
                        {"sClass": "text-center"},
                        {"sClass": "text-left"},
                    ]
                });

                datatable_filter_overrides('datatable_supplies');

                $('#dt-search').keyup(function(){
                    $('#datatable_supplies').DataTable().search($(this).val()).draw() ;
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

		function toggle_supplies( supp_id )
		{
			$('#hidden_supp_id').val('0');
			$('#action').val("insert");
			$('#items').val('').trigger('change');
			$('#unit_cost').val('');
			$('#qty_acquired').val('');
			$('#dateacquired').val('');
			$('#estimated_useful_life').val('');
			$('#eul_unit').val('');

			$('#hidden_item_button').click();
		}
        </script>

