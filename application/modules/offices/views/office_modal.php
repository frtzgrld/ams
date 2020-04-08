
        <div id="office_modal" class="modal door" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" style="width:70%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="Custombox.close();">
                            <span>×</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="custom-width-modalLabel">DIVISION / OFFICE / UNIT</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_office" action="" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                            <input type="hidden" name="hidden_office_id" id="hidden_office_id" value="0">
                            <input type="hidden" name="action" id="action" value="insert">

                            <div class="row">
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label-left" for="office_desc">Office Description: <span class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="office_desc" id="office_desc" placeholder="Name of this new office">
                                        </div>
                                        <div class="col-sm-12 error-message"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label-left col-sm-12" for="office_code">Office Code: <span class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="office_code" id="office_code" placeholder="Office code">
                                        </div>
                                        <div class="col-sm-12 error-message"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label-left col-sm-12" for="office_acronym">Abbrev/Acronym:</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="office_acronym" id="office_acronym" placeholder="">
                                        </div>
                                        <div class="col-sm-12 error-message"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label-left col-sm-12" for="office_rank">Rank:</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="office_rank" id="office_rank" placeholder="Rank (for the purpose of org. chart)">
                                        </div>
                                        <div class="col-sm-12 error-message"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label-left col-sm-12" for="office_ppmp">Can create PPMP? <span class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <select name="office_ppmp" id="office_ppmp" class="form-control select2">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-12 error-message"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-7">
                                <button type="button" class="btn btn-block btn-default waves-effect" onclick="Custombox.close(); $('#form_office').find('.form-control').removeClass('.error')">Close</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="jQuery( $('#form_office').submit() );">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="<?php echo base_url();?>assets/js/eis/office_management.js"></script>