           
        <div class="row m-b-10">
            <div class="col-md-4">
                <button onclick="toggle_items(null)" class="btn btn-success btn-block waves-effect waves-light" type="button"><i class="fa fa-plus"></i> ADD NEW PROPERTY</button>
                <a id="hidden_item_button" href="#property_modal" class="btn btn-info btn-block waves-effect waves-light hidden" data-animation="door" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a" ></a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <table id="datatable_properties" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th width="10%">Property No.</th>
                                <th width="20%">Property Description</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

		
		<script type="text/javascript">
		$(document).ready(function () {
		$('#datatable_properties').dataTable({
		"processing": true,
		"language": {
			"processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
		},
		"serverSide": true,
		"ajax": base_url + 'properties_and_equipment/datatable_properties',
		"order": [[ 0, "asc" ]],
		"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
		{
			var buttons = "<a class='btn btn-info btn-xs btn-icon icon-left' href='" + base_url + 'properties_and_equipment/acquisitions/' + aData[3] + "'><i class='ti ti-info-alt'></i> Detail</a><button class='btn btn-success waves-effect waves-light btn-xs' onclick='toggle_prop(" + aData[3] + ")'><i class='ti ti-pencil-alt'></i> Edit</button><button class='btn btn-danger waves-effect waves-light btn-xs' onclick='deleteItem(" + aData[3] + ")'><i class='ti zmdi-delete'></i> Delete</button>";
			 // +
				// '<button class="btn btn-danger waves-effect waves-light btn-xs" onclick="toggle_disposal(' + aData[3] + ', \'property\', \'datatable_supplies\', \'assigned\')"><i class="fa fa-share-square-o"></i> Dispose</button>';
				btnEdit = "<button class='btn btn-success waves-effect waves-light btn-xs' onclick='toggle_office(" + aData[3] + ")'><i class='ti ti-pencil-alt'></i> Edit</button>";
			var status = "";
			if(aData[2] == 0)
			{
				status = "Unassigned";
			}
			else if(aData[2] == 1)
			{
				status = "Assigned";
			}
			else if(aData[2] == 2)
			{
				status = "Transferred";
			}
			else 
			{
				status = "Condemned";
			}
			$('td:eq(0)', nRow).html( aData[0] );
			$('td:eq(1)', nRow).html( aData[1] );
			$('td:eq(2)', nRow).html( status );
			$('td:eq(3)', nRow).html( buttons );
		},
		"aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
		"aoColumns": [ 
			{"sClass": "text-left"},
			{"sClass": "text-center"},
			{"sClass": "text-center"},
			{"sClass": "text-left"},
			// {"sClass": "text-right"},
			// {"sClass": "text-center"},
			// {"sClass": "text-left", "bVisible": false, "bSearchable": false},
		]
	});

	datatable_filter_overrides('datatable_properties');

	$('#dt-search').keyup(function(){
		$('#datatable_properties').DataTable().search($(this).val()).draw() ;
	});

	
});

function deleteItem( id )
    {
        $.ajax({
            url: base_url + 'properties_and_equipment/validate_property',
            method: 'POST',
            cache: false,
            dataType: 'json',
            data: {prop_id: id, action: "delete"},
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ams/form_property.js"></script>
