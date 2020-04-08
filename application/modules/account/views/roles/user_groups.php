        
        <div class="row m-b-10">
            <div class="col-md-4">
                <button onclick="toggle_items(null)" class="btn btn-success btn-block waves-effect waves-light" type="button"><i class="fa fa-plus"></i> ADD NEW GROUP</button>
                <a id="hidden_item_button" href="#item_modal" class="btn btn-info btn-block waves-effect waves-light hidden" data-animation="door" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a" ></a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card-box table-responsive">
                    <table id="datatable_items" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th width="10%">CODE</th>
                                <th width="40%">GROUPS</th>
                                <th width="30%">ACTIVE USERS</th>
                                <th width="15%">ACTION</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <script type="text/javascript">

            $(document).ready(function () {

                $('#datatable_items').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
                    "serverSide": true,
                    "ajax": base_url + 'account/roles/datatable_roles',
                    "order": [[ 0, "asc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
                        var buttons = "<a class='btn btn-info btn-xs btn-icon icon-left' href='" + base_url + 'account/roles/detail/' + aData[0] + "'><i class='zmdi zmdi-info-outline'></i> Detail</a> " + "<button class='btn btn-success waves-effect waves-light btn-xs' onclick='toggle_items(" + aData[0] + ")'><i class='ti ti-pencil-alt'></i> Edit</button>";

                        $('td:eq(0)', nRow).html( aData[0] );
                        $('td:eq(1)', nRow).html( aData[1] );
                        $('td:eq(2)', nRow).html( aData[2] );
                        $('td:eq(3)', nRow).html( buttons );
                    },
                    "aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "aoColumns": [ 
                        {"sClass": "text-center"},
                        {"sClass": "text-left"},
                        {"sClass": "text-center"},
                        {"sClass": "text-left"},
                    ]
                });

                $('#dt-search').keyup(function(){
                    $('#datatable_items').DataTable().search($(this).val()).draw() ;
                });
            });
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/eis/item_management.js"></script>