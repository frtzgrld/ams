
    $(document).ready(function () {
        $("#app_header").validate({
            ignore:'',
            rules: {
                year: {
                    required: true,
                    maxlength: 4,
                },
                description: {
                    required: true,
                    maxlength: 250,
                },
                createdby: {
                    required: true,
                    maxlength: 50,
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