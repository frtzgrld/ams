<!-- <pre><?php print_r($this->session->all_userdata()); ?></pre>  -->
<!-- <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form id="app_details_save" action="" method="post" class="form-horizontal" role="form">

        
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
</div>   -->

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
                    
                    <div class="col-sm-3" for="createdby" align="left">
                        <select name="office" id="office" class="form-control select2" placeholder="Select Office">
                        <option value=""> </option><?php
                        foreach ($offices as $row): ?>
                            <option value="<?php echo $row['ID'];?>"><?php echo $row['DESCRIPTION'];?></option><?php
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
                        <input type="text" class="form-control" name="ris_no" id="ris_no" value="RIS-<?php echo $risno; ?>">
                    </div>
                    
                    <!-- <div class="col-sm-3" for="createdby" align="left">
                        <input type="text" class="form-control" name="po_no" id="po_no" value="">
                    </div> -->
                    <!-- <div class="col-md-9 col-md-offset-9 error-message"></div> -->
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
                        <input class="form-control text-strong datepicker-autoclose" name="requested_date" id="requested_date" type="text" placeholder="" value="">
                    </div>
                    <!-- <div class="col-md-9 col-md-offset-9 error-message"></div> -->
                </div>

               
			<!-- <div class="col-sm-6">
                <div class="m-b-30">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">Add Items</button>
                </div>
            </div> -->

                <!-- ARE ITEMS-->
                <!-- <table class="table table-striped m-0">
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
                
            </thead> -->
          
                <!-- <tbod> -->
              <!-- <?php 
           if(!empty($are_items_list))
            {
                // echo print_r($items,true);
                foreach ($are_items_list as $key) 
                :?> -->
                <!-- <tr>
                    <td><?php echo $key['SERIALNO']; ?></td>
                    <td><?php echo $key['ARE_NO']; ?></td>
                    <td><?php echo $key['DESCRIPTION']; ?></td>
                    <td><?php echo $key['UNITCOST']; ?></td>
                    <td><?php echo $key['SERIALNO']; ?></td>
                    <td><?php echo $key['ARE_NO']; ?></td>
                    <td> <?php if($key['prop_id'] == null) { echo '<button class="btn btn-primary waves-effect waves-light" onclick="deleteItem('.$key['prop_id'].')" >Add</button>'; } else { echo '<button class="btn btn-primary waves-effect waves-light" onclick="deleteItem('.$key['prop_id'].')" >Delete</button>'; }?> </td>
                </tr> -->
                <!-- <?php endforeach; 
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
                <br/> -->

              <!--   <div class="form-group">
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Purpose</label>
                    </div>
                    
                    <div class="col-sm-10" for="createdby" align="right">
                        <input type="text" class="form-control" name="purpose" id="purpose" value="">
                    </div>
                </div> -->

                <br/>


                <!-- <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Requested By:</label>
                    </div>
                    
                   
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Noted By:</label>
                    </div>

                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Approved for Release:</label>
                    </div>

                </div> -->

               

                <!-- <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <input type="text" class="form-control" name="requested_by" id="requested_by" value="">
                        <br/> Name and Signature
                    </div>
                    
                   
                    <div class="col-sm-2" align="left">
                        <input type="text" class="form-control" name="noted_by" id="noted_by" value="">
                        <br/>
                        Department Head
                    </div>

                    <div class="col-sm-2" align="left">
                    <input type="text" class="form-control" name="approved_by" id="approved_by" value="">
                    <br/>
                    Lanie N. MAcabaya<br/>
                    Supply Officer III
                    </div>

                   
                   
                </div> -->
                <br/><br/>
<!-- 
                <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Released By:</label>
                    </div>
                    
                   
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Received By:</label>
                    </div>

                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right">Posted by:</label>
                    </div>

                </div> -->


                <!-- <div class="form-group">
                    <div class="col-sm-1" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <label class="control-label-left" align="right"></label>
                    </div>
                    <div class="col-sm-2" align="left">
                        <input type="text" class="form-control" name="issued_by" id="issued_by" value="">
                    </div>
                    
                   
                    <div class="col-sm-2" align="left">
                        <input type="text" class="form-control" name="received_by" id="received_by" value="">
                    </div>

                    <div class="col-sm-2" align="left">
                    <input type="text" class="form-control" name="posted_by" id="posted_by" value="">
                    </div>
                </div>

                
 -->

                <hr>
                <div class="row">
                    <div class="form-group m-b-0">
                        <div class="col-sm-offset-7 col-sm-4">
                            <button type="button" onclick="goBack()" class="btn btn-inverse waves-effect w-md waves-light m-b-5">Back to Item List</button>
                        <button type="submit" class="btn btn-primary waves-effect w-md waves-light m-b-5">Save</button>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div><!-- end col -->
</div>

<script type="text/javascript">
		$(document).ready(function () {
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
		var risno = $("#ris_no").val();
        $.ajax({
            url: base_url + 'file/ris/save_items',
			method: 'POST',
			data: {item_id: id, ris_no: risno},
            cache: false,
            dataType: 'json',
            async: true,
            error: function(response)
            {
                alert('error');
            },
            success: function(response)
            {
                
				window.location = response['redirect'];
				
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
                $('#save_ris_id').val( response[0]['RIS'] );
                jQuery('#editcon-close-modal').modal('show');
            }
        });

        // jQuery('#con-close-modal').modal('hide');
    }

</script>
