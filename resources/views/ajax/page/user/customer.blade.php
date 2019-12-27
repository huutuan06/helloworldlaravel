<div id="page_content_ajax" class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <button id="newCustomer" class="btn btn-default" type="button">New Customer</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatablesCustomer" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 5.00%; text-align: center">STT</th>
                                <th style="width: 15.00%; text-align: center">Name</th>
                                <th style="width: 20.00%; text-align: center">Email</th>
                                <th style="width: 20.00%; text-align: center">Phone Number</th>
                                <th style="width: 10.00%; text-align: center">Gender</th>
                                <th style="width: 10.00%; text-align: center">Date of Birth</th>
                                <th style="width: 20.00%; text-align: center">Address</th>
                                <th style="width: 10.00%; text-align: center">Manipulation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modal.customer.create')
@include('modal.customer.edit')
<script>
    $(document).ready(function () {
        $('#datatablesCustomer').dataTable({
            "pageLength": 15,
            "lengthMenu": [[15, 30, 45, -1], [15, 30, 45, 'All']],
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: '/admin/customer/route',
                type: 'GET'
            },

            "columns": [
                {"data": "id", "render": function (id) {
                        return '<div class="text-center">'+id+'</div>';
                    }
                },
                {"data": "name"},
                {"data": "email"},
                {"data": "phone_number"},
                {"data": "gender", "render": function (gender) {
                        if (gender == 1)
                            return '<div class="text-center">Female</div>';
                        else if (gender == 0)
                            return '<div class="text-center">Male</div>';
                        else
                            return '';
                    }
                },
                {"data": "date_of_birth"},
                {"data": "address"},
                {"data": "manipulation", "render": function (id) {
                        return '<div class="text-center">'
                            + '<a href="javascript:void(0)" onclick= "editUser(' + id + ')"><img src="/images/icon_edit.png"  width="18px" height="18px"></a>'
                            + '<span>  </span>' + '<a href="javascript:void(0)"  onclick="deleteUser(' + id + ')"><img src="/images/icon_delete.png"  width="18px" height="18px"></a>'
                            + '<input type="hidden" value="'+id+'"/></div>';
                    }
                }
            ]
        });
    });

    $('#newCustomer').click(function () {
        $('#customerFormCreate').each(function(){
            $(this).find(':input').val('')
        });
        $('#createCustomerModal').modal('show');
    });

    $(document).ready(function () {
        $('#customerFormCreate').on('submit', function (event) {
            $("#customerFormCreate").validate({
                rules: {
                    name: "required",
                    email: "required",
                    password: "required"
                },
                messages: {
                    name: "Please enter your name",
                    email: "Please enter your email address",
                    password: "Please enter your password"
                }
            });
            if (!$(this).valid()) return false;
            event.preventDefault();
            $('#createCustomerModal').modal('hide');
            var formData = new FormData(this);
            formData.append('gender', $("#customerFormCreate input[type='radio']:checked").val());
            $.ajax({
                url: '/admin/customer/route',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false
            })
                .done(function (data) {
                    if (data['message']['status'] === 'invalid') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] === 'existed') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] === 'success') {
                        swal("", data['message']['description'], "success");
                        var table = $('#datatablesCustomer').DataTable();
                        $.fn.dataTable.ext.errMode = 'none';
                        table.row.add(
                            [
                                data['user']['name'],
                                data['user']['email'],
                                data['user']['phone_number'],
                                function (gender) {
                                    if (gender === 1)
                                        return 'Female';
                                    else if (gender === 0)
                                        return 'Male';
                                    else
                                        return '';
                                },
                                data['user']['address'],
                                function (id) {
                                    return '<div class="text-center">'
                                        + '<a href="javascript:void(0)" onclick= "editUser(' + id + ')"><img src="/images/icon_edit.png"  width="18px" height="18px"></a>'
                                        + '<span>  </span>' + '<a href="javascript:void(0)" onclick="deleteUser(' + id + ')"><img src="/images/icon_delete.png"  width="18px" height="18px"></a>'
                                        + '</div>';
                                }
                            ]
                        ).draw();
                    } else if (data.status === 'error') {
                        swal("", data['message']['description'], "error");
                    }
                })
                .fail(function (error) {
                    console.log(error);
                });
        });

        $('#customerFormEdit').on('submit', function (event) {
            $("#customerFormEdit").validate({
                rules: {
                    _name: "required"
                },
                messages: {
                    _name: "Please fill name"
                }
            });
            if (!$(this).valid()) return false;
            event.preventDefault();

            $('#customerUserModal').modal('hide');
            var formData = new FormData(this);
            $.ajax({
                url: '/admin/customer/route/' + $('#_id').val(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false
            })
                .done(function (data) {
                    if (data['message']['status'] === 'invalid') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] === 'existed') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] === 'success') {
                        swal("", data['message']['description'], "success");
                        var table = $('#datatablesCustomer').DataTable();
                        $.fn.dataTable.ext.errMode = 'none';
                        var rows = table.rows().data();
                        for (var i = 0; i < rows.length; i++) {
                            if (rows[i].id == data['user']['id']) {
                                table.row(this).data(
                                    [
                                        data['user']['name'],
                                        data['user']['email'],
                                        data['user']['avatar'],
                                        data['user']['phone_number'],
                                        data['user']['gender'],
                                        data['user']['date_of_birth'],
                                        data['user']['address'],
                                        function (id) {
                                            return '<div class="text-center">'
                                                + '<a href="javascript:void(0)" onclick= "editUser(' + id + ')"><img src="/images/icon_edit.png"  width="18px" height="18px"></a>'
                                                + '<span>  </span>' + '<a href="javascript:void(0)" onclick="deleteUser(' + id + ')"><img src="/images/icon_delete.png"  width="18px" height="18px"></a>'
                                                + '</div>';
                                        }
                                    ]
                                ).draw();
                            }
                        }
                    } else if (data.status === 'error') {
                        swal("", data['message']['description'], "error");
                    }
                })
                .fail(function (error) {
                    console.log(error);
                });
        });
    });

    function editUser(id) {
        $.ajax({
            url: '/admin/customer/route/' + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            type: "GET",
            beforeSend: function () {
                $('#modal-loading').modal('show');
            }
        })
            .done(function (data) {
                $('#_id').val(data['user']['id']);
                $('#_name').val(data['user']['name']);
                $('#_phone_number').val(data['user']['phone_number']);
                $('#_address').val(data['user']['address']);
                var now = new Date(data['user']['date_of_birth']*1000);
                var day = ("0" + now.getDate()).slice(-2);
                var month = ("0" + (now.getMonth() + 1)).slice(-2);
                var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
                $('#_date_of_birth').val(today);
                $('#_avatar').attr('src', data['user']['avatar']);
                if (data['user']['gender'] === 0) {
                    $('#_gender').find(':radio[name="gender"][value="0"]').prop('checked', true);
                } else {
                    $('#_gender').find(':radio[name="gender"][value="1"]').prop('checked', true);

                }
                $('#modal-loading').modal('hide');
                $('#customerUserModal').modal('show');
            })
            .fail(function (error) {
                console.log(error);
            });
    }

    function deleteUser(id) {
        $.ajax({
            url: '/admin/customer/route/' + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            type: "DELETE",
            beforeSend: function () {
                $('#modal-loading').modal('show');
            }
        })
            .done(function (data) {
                $('#modal-loading').modal('hide');
                if (data['message']['status'] === 'success') {
                    swal("", data['message']['description'], "success");
                    var table = $('#datatablesCustomer').DataTable();
                    $.fn.dataTable.ext.errMode = 'none';
                    var rows = table.rows().data();
                    for (var i = 0; i < rows.length; i++) {
                        if (rows[i].name === data['name']) {
                            table.row(this).remove().draw();
                        }
                    }
                }
                if (data['message']['status'] === 'error') {
                    swal("", data['message']['description'], "error");
                }
            })
            .fail(function (error) {
                console.log(error);
            })
    }
</script>
