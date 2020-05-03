<div id="supplies_modal" class="modal door" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" style="width:90%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="Custombox.close();">
                            <span>×</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="custom-width-modalLabel">SUPPLIES FORM</h4>
                    </div>

                    <div class="modal-body">
                        <form id="form_supplies"  method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                            <input type="hidden" name="hidden_supp_id" id="hidden_supp_id" value="0">
                            <input type="hidden" name="action" id="action" value="insert">
                            <div class="row">
								<div class="col-md-6">
									<div class="form-group">
									<label class="col-md-4 control-label-left" for="items">Item <span class="text-danger">*</span></label>
										<div class="col-md-8">
											<select name="items" id="items" class="form-control select2">
												<option value=""></option><?php
											
												if($item_list)
												foreach ($item_list as $item)
													echo '<option value="'.$item['ID'].'">'.$item['DESCRIPTION'].'</option>'; ?>

                                            </select>
										</div>
										<div class="col-md-8 col-md-offset-4 error-message"></div>
									</div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-3 control-label-left" for="unit_cost">Unit Cost <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
											<input type="text" class="form-control" name="unit_cost" id="unit_cost" >
                                        </div>
                                        <div class="col-md-8 col-md-offset-4 error-message"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
								<div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-4 control-label-left" for="qty_acquired">Quantity Acquired <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="qty_acquired" id="qty_acquired" >
                                        </div>
                                        <div class="col-md-8 col-md-offset-4 error-message"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-3 control-label-left" for="dateacquired">Date Acquired <span class="text-danger">*</span></label>
									   	<div class="col-sm-6">
											<input class="form-control text-strong datepicker-autoclose" data-date-format="yyyy/mm/dd" name="dateacquired" id="dateacquired" value="" placeholder="" type="text">
										</div>
                                        <div class="col-md-8 col-md-offset-4 error-message"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-4 control-label-left" for="estimated_useful_life">Estimated Useful Life </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="estimated_useful_life" id="estimated_useful_life" value="">
                                        </div>
                                        <div class="col-md-7 col-md-offset-5 error-message"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <label class="col-md-3 control-label-left" for="eul_unit">Estimated Useful Life Unit</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="eul_unit" id="eul_unit" value="">
                                        </div>
                                        <div class="col-md-7 col-md-offset-5 error-message"></div>
                                    </div>
                                </div>
                            </div>
							
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-7">
                                <button type="button" class="btn btn-block btn-default waves-effect" onclick="Custombox.close(); $('#form_supplies').find('.form-control').removeClass('.error')">Close</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="jQuery( $('#form_supplies').submit() );">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
			