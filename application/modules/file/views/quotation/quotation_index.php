        
        <div class="row m-b-10">
            <div class="col-sm-4">
                <a href="<?php echo base_url();?>file/quotations/new_request" class="btn btn-success btn-icon btn-block waves-effect waves-light"><i class="fa fa-plus"></i> CREATE REQUEST FOR QUOTATION</a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <table id="dtbl_purchase_reqs" class="table table-striped table-hover dt-responsive nowrap datatable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="10%">Quot. No.</th>
                                <th width="10%">P.R. No.</th>
                                <th width="10%">APP</th>
                                <th width="10%">Canvas No.</th>
                                <th width="15%">Date</th>
                                <th width="30%">Authority</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <a href="#modal_move_to_procurement" id="hidden_moveto_btn" class="btn btn-success btn-block waves-effect waves-light hidden" data-animation="door" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a">Hidden Button 1</a>

        <div id="modal_move_to_procurement" class="modal door" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" style="width:95%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="Custombox.close();">
                            <span>×</span><span class="sr-only">Close</span>
                        </button>
                        <h5 class="modal-title" id="custom-width-modalLabel">SELECT PROCUREMENT MODE</h5>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-3">
                                <h4 class="text-strong m-t-0"></h4>
                            </div>
                            <div class="col-sm-9" style="border-left: 1px solid #ebebeb;">
                                <form method="post" id="form_assign_proc_mode" action="" role="form" class="form-horizontal">
                                    <input type="hidden" name="hidden_pr_id" id="hidden_pr_id" value="0">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label-left" for="mt_proc_mode">Description:</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="mt_description" id="mt_description" class="form-control" value="">
                                        </div>
                                        <div class="col-sm-2 error-message"></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label-left" for="mt_proc_mode">Procurement Mode:</label>
                                        <div class="col-sm-8">
                                            <select class="form-control select2" name="mt_proc_mode" id="mt_proc_mode" onchange="toggleModes()"><?php

                                            foreach (procurement_modes() as $modes): ?>

                                                <option value="<?php echo $modes['ID'].'%2D'.$modes['PROCEDURAL'].'%2D'.$modes['ACRONYM'];?>"><?php echo $modes['DESCRIPTION'];?></option><?php

                                            endforeach; ?>

                                            </select>
                                        </div>
                                        <div class="col-sm-2 error-message"></div>
                                    </div>

                                    <hr>

                                    <div id="procedural" style="display: block;">
                                        <div class="row"><?php $two_in_row_ctr = 0;

                                        foreach ( bidding_procedures() as $procedures ):
                                            $two_in_row_ctr++; ?>

                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4"><?php echo $procedures['DESCRIPTION']; ?></label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <input type="hidden" name="mt_proc_id[]" value="<?php echo $procedures['ID']; ?>">
                                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker_autoclose_<?php echo $procedures['ID']; ?>" name="mt_procedures[]">
                                                            <span class="input-group-addon bg-primary b-0 text-white"><i class="ti-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 error-message"></div>
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                $(document).ready(function(){
                                                    jQuery('#datepicker_autoclose_<?php echo $procedures['ID']; ?>').datepicker({
                                                        autoclose: true,
                                                        todayHighlight: true
                                                    });
                                                });
                                            </script><?php

                                            if( $two_in_row_ctr == 2 )
                                            {
                                                echo '</div><div class="row">';
                                                $two_in_row_ctr = 0;
                                            }

                                        endforeach; ?>

                                        </div>
                                    </div>

                                    <div id="non_procedural" style="display: none;">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="mt_description">Description (for non-bidding)</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control text-strong" name="mt_description_2" id="mt_description_2" placeholder="" type="text"></textarea>
                                            </div>
                                            <div class="col-sm-2 error-message"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-7">
                                <button type="button" class="btn btn-block btn-default waves-effect" data-dismiss="modal" onclick="Custombox.close()">Close</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="jQuery( $('#form_assign_proc_mode').submit() );">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo base_url(); ?>assets/js/eis/form_moveto_proc_mode.js"></script>
        <script type="text/javascript">

            $(document).ready(function () {

                $('#button_placement').html(

                    );

                $('#dtbl_purchase_reqs').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
                    "serverSide": true,
                    "ajax": base_url + 'file/quotations/datatable_quotation',
                    "order": [[ 0, "asc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
                        var btnDetail = "<a class='btn btn-info btn-icon btn-xs btn-icon icon-left' href='" + base_url + 'file/quotations/quotation_detail/' + aData[6] + "'><i class='ti ti-info-alt'></i> Detail</a> ",

                            btnDelete = "<button class='btn btn-danger waves-effect waves-light btn-xs' onclick='toggleDeleteAlert(" + aData[6] + ")'><i class='ti ti-trash'></i></button>"

                            btnAction = btnDetail + btnDelete;

                        $('td:eq(0)', nRow).html( aData[0] );
                        $('td:eq(1)', nRow).html( aData[1] );
                        $('td:eq(2)', nRow).html( aData[2] );
                        $('td:eq(3)', nRow).html( aData[3] );
                        $('td:eq(4)', nRow).html( aData[4] );
                        $('td:eq(5)', nRow).html( aData[5] );
                        $('td:eq(6)', nRow).html( btnAction );
                    },
                    "aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "aoColumns": [ 
                        {"sClass": "text-left"},
                        {"sClass": "text-left"},
                        {"sClass": "text-left"},
                        {"sClass": "text-left"},
                        {"sClass": "text-left"},
                        {"sClass": "text-left"},
                        {"sClass": "text-left", "bSortable": false, "bSearchable": false},
                    ] 
                });

                $('#dtbl_purchase_reqs_length select').select2();
                $('#dt-search').keyup(function(){
                    $('#dtbl_purchase_reqs').DataTable().search($(this).val()).draw() ;
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

            function getDirectory( url )
            {
                Custombox.close();
                setTimeout(function(){
                    window.location = url;
                }, 500);
            }

            function toggleMoveTo( purchase_request )
            {
                $.ajax({
                    url: base_url + 'purchase_requests/get_purchase_request_detail',
                    method: 'POST',
                    data: {purchase_request: purchase_request},
                    cache: false,
                    dataType: 'json',
                    error: function(response)
                    {
                        alert('error');
                    },
                    success: function(response)
                    {
                        if( response.constructor == Array )
                        {
                            $('#hidden_pr_id').val( response[0]['ID'] );
                            $('#modal_move_to_procurement h4').html( '<small>OFFICE:</small><br>'+response[0]['OFFICE'] + '<br><br><small>AMOUNT:</small><br><span class="text-green text-strong">PHP ' + add_commas(parseFloat(response[0]['AMOUNT']).toFixed(2)) + '</span>');
                            $('#mt_description').val(response[0]['PURPOSE']);
                            $('#hidden_moveto_btn').click();
                        }
                    }
                });
            }

            function toggleModes()
            {
                var mode = $('#mt_proc_mode').val(),
                    mode = mode.split('%2D');

                switch( mode[1] )
                {
                    case '0':
                        $('#non_procedural').show();
                        $('#procedural').hide();
                        break;

                    case '1':
                    default:
                        $('#procedural').show();
                        $('#non_procedural').hide();
                        break;
                }
            }

        </script>