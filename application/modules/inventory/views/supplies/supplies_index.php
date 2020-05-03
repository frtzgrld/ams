        
        

        <div class="row">

            <div class="col-sm-12">
                <div class="card-box">
                    <table id="datatable_supplies" class="table table-striped table-hover dt-responsive nowrap">
                        <thead>
                            <tr class="table-ams">
                                <th width="25%">Supplies</th>
                                <th width="10%">Stock</th>
                                <th width="10%">Unit</th>
                                <th width="8%">Min Qty</th>
                                <th width="8%">Max Qty</th>
                                <th width="10%">Stock Status</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        

        <script type="text/javascript">

            $(document).ready(function () {

                $('#datatable_supplies').dataTable({
                    "processing": true,
                    "language": {
                        "processing": '<img src="'+base_url+'assets/images/loaders/search_loader_1.gif" width="120px"/> Loading. Waiting for response...'
                    },
                    "serverSide": true,
                    "ajax": base_url + 'inventory/supplies/datatable_supplies',
                    "order": [[ 0, "asc" ]],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) 
                    {
                        var buttons = "<a class='btn btn-info btn-xs btn-icon icon-left' href='" + base_url + 'inventory/supplies/acquisitions/' + aData[6] + "'><i class='ti ti-info-alt'></i> Detail</a> " 
                            + "<button class='btn btn-success waves-effect waves-light btn-xs' onclick='toggle_office(" + aData[6] + ")'><i class='ti ti-pencil-alt'></i> Edit</button>"
                            + "<button class='btn btn-danger waves-effect waves-light btn-xs' onclick='deleteItem(" + aData[6] + ")'><i class='ti zmdi-delete'></i> Delete</button>";

                        $('td:eq(0)', nRow).html( aData[0] );
                        $('td:eq(1)', nRow).html( '<span class="text-strong">'+add_commas(parseInt(aData[1]))+'</span>' );
                        $('td:eq(2)', nRow).html( aData[2] );
                        $('td:eq(3)', nRow).html( add_commas(aData[3]) );
                        $('td:eq(4)', nRow).html( add_commas(aData[4]) );
                        $('td:eq(5)', nRow).html( aData[5] );
                        $('td:eq(6)', nRow).html( buttons );
                    },
                    "aLengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
                    "aoColumns": [ 
                        {"sClass": "text-left"},
                        {"sClass": "text-right"},
                        {"sClass": "text-center"},
                        {"sClass": "text-right"},
                        {"sClass": "text-right"},
                        {"sClass": "text-center"},
                        {"sClass": "text-left"},
                    ]
                });

                datatable_filter_overrides('datatable_supplies');

                $('#dt-search').keyup(function(){
                    $('#datatable_supplies').DataTable().search($(this).val()).draw() ;
                });

                $("#form_office").validate({
                    ignore:'',
                    rules: {
                        hidden_office_id: {
                            required: true,
                            maxlength: 11,
                            number: true,
                        },
                        of_desc: {
                            required: true,
                            maxlength: 250,
                        },
                        of_parent: {
                            required: false,
                            maxlength: 11,
                        },
                        of_ppmp: {
                            required: true,
                            maxlength: 2,
                        },
                    },

                    errorPlacement: function (error, element) {
                        $(element).closest('.form-group').find('.error-message').html(error);
                    },

                    submitHandler: function() {
                        $.ajax({
                            url: base_url + 'offices/validate_office',
                            method: 'POST',
                            data: $('#form_office').serialize(),
                            cache: false,
                            dataType: 'json',
                            async: true,
                            error: function(response)
                            {
                                alert('error');
                            },
                            success: function(response)
                            {
                                Custombox.close();
                                switch( response['result'] )
                                {
                                    case 'success':
                                        $('#datatable_supplies').DataTable().ajax.reload(null, false);
                                        setTimeout(function(){
                                            swal(response['header'], response['message'], "success");
                                        },  500 );
                                        break;

                                    default:
                                        break;
                                }
                            }
                        });
                    }
                });
            });


        </script>

