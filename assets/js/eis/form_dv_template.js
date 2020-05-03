
	$(document).ready(function() {

		addChecklist(0);

		$("#form_dv_template").validate({
			ignore:'',
			rules: {
				dvt_title: {
					required: true,
					maxlength: 250,
				},
				dvt_purpose: {
					required: false,
					maxlength: 250,
				},
				checklist: {
					required: true,
					maxlength: 11,
					number: true,
				},
				rank: {
					required: true,
					maxlength: 10,
					number: true,
				},
				isrequired: {
					required: true,
					maxlength: 1,
				},
				remark: {
					required: false,
					maxlength: 250,
				},
			},

			errorPlacement: function (error, element) {
				$(element).closest('.form-group').find('.error-message').html(error);
			},

			submitHandler: function() {
				$.ajax({
					url: base_url + 'vouchers/validate_dv_template',
					method: 'POST',
					dataType: 'json',
					async: true,
					data: $("#form_dv_template").serialize(),
					error: function(response)
					{
						// toggleError(response);
						alert('error');
					},
					success: function(response)
					{
						switch( response['result'] )
						{
							case 'success':
								swal({
									title: response['header'],
									text: response['message'],
									timer: 1000
								});
								setTimeout(function() {
									if( response['redirect'] != null )
										window.location.href = response['redirect'];
								}, 	1500);
								break;

							default:
								break;
						}
					}
				});
			}
		});
	});

	function addChecklist(row_count)
    {
        row_count += 1;
        $('#tbody_dv_checklists').append(
                '<tr id="row_' + row_count + '">' +
                    '<td>' +
                        '<select class="form-control select2" name="checklist[]" id="checklist_' + row_count + '">' +
                            '<option></option>' +
                        '</select>' +
                    '</td>' +
                    '<td>' +
                        '<input type="text" class="form-control touchspin text-center" name="rank[]" id="rank_' + row_count + '" value="' + row_count + '">' +
                    '</td>' +
                    '<td>' +
                        '<select class="form-control" data-color="#00b19d" name="isrequired[]" id="isrequired_' + row_count + '">' +
                            '<option selected value="0">NO</option>' +
                            '<option value="1">YES</option>' +
                    '</td>' +
                    '<td>' +
                        '<input type="text" class="form-control" name="remark[]" id="remark_' + row_count + '">' +
                    '</td>' +
                    '<td>' +
                        '<button class="btn btn-block btn-trans btn-danger" type="button" onclick="confirmChecklistRemoval(' + row_count + ')"><i class="zmdi zmdi-delete"></i></button>' +
                    '</td>' +
                '</tr>'
            );

        $("#rank_"+row_count).TouchSpin({
            buttondown_class: "btn btn-custom",
            buttonup_class: "btn btn-custom"
        });

        $("#checklist_"+row_count).select2();
        $("#isrequired_"+row_count).select2();

        loadChecklistSelection('checklist_', row_count);

        // $("#isrequired_"+row_count).switchery();

        $('#addchecklistbtn').attr('onclick', "addChecklist("+row_count+")");
    }

    function loadChecklistSelection( id, row_count )
    {
        // var selOption = $('#selected_option').val();

        $.ajax({
            url: base_url + 'vouchers/get_checklists',
            method: 'POST',
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
                    $('#'+id+row_count).html("No record found");
                } else {
                    $('#'+id+row_count).empty();
                    $.each(response, function(index, value){
                        $('#'+id+row_count)
                            .append($("<option></option>")
                            .attr("value",response[index]['ID'])
                            .text(response[index]['DESCRIPTION'])); 
                    });
                }
            }
        });
    }

    function confirmChecklistForm()
    {
        swal({
            title: "Are you sure?",
            text: "If you already verified the template you've prepared, click 'Yes, proceed'",
            type: "info",
            showCancelButton: true,
            confirmButtonClass: 'btn-info waves-effect waves-light',
            confirmButtonText: 'Yes, proceed!'
        },
        function isConfirm(){
            if( isConfirm )
                $('#form_dv_template').submit();
        });
    }

    function confirmChecklistRemoval( row_count )
    {
        swal({
            title: "Are you sure?",
            text: "If you really want to remove this checklist item, click 'Yes, remove'",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger waves-effect waves-light',
            confirmButtonText: 'Yes, remove'
        },
        function isConfirm(){
            if( isConfirm )
                $('#row_'+row_count).remove();
        });
    }