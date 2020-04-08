        
        <a id="hidden_user_select_btn" href="#users_select_modal" class="btn btn-info btn-block waves-effect waves-light hidden" data-animation="door" data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a" ></a>

        <div id="users_select_modal" class="modal door" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" style="width:70%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="Custombox.close();">
                            <span>×</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="custom-width-modalLabel">USER SELECT DIALOG</h4>
                    </div>
                    <div class="modal-body" style="min-height: 250px;">
                        <form id="form_user_select" action="" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                            <input type="hidden" id="hidden_key">
                            <input type="hidden" id="visible_desc">
                            <input type="hidden" id="hidden_other">
                            <div class="form-group">
                                <label class="control-label-left col-sm-3" for="selected_option">Options:</label>
                                <div class="col-sm-6">
                                    <select name="selected_option" id="selected_option" class="form-control select2">
                                        <option value="in_office">Select from within office</option>
                                        <option value="all_users">Select from all active user</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 error-message"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label-left col-sm-3" for="selected_user">Select user:</label>
                                <div class="col-sm-6">
                                     <select name="selected_user" id="selected_user" class="form-control select2" onchange="optionSelectUser()">
                                        
                                    </select>
                                </div>
                                <div class="col-sm-3 error-message"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label-left col-sm-3" for="designation">Designation</label>
                                <div class="col-sm-6">
                                     <input type="text" name="designation" id="designation" class="form-control">
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
                                <button type="button" class="btn btn-block btn-success waves-effect waves-light" onclick="confirmSelection();">SELECT</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            
            function toggleSelectUser( hidden_key, visible_desc, hidden_other )
            {
                loadUserSelection();
                $('#hidden_key').val(hidden_key);
                $('#visible_desc').val(visible_desc);
                $('#hidden_other').val(hidden_other);
                $('#hidden_user_select_btn').click();
            }

            function optionSelectUser()
            {
                var user_id = $('#selected_user').val();

                if( user_id )
                {
                    user = user_id.split('%2d');
                    $('#designation').val(user[1]);
                }
            }

            function loadUserSelection()
            {
                var selOption = $('#selected_option').val();

                $.ajax({
                    url: base_url + 'account/users/get_user_list',
                    method: 'POST',
                    data: {office: selOption},
                    cache: false,
                    dataType: 'json',
                    async: true,
                    error: function(response)
                    {
                        alert('error');
                    },
                    success: function(response)
                    {
                        if(response.length == 0) {
                            $('#selected_user').html("No record found");
                        } else {
                            $('#selected_user').empty();
                            $.each(response, function(index, value){
                                $('#selected_user')
                                    .append($("<option></option>")
                                    .attr("value",response[index]['EMPLOYEENO']+'%2d'+response[index]['DESIGNATION'])
                                    .text(response[index]['FULLNAME'])); 
                            });
                        }
                    }
                });
            }

            function confirmSelection()
            {
                var hidden_key = $('#hidden_key').val(),
                    visible_desc = $('#visible_desc').val(),
                    hidden_other = $('#hidden_other').val(),
                    user_id = $('#selected_user').val(),
                    users = user_id.split('%2d');

                $('#'+hidden_key).val(users[0]);
                $('#'+visible_desc).val($('#selected_user').select2('data').text);
                $('#'+hidden_other).val(users[1]);

                Custombox.close();
            }

        </script>