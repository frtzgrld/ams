

    function toggleDeleteAlert( proc_id, proc_mode )
    {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this record!",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger waves-effect waves-light',
            confirmButtonText: 'Delete!'
        },
        function(isConfirm)
        {
            if(isConfirm)
                deleteProcurement( proc_id, proc_mode );
        });
    }

    function deleteProcurement( proc_id, proc_mode )
    {
        $.ajax({
            url: base_url + 'procurement/delete_procurement',
            method: 'POST',
            dataType: 'json',
            async: true,
            data: { proc_id: proc_id, proc_mode: proc_mode },
            error: function(response)
            {
                alert('error');
            },
            success: function(response)
            {
                switch( response['result'] )
                {
                    case 'success':
                        $('#datatable_'+proc_mode).DataTable().ajax.reload(null, false);
                        setTimeout(function(){
                            swal(response['header'], response['message'], "success");
                        },  500 );
                        break;

                    default:
                        // financerLogin.resetProgressBar(true);
                        break;
                }
            }
        });
    }