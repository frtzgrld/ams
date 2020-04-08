<!-- <pre><?php print_r($this->session->all_userdata()); ?></pre> -->

<div class="row">
            <div class="col-sm-12">
                <div class="m-b-30">
                    <a href="par/par_new" class="btn btn-primary waves-effect waves-light"><span>Create Property Acknowledgement Receipt</span></a>
                    <button class="btn btn-primary waves-effect waves-light" onclick="showAll()" >View All</button>
                    <button class="btn btn-primary waves-effect waves-light" onclick="showAssigned()" >View Newly Assigned Properties</button>
                    <button class="btn btn-primary waves-effect waves-light" onclick="showTransferred()" >View Transferred Properties</button>
                    <button class="btn btn-primary waves-effect waves-light" onclick="showCondemned()" >View Condemened Properties</button>
                </div>
                
            </div>
        </div>  

<div class="col-sm-12" id="showAll">
    <div class="card-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <table id="datatable_items" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                            	<th width="10%">Fund Cluster</th>
                                <th width="10%">PAR No.</th>
                                <th width="10%">Date</th>
                                <th width="10%">Issued By</th>
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

<div class="col-sm-12" id="div_datatable_assigned">
    <div class="card-box">
        <div class="row" id="">
            <div class="col-sm-12"> <h4 class="page-title">Assigned</h4> 
                <div class="card-box table-responsive">
                    <table id="datatable_assigned" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th width="10%">Fund Cluster</th>
                                <th width="10%">PAR No.</th>
                                <th width="10%">Date</th>
                                <th width="10%">Issued By</th>
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

<div class="col-sm-12" id="div_datatable_trans">
    <div class="card-box">
        <div class="row" id="">
            <div class="col-sm-12"> <h4 class="page-title">Transferred</h4> 
                <div class="card-box table-responsive">
                    <table id="datatable_trans" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th width="10%">Fund Cluster</th>
                                <th width="10%">PAR No.</th>
                                <th width="10%">Date</th>
                                <th width="10%">Issued By</th>
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

<div class="col-sm-12" id="div_datatable_condemened">
    <div class="card-box">
        <div class="row" id="">
            <div class="col-sm-12"><h4 class="page-title">Condemned</h4>  
                <div class="card-box table-responsive">
                    <table id="datatable_condemned" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th width="10%">Fund Cluster</th>
                                <th width="10%">PAR No.</th>
                                <th width="10%">Date</th>
                                <th width="10%">Issued By</th>
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

    jQuery('#showAll').show();
    jQuery('#div_datatable_assigned').hide();
    jQuery('#div_datatable_trans').hide();
    jQuery('#div_datatable_condemened').hide();

                $('#datatable_items').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
                    "serverSide": true,
                    "ajax": base_url + 'file/par/datatable_par_list',
                    "order": [[ 0, "asc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
                        var buttons = "<a class='btn btn-primary btn-xs btn-icon icon-left' href='" + base_url + 'file/par/par_items/' + aData[0] + "'><i class='zmdi zmdi-info-outline'></i> View</a>";

                        /*  The format:
                            $('td:eq(0)', nRow).html( aData[1] );
                                td:eq(0) -- this refer to the 'first' column in the table; numbering start with 0 as in an array
                                aData[0] -- this refer to the 'first' index in the array response of ajax
                            */
                        $('td:eq(0)', nRow).html( aData[1] );
                        $('td:eq(1)', nRow).html( aData[2] );
                        $('td:eq(2)', nRow).html( aData[3] );
                        $('td:eq(3)', nRow).html( aData[4] );
                        $('td:eq(4)', nRow).html( buttons );
                    },
                    "aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "aoColumns": [ 
                        {"sClass": "text-center"},
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

<script type="text/javascript">
$(document).ready(function () {

                $('#datatable_assigned').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
                    "serverSide": true,
                    "ajax": base_url + 'file/par/datatable_par_list/1',
                    "order": [[ 0, "asc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
                        var buttons = "<a class='btn btn-primary btn-xs btn-icon icon-left' href='" + base_url + 'file/par/par_items/' + aData[0] + "'><i class='zmdi zmdi-info-outline'></i> View</a>";

                        /*  The format:
                            $('td:eq(0)', nRow).html( aData[1] );
                                td:eq(0) -- this refer to the 'first' column in the table; numbering start with 0 as in an array
                                aData[0] -- this refer to the 'first' index in the array response of ajax
                            */
                        $('td:eq(0)', nRow).html( aData[1] );
                        $('td:eq(1)', nRow).html( aData[2] );
                        $('td:eq(2)', nRow).html( aData[3] );
                        $('td:eq(3)', nRow).html( aData[4] );
                        $('td:eq(4)', nRow).html( buttons );
                    },
                    "aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "aoColumns": [ 
                        {"sClass": "text-center"},
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

    function showAll()
    {
        jQuery('#showAll').show();
        jQuery('#div_datatable_assigned').hide();
        jQuery('#div_datatable_trans').hide();
        jQuery('#div_datatable_condemened').hide();
    }

    function showTransferred()
    {
        jQuery('#showAll').hide();
        jQuery('#div_datatable_assigned').hide();
        jQuery('#div_datatable_trans').show();
        jQuery('#div_datatable_condemened').hide();
    }

    function showAssigned()
    {
        jQuery('#showAll').hide();
        jQuery('#div_datatable_assigned').show();
        jQuery('#div_datatable_trans').hide();
        jQuery('#div_datatable_condemened').hide();
    }

    function showCondemned()
    {
        jQuery('#showAll').hide();
        jQuery('#div_datatable_assigned').hide();
        jQuery('#div_datatable_trans').hide();
        jQuery('#div_datatable_condemened').show();
    }
    
</script>

<script type="text/javascript">
$(document).ready(function () {

                $('#datatable_trans').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
                    "serverSide": true,
                    "ajax": base_url + 'file/par/datatable_par_list/2',
                    "order": [[ 0, "asc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
                        var buttons = "<a class='btn btn-primary btn-xs btn-icon icon-left' href='" + base_url + 'file/par/par_items/' + aData[0] + "'><i class='zmdi zmdi-info-outline'></i> View</a>";

                        /*  The format:
                            $('td:eq(0)', nRow).html( aData[1] );
                                td:eq(0) -- this refer to the 'first' column in the table; numbering start with 0 as in an array
                                aData[0] -- this refer to the 'first' index in the array response of ajax
                            */
                        $('td:eq(0)', nRow).html( aData[1] );
                        $('td:eq(1)', nRow).html( aData[2] );
                        $('td:eq(2)', nRow).html( aData[3] );
                        $('td:eq(3)', nRow).html( aData[4] );
                        $('td:eq(4)', nRow).html( buttons );
                    },
                    "aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "aoColumns": [ 
                        {"sClass": "text-center"},
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

<script type="text/javascript">
$(document).ready(function () {

                $('#datatable_condemned').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
                    "serverSide": true,
                    "ajax": base_url + 'file/par/datatable_par_list/3',
                    "order": [[ 0, "asc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
                        var buttons = "<a class='btn btn-primary btn-xs btn-icon icon-left' href='" + base_url + 'file/par/par_items/' + aData[0] + "'><i class='zmdi zmdi-info-outline'></i> View</a>";

                        /*  The format:
                            $('td:eq(0)', nRow).html( aData[1] );
                                td:eq(0) -- this refer to the 'first' column in the table; numbering start with 0 as in an array
                                aData[0] -- this refer to the 'first' index in the array response of ajax
                            */
                        $('td:eq(0)', nRow).html( aData[1] );
                        $('td:eq(1)', nRow).html( aData[2] );
                        $('td:eq(2)', nRow).html( aData[3] );
                        $('td:eq(3)', nRow).html( aData[4] );
                        $('td:eq(4)', nRow).html( buttons );
                    },
                    "aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "aoColumns": [ 
                        {"sClass": "text-center"},
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