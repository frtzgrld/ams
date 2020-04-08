<!-- <pre><?php print_r($this->session->all_userdata()); ?></pre>  -->
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form id="are_details_save" action="" method="post" class="form-horizontal" role="form">
        <input type="hidden" name="are_id" id="are_id" value="<?php echo $are_id; ?>">
        
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
                                        <th width="15%">Property No</th>
                                        <th width="20%">Description</th>
                                        <th width="45%">Unit Cost</th>
                                        <th width="15%">Estimated Useful Life (yr)</th>
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

<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <!-- <p class="header-title m-t-0 m-b-30" align="center">ACKNOWLEDGEMENT RECEIPT FOR EQUIPMENT</p> -->
            <!-- <hr> -->
            <form id="are_header"  method="post" class="form-horizontal" role="form">
            <input type="hidden" name="are_id" id="are_id" value="<?php echo $are_id; ?>">
                <div class="form-group">
                    
                    <div class="col-sm-12" align="center">
                    <label class="control-label-center" for="description" style="font-size: 150%; text-decoration: underline">VALENCIA</label><br/>
                    <label class="control-label-center" for="description">Agency</label>
                   
                    </div>
                   
                </div>
                
                <div class="form-group">
                    <div class="col-sm-9" align="right">
                        <label class="control-label-right" align="right">ARE No.<span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-sm-3" for="createdby" align="right">
                        <input type="text" class="form-control" name="are_no" id="are_no" value="<?php echo $are_no; ?>">
                    </div>
                    <div class="col-md-9 col-md-offset-9 error-message"></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9" align="right">
                        <label class="control-label-right" align="right">Date<span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-sm-3" for="createdby" align="right">
                         <input type="text" class="po_date_pckr form-control" name="date" id="datepicker-autoclose" value="<?php echo $date; ?>">
                    </div>
                    <div class="col-md-9 col-md-offset-9 error-message"></div>
                </div>

                 <div class="form-group">
                    <label class="col-sm-2 control-label-left" for="description">Office:</label>
                    <div class="col-sm-6">
                    <select name="office" id="office" class="form-control select2" placeholder="Select Office">
                    <option value=""> </option><?php
                    foreach ($offices as $row): ?>
                        <option value="<?php echo $row['ID'];?>" <?php if($offices_rec == $row['ID']) { echo 'selected'; }?>  ><?php echo $row['DESCRIPTION'];?></option><?php
                    endforeach; ?>
                    </select>

                    </div>
                </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="m-b-30">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">Add Items</button>
                </div>
            </div>
        </div>  
                 <script type="text/javascript">
                        $(document).ready(function(){

                            var are_id = <?php echo $are_id; ?>;
                            $('#button_placement').html(
                                    '<button class="btn btn-block btn-info" onclick="jQuery(popup_window(\''+base_url+'file/are/print_are/' + are_id + '\'));"><i class="fa fa-print"></i> PRINT ACKNOWLEDGEMENT RECEIPT FOR EQUIPMENT</button>'
                                );
                        })
                    </script>

                <!-- ARE ITEMS-->
                <table class="table table-striped m-0">
            <thead>
                <tr>
                    <th rowspan="1">QTY</th>
                    <th rowspan="1">UNIT</th>
                    <th rowspan="1">ARTICLE DESCRIPTION</th>
                    <th rowspan="1">CLASS CODE</th>
                    <th rowspan="1">DATE ACQUIRED</th>
                    <th rowspan="1">PROPERTY NO</th>
                    <th rowspan="1">UNIT COST</th>
                    <th rowspan="1">TOTAL COST</th>
                    <!-- <th rowspan="1">ACTION</th> -->

                </tr>
                
            </thead>
          
                <tbod>
              <?php 
           if(!empty($are_items_list))
            {
                // echo print_r($items,true);
                foreach ($are_items_list as $key) 
                :?>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?php echo $key['DESCRIPTION']; ?></td>
                    <td></td>
                    <td><?php echo $key['DATEACQUIRED']; ?></td>
                    <td><?php echo $key['PROPERTYNO']; ?></td>
                    <td><?php echo $key['UNITCOST']; ?></td>
                    <td><?php echo $key['UNITCOST']; ?></td>
                    <td> <?php if($key['prop_id'] == null) { echo '<button class="btn btn-primary waves-effect waves-light" onclick="deleteItem('.$key['prop_id'].')" >Add</button>'; } 
                    // else { echo '<button class="btn btn-primary waves-effect waves-light" onclick="deleteItem('.$key['prop_id'].')" >Delete</button>'; }
                    ?> </td>
                </tr>
                <?php endforeach; 
            }
                    ?>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td> 
                </tbod>
                </table>

                <br/>
                <br/>

                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Serial No.<span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="serialno" id="serialno" value="<?php echo $serial_no; ?>">
                    </div>
                    <!-- <div class="col-md-3 col-md-offset-4 error-message"></div> -->

                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Location No.</label>
                    </div>
                    
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="location" id="location" value="<?php echo $location; ?>">
                    </div>
                    <!-- <div class="col-md-8 col-md-offset-4 error-message"></div> -->
                    <div class="col-md-2 col-md-offset-2 error-message"></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Remarks</label>
                    </div>
                    
                    <div class="col-sm-10" for="createdby" align="right">
                        <input type="text" class="form-control" name="remarks" id="remarks" value="<?php echo $remarks; ?>">
                    </div>
                </div>
                <br/>

                <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-5" align="left">
                        <label class="control-label-left" align="right">Received By</label>
                    </div>
                    
                   <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-5" align="left">
                        <label class="control-label-left" align="right">Receive From</label>
                    </div>
                    
                   
                </div>

                <!-- Received By/From Name -->
                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="received_by" id="received_by" value="<?php echo $received_by; ?>">
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="received_from" id="received_from" value="<?php echo $received_from; ?>">
                    </div>
                    
                </div>

                <div class="form-group">
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right">Signature over Printed Name</label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right">Signature over Printed Name</label>
                    </div>
                    
                </div>

                <!-- Received By/From Position -->
                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="received_by_position" id="received_by_position" value="<?php echo $received_by_position; ?>">
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="form-control" name="received_from_position" value="<?php echo $received_from_position; ?>">
                    </div>
                    
                </div>

                <div class="form-group">
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="center">Position/Office</label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right">Position/Office</label>
                    </div>
                    
                </div>

                <!-- Received Date By/From  -->
                <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="po_date_pckr form-control" name="received_by_date" id="received_by_date" value="<?php echo $received_by_date; ?>">
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-4" for="createdby" align="right">
                        <input type="text" class="po_date_pckr form-control" name="received_from_date" value="<?php echo $received_from_date; ?>">
                    </div>
                    
                </div>

                <div class="form-group">
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right">Date</label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-3" align="left">
                        <label class="control-label-left" align="right">Date</label>
                    </div>
                    
                </div>

                <hr>
                <div class="row">
                    <div class="form-group m-b-0">
                        <div class="col-sm-offset-7 col-sm-4">
                            <button type="button" onclick="goBack()" class="btn btn-inverse waves-effect w-md waves-light m-b-5">Back to Item List</button>
                        <button type="button" onclick="updateARE(<?php echo $are_id; ?>)" class="btn btn-primary waves-effect w-md waves-light m-b-5">Save</button>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div><!-- end col -->
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/eis/validation_are.js"></script>
<script type="text/javascript">
$(document).ready(function () {

        $('#datatable').dataTable({
            "processing": true,
            "language": {
                "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
            },
            "serverSide": true,
            "ajax": base_url + 'file/are/datatable_are_items',
            "order": [[ 0, "asc" ]],
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
            {
                var chckbox = '<button class="btn btn-xs btn-block" type="button" onclick="getItem(' + aData[0] +')">SELECT</button>';
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
        $.ajax({
            url: base_url + 'file/are/save_items',
            method: 'POST',
            cache: false,
            dataType: 'json',
            data: {prop_id: id, are_id: <?php echo $are_id; ?>},
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

    function deleteItem( id )
    {
        $.ajax({
            url: base_url + 'file/are/delete_items',
            method: 'POST',
            cache: false,
            dataType: 'json',
            data: {prop_id: id, are_id: <?php echo $are_id; ?>},
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

function updateARE( id )
    {
        // $('#hidden_id').val(id);

        $.ajax({
            url: base_url + 'file/are/are_header_update',
            method: 'POST',
            cache: false,
            dataType: 'json',
            data: $('#are_header').serialize(),
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