<div id="page_content_ajax" class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <button id="newUser" class="btn btn-default" type="button">New Staff</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatablesUser" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 5.00%">ID</th>
                                <th style="width: 15.00%">Name</th>
                                <th style="width: 15.00%">Email</th>
                                <th style="width: 5.00%">Avatar</th>
                                <th style="width: 10.00%">Phone Number</th>
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
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title custom_x_title">
                        <div class="pull-left">
                            <input id="btnNewRole" class="form-control" type="button" value="New Role">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="overflow-x:auto">
                        <table id="mroleTable" class="table">
                            <thead>
                            <tr>
                                <th class="text-left" style="width: 50.00%">Name</th>
                                <th class="text-left" style="width: 10.00%">Scope</th>
                                <th class="text-center" style="width: 40.00%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-left"></td>
                                <td class="text-left"></td>
                                <td class="text-center"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                    <div class="x_title custom_x_title">
                        <div class="pull-left">
                            <input id="btnNewPermission" class="form-control" type="button" value="New Permission">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="overflow-x:auto">
                        <table id="mpermissionTable" class="table">
                            <thead>
                            <tr>
                                <th class="text-left" style="width: 50.00%">Name</th>
                                <th class="text-left" style="width: 10.00%">Scope</th>
                                <th class="text-center" style="width: 40.00%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="text-left"></td>
                                <td class="text-left"></td>
                                <td class="text-center"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <form id="formSentence" class="outerAndroidPost">
                    <div class="form-group padding-content-20">
                        <h2 class="heading">ADD PERMISSION TO ROLE</h2>
                        <div class="controls">
                            <input type="text" id="roleAdjustName" class="floatLabel" name="roleAdjustName">
                            <label for="roleAdjustName">Role</label>
                            <input type="hidden" name="roleAdjustID" id="roleAdjustID">
                        </div>
                        <div class="controls">
                            <i class="fa fa-sort"></i>
                            <select class="floatLabel" id="cat_permissions">
                                <option value="blank"></option>
                            </select>
                            <label for="cat_permissions">Permissions</label>
                        </div>
                    </div>

                    <div class="form-group padding-content-20">
                        <h2 class="heading">ADD PERMISSION TO USER</h2>
                        <div class="controls">
                            <input type="text" id="userAdjustName" class="floatLabel" name="userAdjustName">
                            <label for="userAdjustName">Current User ID</label>
                            <input type="hidden" name="userAdjustID" id="userAdjustID">
                        </div>
                        <div class="controls" style="margin-bottom: 18px;">
                            <span class="radiobtn"><input class="radio_default" type='radio' name='optionPermission'
                                                          value='Default'/>Default</span>
                            <span class="radiobtn"><input class="radio_direct" type='radio' name='optionPermission'
                                                          value='Direct'/>Direct</span>
                            <span class="radiobtn"><input class="radio_via" type='radio' name='optionPermission'
                                                          value='ViaRoles'/>Via Roles</span>
                            <span class="radiobtn"><input class="radio_all" type='radio' name='optionPermission'
                                                          value='All'/>All</span>
                        </div>
                        <div class="controls">
                            <i class="fa fa-sort"></i>
                            <select class="floatLabel" id="cat_user_roles">
                                <option value="blank"></option>
                            </select>
                            <label for="cat_user_roles">Roles</label>
                        </div>
                        <div class="controls">
                            <i class="fa fa-sort"></i>
                            <select class="floatLabel" id="cat_user_permissions">
                                <option value="blank"></option>
                            </select>
                            <label for="cat_user_permissions">Permissions</label>
                        </div>
                        <div class="controls search-box">
                            <input type="text" class="search-input floatLabel" id="userSearch" name="userSearch"/>
                            <label for="userSearch">Search users</label>
                            <div class="search_filters_ajax_user search-filters-user delegatedUser"></div>
                        </div>
                    </div>

                    <div class="form-group padding-content-20">
                        <h2 class="heading">QUERY USERS FROM ROLE</h2>
                        <div class="controls search-box">
                            <input type="text" class="search-input floatLabel" id="roleSearch" name="roleSearch"/>
                            <label for="roleSearch">Search roles</label>
                            <div class="search_filters_ajax_role search-filters-role delegatedRole"></div>
                        </div>
                    </div>

                    <div class="form-group padding-content-20">
                        <h2 class="heading">QUERY USERS FROM PERMISSION</h2>
                        <div class="controls search-box">
                            <input type="text" class="search-input floatLabel" id="permissionSearch" name="permissionSearch"/>
                            <label for="permissionSearch">Search permissions</label>
                            <div class="search_filters_ajax_permission search-filters-permission delegatedPermission"></div>
                        </div>
                    </div>
                </form>
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
                        return '<img src="' + avatar + '" width="36px;" height="36px;" alt="avatar"/>';
                    }
                },
                {"data": "phone_number"},
                {
                    "data": "gender", "render": function (gender) {
                        if (gender == 1)
                            return '<div class="text-center">'
                                + '<img src="/images/icon_gender_female.png"  width="18px" height="18px">'
                                +'</div>';
                    else
                        return '<div class="text-center">'
                            + '<img src="/images/icon_gender_male.png"  width="18px" height="18px">'
                            +'</div>';
                    }
                },

                {"data": "date_of_birth"},
                {"data": "address"},
                {
                    "data": "manipulation", "render": function (id) {
                        return '<div class="text-center">'
                            + '<a href="javascript:void(0)" onclick= "editUser(' + id + ')"><img src="/images/icon_edit.png"  width="18px" height="18px"></a>'
                            + '<span>  </span>' + '<a href="javascript:void(0)' + id + '" onclick="deleteUser(' + id + ')"><img src="/images/icon_delete.png"  width="18px" height="18px"></a>'
                            + '</div>';
                    }
                }
            ]
        });
    });

    $('#newUser').click(function () {
        $('#createUserModal').modal('show');
        $('#userFormCreate').find('img').attr('src', '/images/users/profile.png');
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
                    phone_number: "required",
                    date_of_birth: "required",
                    gender: "required",
                    address: "required",
                },
                messages: {
                    name: "Name is empty!",
                    email: "Email is empty!",
                    password: "Password is empty!",
                    // confirm_password: "Confirm password is empty!",
                    phone_number: "Phone number is empty!",
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
                    phone_number: "required",
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

</script>
