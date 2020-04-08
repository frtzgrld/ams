
<!-- <pre><?php print_r($this->session->all_userdata()); ?></pre> -->

<div class="col-sm-12">
    <div class="card-box">

        <div class="dropdown pull-right">
            <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                <i class="zmdi zmdi-more-vert"></i>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="m-b-30">
                	<a href="ris/ris_new" class="btn btn-primary waves-effect waves-light"><span>Create Requisition and Issuance Slip</span></a>
                </div>
            </div>
        </div>  

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <table id="datatable_items" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                            	<th width="20%">Office</th>
                                <th width="10%">RIS No.</th>
                                <th width="10%">Purpose</th>
                                <th width="20%">Requested By</th>
                                <th width="10%">Requested Date</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div><!-- end col -->

<script type="text/javascript">
$(document).ready(function () {

                $('#datatable_items').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
                    "serverSide": true,
                    "ajax": base_url + 'file/ris/datatable_ris_list',
                    "order": [[ 0, "asc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
                        var buttons = "<a class='btn btn-primary btn-xs btn-icon icon-left' href='" + base_url + 'file/ris/ris_items/' + aData[0] + "'><i class='zmdi zmdi-info-outline'></i> View</a>";

                        /*  The format:
                            $('td:eq(0)', nRow).html( aData[1] );
                                td:eq(0) -- this refer to the 'first' column in the table; numbering start with 0 as in an array
                                aData[0] -- this refer to the 'first' index in the array response of ajax
                            */
                        $('td:eq(0)', nRow).html( aData[1] );
                        $('td:eq(1)', nRow).html( aData[2] );
                        $('td:eq(2)', nRow).html( aData[3] );
                        $('td:eq(3)', nRow).html( aData[4] );
                        $('td:eq(4)', nRow).html( aData[5] );
                        $('td:eq(5)', nRow).html( buttons );
                    },
                    "aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "aoColumns": [ 
                        {"sClass": "text-center"},
                        {"sClass": "text-left"},
                        {"sClass": "text-left"},
                        {"sClass": "text-left"},
                        {"sClass": "text-left"},
                        {"sClass": "text-left"},
                    ]   //  The number of columns here MUST be EXACT with the number of column indicated above: 'td:eq(0)' to 'td:eq(3)'
                });

                $('#dt-search').keyup(function(){
                    $('#datatable_items').DataTable().search($(this).val()).draw() ;
                })
            });

            function toggleDeleteAlert( officeid )
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