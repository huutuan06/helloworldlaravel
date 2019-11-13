<div id="page_content_ajax" class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <button id="newUser" class="btn btn-default" type="button">New User</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <p class="text-muted font-13 m-b-30">
                            DataTables has most features enabled by default, so all you need to do to use it with your
                            own tables is to call the construction function: <code>$().DataTable();</code>
                        </p>
                        <table id="datatablesUser" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 5.00%">ID</th>
                                <th style="width: 20.00%">Name</th>
                                <th style="width: 20.00%">Email</th>
                                <th style="width: 5.00%">Avatar</th>
                                <th style="width: 5.00%">Gender</th>
                                <th style="width: 10.00%">Date of Birth</th>
                                <th style="width: 25.00%">Address</th>
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
@include('modal.user.create')
@include('modal.user.edit')
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
                url: '/admin/user',
                type: 'GET'
            },

            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "email"},
                {
                    "data": "avatar", "render": function (avatar) {
                        return '<img src="' + avatar + '" width="56px;" height="56px;" alt="avatar"/>';
                    }
                },
                {
                    "data": "gender", "render": function (gender) {
                        if (gender == 1)
                            return '<div class="text-center">'
                                + '<img src="/images/icon_gender_female.png"  width="24px" height="24px">'
                                +'</div>';
                    else
                        return '<div class="text-center">'
                            + '<img src="/images/icon_gender_male.png"  width="24px" height="24px">'
                            +'</div>';
                    }
                },

                {"data": "date_of_birth"},
                {"data": "address"},
                {
                    "data": "manipulation", "render": function (id) {
                        return '<div class="text-center">'
                            + '<a href="javascript:void(0)" onclick= "editUser(' + id + ')"><img src="/images/icon_edit.svg"  width="24px" height="24px"></a>'
                            + '<span>  </span>' + '<a href="javascript:void(0)' + id + '" onclick="deleteUser(' + id + ')"><img src="/images/icon_delete.svg"  width="24px" height="24px"></a>'
                            + '</div>';
                    }
                }
            ]
        });
    });

    $('#newUser').click(function () {
        $('#createUserModal').modal('show');
        $('#userFormCreate').find('img').attr('src', '');
        $('#userFormCreate').find(':radio[name="gender"][value="0"]').prop('checked', false);
        $('#userFormCreate').find(':radio[name="gender"][value="1"]').prop('checked', false);
        $('#userFormCreate').find('input[type=text], input[type=password], input[type=number], input[type=email], input[type=file], input[type=date], input[type=radio] textarea').val('');
    });

    $(document).ready(function () {
        $('#userFormCreate').on('submit', function (event) {
            $("#userFormCreate").validate({
                rules: {
                    name: "required",
                    email: "required",
                    password: "required",
                    // confirm_password: "required",
                    date_of_birth: "required",
                    gender: "required",
                    address: "required",
                },
                messages: {
                    name: "Name is empty!",
                    email: "Email is empty!",
                    password: "Password is empty!",
                    // confirm_password: "Confirm password is empty!",
                    date_of_birth: "Name is empty!",
                    gender: "Gender is empty!",
                    address: "Address is empty!"
                }
            });
            if (!$(this).valid()) return false;
            event.preventDefault();

            $('#createUserModal').modal('hide');
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
                                data['user']['gender'],
                                data['user']['date_of_birth'],
                                data['user']['address'],
                                function (id) {
                                    return '<div class="text-center">'
                                        + '<a href="javascript:void(0)" onclick= "editUser(' + id + ')"><img src="/images/icon_edit.svg"  width="24px" height="24px"></a>'
                                        + '<span>  </span>' + '<a href="javascript:void(0)" onclick="deleteUser(' + id + ')"><img src="/images/icon_delete.svg"  width="24px" height="24px"></a>'
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
                    date_of_birth: "required",
                    gender: "required",
                    address: "required",
                },
                messages: {
                    name: "Please fill name",
                    email: "Please fill email",
                    password: "Please fill password",
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
                                        data['user']['gender'],
                                        data['user']['date_of_birth'],
                                        data['user']['address'],
                                        function (id) {
                                            return '<div class="text-center">'
                                                + '<a href="javascript:void(0)" onclick= "editUser(' + id + ')"><img src="/images/icon_edit.svg"  width="24px" height="24px"></a>'
                                                + '<span>  </span>' + '<a href="javascript:void(0)" onclick="deleteUser(' + id + ')"><img src="/images/icon_delete.svg"  width="24px" height="24px"></a>'
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
            url: '/admin/user/' + id,
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

    function readAvatarCreate(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#showGetAvatar')
                    .attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readAvatarEdit(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#showEditAvatar')
                    .attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
