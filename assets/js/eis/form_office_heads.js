
    $(document).ready(function () {

        $("#form_office_heads").validate({
            ignore:'',
            rules: {
                action: {
                    required: true,
                    maxlength: 6,
                },
            },

            errorPlacement: function (error, element) {
                $(element).closest('.form-group').find('.error-message').html(error);
            },

            submitHandler: function() {
                $.ajax({
                    url: base_url + 'offices/validate_office_heads',
                    method: 'POST',
                    data: $('#form_office_heads').serialize(),
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
                                setTimeout(function(){
                                    swal(response['header'], response['message'], "success");
                                },  500 );
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