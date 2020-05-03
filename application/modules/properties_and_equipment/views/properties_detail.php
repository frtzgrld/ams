
        <script type="text/javascript">
            var item_id = '<?php echo $property[0]['ITEMID']; ?>';
        </script>

        <div class="row">
            <div class="col-md-8">
                <div class="card-box widget-user">
                    <div>
                        <img src="<?php echo base_url(); ?>assets/images/items.png" class="img-responsive img-circle" alt="item">
                        <div class="wid-u-info">
                            <h3 class="m-t-0 m-b-5">
                                <?php echo $property[0]['PROPERTYNO']; ?>
                            </h3>
							<h3 class="m-t-0 m-b-5">
                                <?php echo $property[0]['DESCRIPTION']; ?>
                            </h3>
                            <h5 class="m-t-0">CLASS: <?php echo $property[0]['CATEGORY']; ?></h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card-box widget-user">
                    <div class="text-center">
                        <h5 class="m-t-0">quantity-on-hand</h5>
                        <h2 class="text-custom" data-plugin="counterup"><?php echo number_format($property[0]['QTYONHAND']); ?></h2>
                    </div>
                </div>
            </div>
        </div>

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
                                    <th width="20%">Assigned to</th>
                                    <th width="10%">Property No.</th>
                                    <th width="15%">Date Assigned</th>
                                    <th width="20%">Assigned by</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Action</th>
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

                $('#datatable_distrib_history').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
                    "serverSide": true,
                    "ajax": base_url + 'distribution/datatable_property_distrib_history/'+item_id,
                    "order": [[ 2, "desc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
                        var buttons = "<a class='btn btn-info btn-xs btn-icon icon-left' href='" + base_url + 'inventory/supplies/acquisitions/' + aData[6] + "'><i class='ti ti-info-alt'></i> View Detail</a> " + "<button class='btn btn-success waves-effect waves-light btn-xs' onclick='toggle_office(" + aData[6] + ")'><i class='ti ti-pencil-alt'></i> Edit</button>",
                            buttons = null;

                        $('td:eq(0)', nRow).html( aData[0] );
                        $('td:eq(1)', nRow).html( aData[1] );
                        $('td:eq(2)', nRow).html( aData[2] );
                        $('td:eq(3)', nRow).html( aData[3] );
                        $('td:eq(4)', nRow).html( aData[4] );
                        $('td:eq(5)', nRow).html( buttons );
                    },
                    "aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "aoColumns": [ 
                        {"sClass": "text-left"},
                        {"sClass": "text-right"},
                        {"sClass": "text-right"},
                        {"sClass": "text-left"},
                        {"sClass": "text-center"},
                        {"sClass": "text-left"},
                    ]
                });
            });

        </script>
