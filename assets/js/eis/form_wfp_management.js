    
    $(document).ready(function () {

        $("#form_wfp_management").validate({
            ignore:'',
            rules: {
                hidden_wfp_id_approval: {
                    required: true,
                    maxlength: 11,
                    number: true,
                },
                status: {
                    required: true,
                    maxlength: 10,
                },
            },

            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.error-message').html(error);
            },

            submitHandler: function() {
                $.ajax({
                    url: base_url + 'budget/work_and_financial_plan/wfp_approval',
                    method: 'POST',
                    data: $('#form_wfp_management').serialize(),
                    cache: false,
                    dataType: 'json',
                    async: true,
                    error: function(response)
                    {
                        alert('error');
                    },
                    success: function(response)
                    {
                        switch( response['result'] )
                        {
                            case 'success':
                                swal(response['header'], response['message'], "success");
                                setTimeout(function(){
                                    window.location.reload();
                                },  1000 );
                                break;

                            default:
                                break;
                        }
                    }
                });
            }
        });
    });

    function toggleWFPApproval()
    {
        swal({
            title: "Are you sure you want to update the status of this WFP?",
            text: "This action is irreversible.",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger waves-effect waves-light',
            confirmButtonText: 'Yes!'
        },
        function (isConfirm) {
            if(isConfirm){
                jQuery($('#form_wfp_management').submit());
            }
        });
    }

    function toggleDeleteParticulars( wfp_item_id )
    {
        swal({
            title: "Are you sure you want to delete this item?",
            text: "You will not be able to recover this item.",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger waves-effect waves-light',
            confirmButtonText: 'Delete!'
        },
        function (isConfirm) {
            if(isConfirm){
                deleteParticular( wfp_item_id );
            }
        });
    }

    function printVoucher( voucher_no )
    {
        popup_window( base_url + 'file/vouchers/print_voucher/' + voucher_no );
    }

    function deleteParticular( wfp_item_id )
    {
        $.ajax({
            url: base_url + 'budget/work_and_financial_plan/remove_particulars',
            method: 'POST',
            cache: false,
            dataType: 'json',
            data: {wfp_item_id: wfp_item_id},
            async: true,
            error: function(response)
            {
                alert('error');
            },
            success: function(response)
            {
                switch( response['result'] )
                {
                    case 'success':
                        swal(response['header'], response['message'], "success");
                        setTimeout(function(){
                            window.location.reload();
                        },  2000 );
                        break;

                    case 'error':
                        swal(response['header'], response['message'], "error");
                        break;

                    default:
                        // financerLogin.resetProgressBar(true);
                        break;
                }
            }
        });
    }