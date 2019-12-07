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
                        <table id="datatablesUser" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 20.00%; text-align: center">Name</th>
                                <th style="width: 20.00%; text-align: center">Email</th>
                                <th style="width: 20.00%; text-align: center">Phone Number</th>
                                <th style="width: 5.00%; text-align: center">Gender</th>
                                <th style="width: 10.00%; text-align: center">Date of Birth</th>
                                <th style="width: 25.00%; text-align: center">Address</th>
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
        $('#datatablesUser').dataTable({
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
                url: '/admin/customer',
                type: 'GET'
            },

            "columns": [
                {"data": "name"},
                {"data": "email"},
                {"data": "phone_number"},
                {"data": "gender", "render": function (gender) {
                        if (gender === 1)
                            return 'Female';
                        else if (gender === 0)
                            return 'Male';
                        else
                            return '';
                    }
                },
                {"data": "date_of_birth"},
                {"data": "address"},
                {"data": "manipulation", "render": function (id) {
                        return '<div class="text-center">'
                            + '<a href="javascript:void(0)" onclick= "editUser(' + id + ')"><img src="/images/icon_edit.png"  width="18px" height="18px"></a>'
                            + '<span>  </span>' + '<a href="javascript:void(0)' + id + '" onclick="deleteUser(' + id + ')"><img src="/images/icon_delete.png"  width="18px" height="18px"></a>'
                            + '</div>';
                    }
                }
            ]
        });
    });

    $('#newCustomer').click(function () {
        $('#createCustomerModal').modal('show');
        $('#customerFormCreate')
            .find('img').attr('src', '/images/users/profile.png')
            .find(':radio[name="gender"][value="0"]').prop('checked', false)
            .find(':radio[name="gender"][value="1"]').prop('checked', false)
            .find('input[type=text], input[type=password], input[type=number], input[type=email], input[type=file], input[type=date], input[type=radio] textarea').val('');
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
            $.ajax({
                url: '/admin/user',
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
                        var table = $('#datatablesUser').DataTable();
                        $.fn.dataTable.ext.errMode = 'none';
                        table.row.add(
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
                    } else if (data.status === 'error') {
                        swal("", data['message']['description'], "error");
                    }
                })
                .fail(function (error) {
                    console.log(error);
                });
        });

        $('#userFormEdit').on('submit', function (event) {
            $("#userFormEdit").validate({
                rules: {
                    name: "required",
                    email: "required",
                    password: "required",
                    phone_number: "required",
                    date_of_birth: "required",
                    gender: "required",
                    address: "required",
                },
                messages: {
                    name: "Please fill name",
                    email: "Please fill email",
                    password: "Please fill password",
                    phone_number: "Please fill phone number",
                    date_of_birth: "Please choose the birthday",
                    gender: "Please choose gender",
                    address: "Please fill address"
                }
            });
            if (!$(this).valid()) return false;
            event.preventDefault();

            $('#editUserModal').modal('hide');
            var formData = new FormData(this);
            $.ajax({
                url: '/admin/user/' + $('#editUserId').val(),
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
                    console.log(data['message']['status']);
                    if (data['message']['status'] === 'invalid') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] === 'existed') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] === 'success') {
                        swal("", data['message']['description'], "success");
                        var table = $('#datatablesUser').DataTable();
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
            url: '/admin/user/' + id,
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
                $('#editUserId').val(data['user']['id']);
                $('#editUserName').val(data['user']['name']);
                $('#editUserEmail').val(data['user']['email']);
                $('#editUserPhoneNumber').val(data['user']['phone_number']);
                $('#editUserPassword').val(data['user']['password']);
                $('#editUserAddress').val(data['user']['address']);

                $('#editUserBirthDay').val(data['user']['date_of_birth']);
                $('#showEditAvatar').attr('src', data['user']['avatar']);
                if (data['user']['gender'] === 0) {
                    $('#editUserGender').find(':radio[name="gender"][value="0"]').prop('checked', true);
                } else {
                    $('#editUserGender').find(':radio[name="gender"][value="1"]').prop('checked', true);

                }
                $('#modal-loading').modal('hide');
                $('#editUserModal').modal('show');
            })
            .fail(function (error) {
                console.log(error);
            });
    }

    function deleteUser(id) {
        $.ajax({
            url: '/admin/customer/' + id,
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
                    var table = $('#datatablesUser').DataTable();
                    $.fn.dataTable.ext.errMode = 'none';
                    var rows = table.rows().data();
                    for (var i = 0; i < rows.length; i++) {
                        if (rows[i].id === data['id']) {
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
