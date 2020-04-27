
    $(document).ready(function () {
        $("#ris_header").validate({
            ignore:'',
            rules: {
                office: {
                    required: true,
                    maxlength: 4,
                },
                rcc: {
                    required: true,
                    maxlength: 250,
                },
                ris_no: {
                    required: true,
                    maxlength: 250,
                },
                purpose: {
                    required: true,
                    maxlength: 250,
                },
            },

            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.error-message').html(error);
            },

        });
    });

    function toggleDeleteAlert( item_id )
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