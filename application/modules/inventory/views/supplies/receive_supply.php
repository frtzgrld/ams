            
            <form method="post" id="form_receive_supply" action="" role="form" class="form-horizontal">
                <input type="hidden" name="hidden_supply_id" id="hidden_supply_id" value="0">
                <input type="hidden" name="hidden_return_address" id="hidden_return_address" value="">
                <input type="hidden" name="hidden_action" id="hidden_action" value="insert">
                <div class="panel">
                    <header class="panel-heading">
                        <label>RECEIVE SUPPLY FORM</label>
                    </header>
                    <hr>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Acquired</label>
                            <div class="col-sm-6">
                                <input class="form-control text-strong datepicker-autoclose" name="dateacquired" id="dateacquired" placeholder="" type="text">
                            </div>
                            <div class="col-sm-12 error-message"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Supplier</label>
                            <div class="col-sm-6">
                                <input class="form-control text-strong" name="supplier" id="supplier" placeholder="" type="text">
                            </div>
                            <div class="col-sm-12 error-message"></div>
                        </div>
                    </div>

                    <!-- <input type="text" name="row_ctr" id="row_ctr" value="1"> -->
                    <table class="table table-bordered" >
                        <thead>
                            <tr style="border-top: 1px solid #e0e0e0;">
                                <th width="30%">Item Description</th>
                                <th width="20%">Unit Cost</th>
                                <th width="20%">Quantity</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody id="tbody_supply">
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="10">
                                    <div class="col-md-2 col-md-offset-10">
                                        <button type="button" class="btn btn-block btn-default waves-effect" id="btn_add_row" onclick="addRow(2)">Add item</button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <div class="panel-footer">
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-2 col-md-offset-7">
                                <button type="reset" class="btn btn-block btn-default waves-effect">Reset</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="jQuery( $('#form_receive_supply').submit() );">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
            <script src="<?php echo base_url(); ?>assets/js/ams/form_receive_supply.js"></script>
