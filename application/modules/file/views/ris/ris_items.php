<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form id="app_details_save" action="" method="post" class="form-horizontal" role="form">
        <input type="hidden" name="ris_id" id="ris_id" value="<?php echo $ris_no; ?>">
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Select Items</h4>
            </div>

            <div class="modal-body">
              
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="datatable" class="table table-striped table-hover dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th width="10%"></th>
                                        <th width="15%">Code</th>
                                        <th width="20%">Category</th>
                                        <th width="45%">Description</th>
                                        <th width="10%">Unit</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            
            </div>
            </form>
        </div>
    </div>
</div>  <!-- /.modal  -->

<!-- EDIT items -->
<div id="editcon-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-s">
        <div class="modal-content">
        <form id="period" action="<?php echo base_url(); ?>file/ris/save_quantity" method="post" class="form-horizontal" role="form">
        <input type="hidden" id="ris_item_id" name="ris_item_id" value="">
        <input type="hidden" id="save_ris_id" name="save_ris_id" value="<?php echo $ris_id; ?>">
		<input type="hidden" id="save_office" name="save_office" value="<?php echo $office_rec; ?>">
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">ENTER QUANTITY</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="items" class="control-label">Quantity</label>
                            <input type="text" class="form-control" name="req_qty" id="req_qty" value="">
                        </div>
                        <div class="form-group">
                            <label for="items" class="control-label">Quantity Released</label>
                            <input type="text" class="form-control" name="rel_qty" id="rel_qty" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect w-md waves-light m-b-5">SAVE AND PROCEED</button>
            </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <!-- <p class="header-title m-t-0 m-b-30" align="center">ACKNOWLEDGEMENT RECEIPT FOR EQUIPMENT</p> -->
            <!-- <hr> -->
            <form id="ris_header" action="<?php echo base_url(); ?>file/ris/ris_header_save" method="post" class="form-horizontal" role="form">

               <div class="form-group">
                    
                    <div class="col-sm-12" align="center">
                    <label class="control-label-center" for="description" style="font-size: 150%; text-decoration: underline">REQUISITION & ISSUANCE SLIP</label><br/>
                    <!-- <label class="control-label-center" for="description">Agency</label> -->
                   
                    </div>
                   
                </div>
                
                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="left">Requisition Department:<span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-sm-3" for="office" align="left">
                        <select name="office" id="office" class="form-control select2" placeholder="Select Office">
                        <option value=""> </option><?php
                        foreach ($offices as $row): ?>
                            <option value="<?php echo $row['ID'];?>"  <?php if($office_rec == $row['ID']) { echo 'selected'; }?> ><?php echo $row['DESCRIPTION'];?></option><?php
                        endforeach; ?>
                        </select>
                    </div>
                   
                    <!-- <div class="col-md-9 col-md-offset-9 error-message"></div> -->
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="left"></label>
                    </div>

                     <div class="col-sm-2" align="right">
                        <label class="control-label-right" align="right">RIS No:<span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-sm-3" for="createdby" align="left">
                        <input type="text" class="form-control" name="ris_no" id="ris_no" value="<?php echo $ris_no; ?>">
                    </div>
                    
                </div>

                <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="left"><span class="text-danger"></span></label>
                    </div>
                    
                    <div class="col-sm-3" for="createdby" align="left">
                        
                    </div>
                    <!-- <div class="col-md-9 col-md-offset-9 error-message"></div> -->
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="left"></label>
                    </div>

                    <div class="col-sm-2" align="right">
                        <label class="control-label-right" align="right">Date:<span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-sm-3" for="createdby" align="left">
                        <input class="form-control text-strong datepicker-autoclose" name="requested_date" id="requested_date" type="text" placeholder="" value="<?php echo $requested_date; ?>">
                    </div>
                    <!-- <div class="col-md-9 col-md-offset-9 error-message"></div> -->
                </div>


              
            <div class="col-sm-6">
                <div class="m-b-30">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">Add Items</button>
                </div>
            </div>

                <!-- RIS ITEMS-->
            <table class="table table-striped m-0">
               
            <thead>
                <tr>
                    <th rowspan="1">STOCK NO.</th>
                    <th rowspan="1">QTY</th>
                    <th rowspan="1">UNIT</th>
                    <th rowspan="1">SIZE</th>
                    <th rowspan="1">DESCRIPTION</th>
                    <th rowspan="1">QTY RELEASED</th>
                    <th rowspan="1">ACTION</th>

                </tr>
                
            </thead>
          
                <tbod>
                <?php 
           if(!empty($ris_items_list))
            {
                // echo print_r($items,true);
                foreach ($ris_items_list as $key) 
                :?>
                <tr>
                    <td></td>
                    <td><?php echo $key['REQ_QTY']; ?></td>
                    <td><?php echo $key['REQ_UNIT']; ?></td>
                    <td></td>
                    <td><?php echo $key['DESCRIPTION']; ?></td>
                    <td><?php echo $key['ISSUED_QTY']; ?></td>
                    <td><?php echo $key['ISSUED_REMARKS']; ?></td>
                    <td> <button type="button" class="btn btn-primary waves-effect waves-light"  onclick="getQty( <?php echo $key['ris_items_id']; ?>)">Edit</button> </td>
                    
                    
                </tr>
                <?php endforeach; 
            }
                    ?> 


                </tbod>
                </table>

                <br/>
                <br/>
                <br/>
                <hr>
                
            </form>
            
        </div>
    </div><!-- end col -->
</div>


<script type="text/javascript">
$(document).ready(function () {
	$('#office').val(<?php echo $office_rec; ?>).trigger('change');

                $('#datatable').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
                    "serverSide": true,
                    "ajax": base_url + 'file/ris/datatable_ris_items',
                    "order": [[ 0, "asc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
                        var chckbox = '<button class="btn btn-info btn-xs btn-block" type="button" onclick="getItem(' + aData[0] +')">SELECT</button>';
                        // <input type="radio" name="pr_no[]" id="pr_no['+aData[2]+']" value="' + aData[2] + '">';

                        /*  The format:
                            $('td:eq(0)', nRow).html( aData[1] );
                                td:eq(0) -- this refer to the 'first' column in the table; numbering start with 0 as in an array
                                aData[0] -- this refer to the 'first' index in the array response of ajax
                            */
                        $('td:eq(0)', nRow).html( chckbox );
                        $('td:eq(1)', nRow).html( aData[1] );
                        $('td:eq(2)', nRow).html( aData[2] );
                        $('td:eq(3)', nRow).html( aData[3] );
                        $('td:eq(4)', nRow).html( aData[4] );
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
                    $('#datatable').DataTable().search($(this).val()).draw() ;
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
    
    function getItem( id )
    {
		var risid = $("#ris_id").val();
        $.ajax({
            url: base_url + 'file/ris/save_items',
            method: 'POST',
            cache: false,
            dataType: 'json',
            data: {item_id: id, ris_id: risid},
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

        jQuery('#con-close-modal').modal('hide');
    }

    function getQty( id )
    {
        $.ajax({
            url: base_url + 'file/ris/getQty',
            method: 'POST',
            cache: false,
            dataType: 'json',
            data: {ris_id: id},
            async: true,
            error: function(response)
            {
                alert('error');
            },
            success: function(response)
            {
                $('#req_qty').val( response[0]['REQ_QTY'] );
                $('#ris_item_id').val( response[0]['ID'] );
                $('#save_ris_id').val( response[0]['RIS_NO'] );
                jQuery('#editcon-close-modal').modal('show');
            }
        });

        // jQuery('#con-close-modal').modal('hide');
    }

</script>
<!-- 
<script type="text/javascript">
                        $(document).ready(function(){

                            var purchase_request_id = <?php echo $result['ID']; ?>;
                            $('#button_placement').html(
                                    '<button class="btn btn-block btn-info" onclick="jQuery(popup_window(\''+base_url+'purchase_requests/print_purchase_request/' + purchase_request_id + '\'));"><i class="fa fa-print"></i> PRINT PURCHASE REQUEST</button>'
                                );
                        })
                    </script> -->
