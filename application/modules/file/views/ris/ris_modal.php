<div id="ris_modal" class="modal door" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" style="width:90%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="Custombox.close();">
                            <span>×</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="custom-width-modalLabel">REQUISITION AND ISSUANCE SLIP FORM</h4>
                    </div>

                    <div class="modal-body">
                        <form id="form_ris"  method="post" action="ris/" class="form-horizontal" role="form" enctype="multipart/form-data">
                            <input type="hidden" name="hidden_ris_id" id="hidden_ris_id" value="0">
                            <input type="hidden" name="action" id="action" value="insert">
                            <div class="row">
								<div class="col-md-6">
									<div class="form-group">
									<label class="col-md-4 control-label-left" for="ris_no">RIS No: <span class="text-danger">*</span></label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="ris_no" id="ris_no" value="">
										</div>
										<div class="col-md-8 col-md-offset-4 error-message"></div>
									</div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-3 control-label-left" for="dept">Requesting Department: <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <select name="dept" id="dept" class="form-control select2">
                                            <option value=""></option><?php
                                        	if($offices)
												foreach ($offices as $item)
													echo '<option value="'.$item['ID'].'">'.$item['DESCRIPTION'].'</option>'; ?>

                                            </select>
                                        </div>
                                        <div class="col-md-8 col-md-offset-4 error-message"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
								<div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-4 control-label-left" for="purpose">Purpose <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="purpose" id="purpose" >
                                        </div>
                                        <div class="col-md-8 col-md-offset-4 error-message"></div>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-7">
                                <button type="button" class="btn btn-block btn-default waves-effect" onclick="Custombox.close(); $('#form_ris').find('.form-control').removeClass('.error')">Close</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="jQuery( $('#form_ris').submit() );">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
			