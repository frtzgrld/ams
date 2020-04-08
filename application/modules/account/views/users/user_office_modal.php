
        <a id="hidden_user_office_button" href="#user_office_modal" class="btn btn-info btn-block waves-effect waves-light hidden" data-animation="door" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a" ></a>

        <div id="user_office_modal" class="modal door" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" style="width:90%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="Custombox.close();">
                            <span>×</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="custom-width-modalLabel">USER ACCOUNT FORM</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_user" action="" method="post" class="form-horizontal" role="form" >
                            <input type="hidden" name="hidden_user_id" id="hidden_user_id" value="0">
                            <input type="hidden" name="action" id="action" value="insert">

                            <div class="form-group">
                                <label class="col-sm-3 control-label-left" for="employee">Select Office / Unit: <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <select class="form-control select2" name="employee" id="employee">
                                        <option></option><?php

                                    if( office_list(true) )
                                        foreach (office_list(true) as $o) {
                                            echo '<option value="'.$o['ID'].'">'.$o['DESCRIPTION'].'</option>';
                                        }   ?>

                                    </select>
                                </div>
                                <div class="col-sm-3 error-message"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label-left" for="username">Designation: <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="username" id="username">
                                </div>
                                <div class="col-sm-3 error-message"></div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-7">
                                <button type="button" class="btn btn-block btn-default waves-effect" onclick="Custombox.close();">Close</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="jQuery( $('#form_user').submit() );">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            
            function toggle_user( user_id )
            {
                $('#hidden_user_id').val('0');
                $('#action').val("insert");
                $('#employee').val('').trigger('change');
                $('#user_group').val('').trigger('change');
                $('#username').val('')
                $('#password').val('');

                if( user_id )
                {
                    $.ajax({
                        url: base_url + 'account/users/get_user_detail',
                        method: 'POST',
                        data: {user_id: user_id},
                        cache: false,
                        dataType: 'json',
                        async: true,
                        error: function(response)
                        {
                            alert('error');
                        },
                        success: function(response)
                        {
                            if( response )
                            {
                                $('#hidden_user_id').val(response[0]['USERID']);
                                $('#action').val('update');
                                $('#employee').val(response[0]['EMPLOYEENO']).trigger('change');
                                $('#user_group').val(response[0]['GROUPID']).trigger('change');
                                $('#username').val(response[0]['USERNAME'])
                                $('#password').val(response[0]['PASSWORD']);
                            }
                        }
                    });
                }
                
                $('#hidden_user_office_button').click();
            }

        </script>