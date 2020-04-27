<div class="row">
        
            <div class="col-sm-12">
                <div class="card-box">
                    <table id="datatable_fastmoving_supplies" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr class="table-eis">
                                <th width="10%">Stock No</th>
                                <th width="10%">Unit</th>
                                <th width="25%">Description</th>
                                <th width="8%">Total Issued Qty</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>


<script type="text/javascript">

            $(document).ready(function () {

                $('#datatable_fastmoving_supplies').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
                    "serverSide": true,
                    "ajax": base_url + 'inventory/supplies/datatable_fastmoving_supplies',
                    "order": [[ 0, "asc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
                        var buttons = "<a class='btn btn-info btn-xs btn-icon icon-left' href='" + base_url + 'sales_invoice/sales_invoice_edit/' + aData[0] + "'><i class='ti ti-info-alt'></i> Detail</a> " 
                            // + '<button class="btn btn-danger waves-effect waves-light btn-xs" onclick="toggle_disposal(' + aData[5] + ', \'property\', \'datatable_supplies\', \'assigned\')"><i class="fa fa-share-square-o"></i> Dispose</button>';
                            btnEdit = "<button class='btn btn-success waves-effect waves-light btn-xs' onclick='toggle_office(" + aData[5] + ")'><i class='ti ti-pencil-alt'></i> Edit</button>";

                        $('td:eq(0)', nRow).html( aData[0] );
                        $('td:eq(1)', nRow).html( aData[1] );
                        $('td:eq(2)', nRow).html( aData[2] );
                        $('td:eq(3)', nRow).html( aData[3] );
                        // $('td:eq(4)', nRow).html( buttons );
                    },
                    "aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "aoColumns": [ 
                        {"sClass": "text-center"},
                        {"sClass": "text-center"},
                        {"sClass": "text-center"},
                        {"sClass": "text-center"},
                        // {"sClass": "text-center"},
                        // {"sClass": "text-left", "bVisible": false, "bSearchable": false},
                    ]
                });

                datatable_filter_overrides('datatable_delivery');

                $('#dt-search').keyup(function(){
                    $('#datatable_delivery').DataTable().search($(this).val()).draw() ;
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

        </script>