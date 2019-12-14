<!-- temp content -->
<div id="page_content_ajax" class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel" style="border: 1px solid #545779;">
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
                <div class="x_panel" style="border: 1px solid #545779;">
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
    @include('modal.english.roles.create')
    @include('modal.english.permissions.create')
    @include('modal.english.roles.edit')
    @include('modal.english.permissions.edit')
</div>
<!-- /temp content -->
<script>

    $(document).ready(function () {
        $("input[type='radio']").click(function () {

            if ($('#userAdjustName').val().length === 0) {
                swal("", "Please choose the user to give permission to", "error");
            } else {
                var radioValue = $("input[name='optionPermission']:checked").val();
                if (radioValue) {
                    $.ajax({
                        url: '/admin/user/permission/get/option/' + $('#userAdjustID').val() + '/' + radioValue,
                        dataType: 'json',
                        type: "GET",
                        beforeSend: function () {
                            $('#cat_user_permissions')
                                .find('option')
                                .remove()
                                .end()
                                .append('<option value="blank"></option>')
                                .val('whatever');
                            $('#modal-loading').modal('show');
                        }
                    })
                        .done(function (data) {
                            $('#modal-loading').modal('hide');
                            var exists = false;
                            if (!exists) {
                                for ($i = 0; $i < data['permission'].length; $i++) {
                                    $("#cat_user_permissions").append("<option value='" + data['permission'][$i]['id'] + "'>" + data['permission'][$i]['name'] + "</option>");
                                }
                            }
                        });
                }
            }
        });
    });

    var timer;
    $("#userSearch").on("change paste keyup", function () {
        if (this.value.length > 0) {
            if (timer) {
                clearTimeout(timer);
            }
            timer = setTimeout(function () {
                var formData = new FormData();
                formData.append('search_key', $("#userSearch").val());
                $.ajax({
                    url: '/admin/search/user',
                    method: "POST",
                    dataType: 'json',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                    }
                })
                    .done(function (data) {
                        $('.search_filters_ajax_user').replaceWith(data['html']);
                        if (data['n'] > 0) {
                            $('.search-filters-user').slideToggle();
                            $(document).ready(function () {
                                $(".delegatedUser").delegate(".user_click", "click", function () {
                                    $('#userAdjustName').val($(this).text());
                                    $('#userAdjustID').val($(this).text());
                                    $('#userAdjustName').focus();

                                    // Call api to get all permission that assigned to this user
                                    $.ajax({
                                        url: '/admin/user/permission/get/default/' + $('#userAdjustID').val(),
                                        dataType: 'json',
                                        type: "GET",
                                        beforeSend: function () {
                                            $('#cat_user_permissions')
                                                .find('option')
                                                .remove()
                                                .end()
                                                .append('<option value="blank"></option>')
                                                .val('whatever');
                                            $('#modal-loading').modal('show');
                                        }
                                    })
                                        .done(function (data) {
                                            $('#modal-loading').modal('hide');
                                            var exists = false;
                                            if (!exists) {
                                                for ($i = 0; $i < data['permission'].length; $i++) {
                                                    $("#cat_user_permissions").append("<option value='" + data['permission'][$i]['id'] + "'>" + data['permission'][$i]['name'] + "</option>");
                                                }
                                            }
                                            $(".radio_default").prop("checked", true);
                                        });

                                    // Call api to get all roles that assigned to this user
                                    $.ajax({
                                        url: '/admin/user/role/get/default/' + $('#userAdjustID').val(),
                                        dataType: 'json',
                                        type: "GET",
                                        beforeSend: function () {
                                            $('#cat_user_roles')
                                                .find('option')
                                                .remove()
                                                .end()
                                                .append('<option value="blank"></option>')
                                                .val('whatever');
                                            $('#modal-loading').modal('show');
                                        }
                                    })
                                        .done(function (data) {
                                            $('#modal-loading').modal('hide');
                                            var exists = false;
                                            if (!exists) {
                                                for ($i = 0; $i < data['roles'].length; $i++) {
                                                    $("#cat_user_roles").append("<option value='" + data['roles'][$i] + "'>" + data['roles'][$i] + "</option>");
                                                }
                                            }
                                        });
                                });
                            });
                        }
                    });
            }, 400);
        } else {
            $("div.search_filters_ajax_user").replaceWith('<div class="search_filters_ajax_user search-filters-user"></div>');
        }
    });

    var timer1;
    $("#roleSearch").on("change paste keyup", function () {
        if (this.value.length > 0) {
            if (timer1) {
                clearTimeout(timer1);
            }
            timer1 = setTimeout(function () {
                var formData = new FormData();
                formData.append('search_key', $("#roleSearch").val());
                $.ajax({
                    url: '/admin/search/role',
                    method: "POST",
                    dataType: 'json',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                    }
                })
                    .done(function (data) {
                        $('.search_filters_ajax_role').replaceWith(data['html']);
                        if (data['n'] > 0) {
                            $('.search-filters-role').slideToggle();
                            $(".delegatedRole").delegate(".role_click", "click", function () {
                                var formData = new FormData();
                                formData.append('name', $(this).text());
                                $.ajax({
                                    url: '/admin/search/role/table',
                                    method: "POST",
                                    dataType: 'json',
                                    data: formData,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function () {
                                    }
                                })
                                    .done(function (data) {
                                        $('.search_filters_ajax_role').replaceWith(data['html']);
                                        if (data['n'] > 0) {
                                            $('.search-filters-role').slideToggle();
                                        }
                                    });
                            });
                        }
                    });
            }, 400);
        } else {
            $("div.search_filters_ajax_role").replaceWith('<div class="search_filters_ajax_role search-filters-role"></div>');
        }
    });

    var timer2;
    $("#permissionSearch").on("change paste keyup", function () {
        if (this.value.length > 0) {
            if (timer2) {
                clearTimeout(timer2);
            }
            timer2 = setTimeout(function () {
                var formData = new FormData();
                formData.append('search_key', $("#permissionSearch").val());
                $.ajax({
                    url: '/admin/search/permission',
                    method: "POST",
                    dataType: 'json',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                    }
                })
                    .done(function (data) {
                        $('.search_filters_ajax_permission').replaceWith(data['html']);
                        if (data['n'] > 0) {
                            $('.search-filters-permission').slideToggle();
                            $(document).ready(function () {
                                $(".delegatedPermission").delegate(".permission_click", "click", function () {
                                    var formData = new FormData();
                                    formData.append('name', $(this).text());
                                    $.ajax({
                                        url: '/admin/search/permission/table',
                                        method: "POST",
                                        dataType: 'json',
                                        data: formData,
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        beforeSend: function () {
                                        }
                                    })
                                        .done(function (data) {
                                            $('.search_filters_ajax_permission').replaceWith(data['html']);
                                            if (data['n'] > 0) {
                                                $('.search-filters-permission').slideToggle();
                                            }
                                        });
                                });
                            });
                        }
                    });
            }, 400);
        } else {
            $("div.search_filters_ajax_permission").replaceWith('<div class="search_filters_ajax_permission search-filters-permission"></div>');
        }
    });

    (function ($) {
        function floatLabel(inputType) {
            $(inputType).each(function () {
                var $this = $(this);
                // on focus add cladd active to label
                $this.focus(function () {
                    $this.next().addClass("active");
                });
                //on blur check field and remove class if needed
                $this.blur(function () {
                    if ($this.val() === '' || $this.val() === 'blank') {
                        $this.next().removeClass();
                    }
                });
            });
        }

        // just add a class of "floatLabel to the input field!"
        floatLabel(".floatLabel");
    })(jQuery);

    $(document).ready(function () {
        $('#mroleTable').dataTable({
            "pageLength": 5,
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, 'All']],
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: '/admin/role/loading',
                type: 'GET'
            },

            "columns": [
                {"data": "name"},
                {"data": "guard_name"},
                {
                    "data": "manipulation", "render": function (id) {
                    return '<div class="text-center"><a onclick= "adjustRole(' + id + ')"><img src="/images/icon-control/icon_role.svg"  width="24px" height="24px" alt="Update Icon"></a>'
                        + '<span>  </span>' + '<a onclick= "assignRoleToUser(' + id + ')"><img src="/images/icon-control/icon_user.svg"  width="24px" height="24px" alt="Update Icon"></a>'
                        + '<span>  </span>' + '<a onclick= "editRole(' + id + ')"><img src="/images/icon-control/icon_edit.svg"  width="24px" height="24px" alt="Update Icon"></a>'
                        + '<span>  </span>' + '<a href="/admin/millionaire/delete/' + id + '" onclick="deleteRole(' + id + ')"><img src="/images/icon-control/icon_delete.svg"  width="24px" height="24px" alt="Update Icon"></a></div>';
                }
                }
            ]
        });

    });

    $(document).ready(function () {
        $('#mpermissionTable').dataTable({
            "pageLength": 5,
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, 'All']],
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: '/admin/permission/loading',
                type: 'GET'
            },

            "columns": [
                {"data": "name"},
                {"data": "guard_name"},
                {
                    "data": "manipulation", "render": function (id) {
                    return '<div class="text-center"><a onclick= "adjustPermission(' + id + ')"><img src="/images/icon-control/icon_permission.svg"  width="24px" height="24px" alt="Update Icon"></a>'
                        + '<span>  </span>' + '<a onclick= "assignPermissionToUser(' + id + ')"><img src="/images/icon-control/icon_user.svg"  width="24px" height="24px" alt="Update Icon"></a>'
                        + '<span>  </span>' + '<a onclick= "editPermission(' + id + ')"><img src="/images/icon-control/icon_edit.svg"  width="24px" height="24px" alt="Update Icon"></a>'
                        + '<span>  </span>' + '<a href="/admin/millionaire/delete/' + id + '" onclick="deletePermission(' + id + ')"><img src="/images/icon-control/icon_delete.svg"  width="24px" height="24px" alt="Update Icon"></a></div>';
                }
                }
            ]
        });

    });

    $('#btnNewRole').click(function () {
        $('#roleModalCreate').modal('show');
        $('#roleFormCreate').find('input[type=text], input[type=password], input[type=number], input[type=email], textarea').val('');
    });

    $('#btnNewPermission').click(function () {
        $('#permissionModalCreate').modal('show');
        $('#permissionFormCreate').find('input[type=text], input[type=password], input[type=number], input[type=email], textarea').val('');
    });

    $('#roleFormCreate').validate({
        rules: {
            rolename: "required"
        },
        messages: {
            rolename: "Do not leave the Role name blank!"
        }
    });

    $('#permissionFormCreate').validate({
        rules: {
            permissionname: "required"
        },
        messages: {
            permissionname: "Do not leave the permission name blank!"
        }
    });

    function adjustPermission(id) {
        if ($('#roleAdjustName').val().length === 0) {
            swal("", "Please choose the role to give permission to", "error");
        } else {
            $.ajax({
                url: '/admin/permission/adjust/' + id + "/" + $('#roleAdjustID').val(),
                dataType: 'json',
                type: "GET",
                beforeSend: function () {
                    $('#modal-loading').modal('show');
                }
            })
                .done(function (data) {
                    $('#modal-loading').modal('hide');


                    var exists = false;
                    $('#cat_permissions  option').each(function () {
                        if (this.value == data['permission']['id']) {
                            exists = true;
                        }
                    });

                    if (!exists) {
                        swal("", "Assign permission to the role successfully", "success");
                        $("#cat_permissions").append("<option value='" + data['permission']['id'] + "'>" + data['permission']['name'] + "</option>");
                    }
                });
        }
    }

    function assignRoleToUser(id) {
        if ($('#userAdjustName').val().length === 0) {
            swal("", "Please choose the user to assign role to", "error");
        } else {
            $.ajax({
                url: '/admin/user/role/adjust/' + id + "/" + $('#userAdjustID').val(),
                dataType: 'json',
                type: "GET",
                beforeSend: function () {
                    $('#cat_user_roles')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="blank"></option>')
                        .val('whatever');
                    $('#modal-loading').modal('show');
                }
            })
                .done(function (data) {
                    $('#modal-loading').modal('hide');

                    var exists = false;
                    if (!exists) {
                        swal("", "Assign role to the user successfully", "success");
                        for ($i = 0; $i < data['roles'].length; $i++) {
                            $("#cat_user_roles").append("<option value='" + data['roles'][$i] + "'>" + data['roles'][$i] + "</option>");
                        }
                    }
                });
        }
    }

    function assignPermissionToUser(id) {
        if ($('#userAdjustName').val().length === 0) {
            swal("", "Please choose the user to give permission to", "error");
        } else {
            $.ajax({
                url: '/admin/user/permission/adjust/' + id + "/" + $('#userAdjustID').val(),
                dataType: 'json',
                type: "GET",
                beforeSend: function () {
                    $('#cat_user_permissions')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="blank"></option>')
                        .val('whatever');
                    $('#modal-loading').modal('show');
                }
            })
                .done(function (data) {
                    $('#modal-loading').modal('hide');
                    var exists = false;
                    if (!exists) {
                        swal("", "Assign permission to the user successfully", "success");
                        for ($i = 0; $i < data['permission'].length; $i++) {
                            $("#cat_user_permissions").append("<option value='" + data['permission'][$i]['id'] + "'>" + data['permission'][$i]['name'] + "</option>");
                        }
                    }
                });
        }
    }

    function adjustRole(id) {
        $.ajax({
            url: '/admin/role/adjust/' + id,
            dataType: 'json',
            type: "GET",
            beforeSend: function () {

                $('#cat_permissions')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="blank"></option>')
                    .val('whatever');

                $('#modal-loading').modal('show');
            }
        })
            .done(function (data) {
                for ($i = 0; $i < data['permission'].length; $i++) {
                    $("#cat_permissions").append("<option value='" + data['permission'][$i]['id'] + "'>" + data['permission'][$i]['name'] + "</option>");
                }

                $('#roleAdjustID').val(data['role']['id']);
                $('#roleAdjustName').val(data['role']['name']);
                $('#roleAdjustName').focus();
                $('#modal-loading').modal('hide');
            });
    }

    $('#cat_permissions').on('change', function (event) {
        event.preventDefault();
        var valueSelected = this.value;
        swal({
                title: "",
                text: "Do you want to remove the permission from the role?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel",
                closeOnConfirm: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '/admin/permission/revoke/' + valueSelected + "/" + $('#roleAdjustID').val(),
                        dataType: 'json',
                        type: "GET",
                        beforeSend: function () {
                        }
                    })
                        .done(function (data) {
                            $("#cat_permissions option[value='" + data['permission']['id'] + "']").remove();
                        })
                        .fail(function (error) {
                            console.log(error);
                        });
                }
            });
    });

    $('#cat_user_roles').on('change', function (event) {
        event.preventDefault();
        var valueSelected = this.value;
        swal({
                title: "",
                text: "Do you want to remove the role from the user?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel",
                closeOnConfirm: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '/admin/user/role/revoke/' + valueSelected + "/" + $('#userAdjustID').val(),
                        dataType: 'json',
                        type: "GET",
                        beforeSend: function () {
                            $('#cat_user_roles')
                                .find('option')
                                .remove()
                                .end()
                                .append('<option value="blank"></option>')
                                .val('whatever');
                        }
                    })
                        .done(function (data) {
                            var exists = false;
                            if (!exists && data['roles'].length != 0) {
                                for ($i = 0; $i < data['roles'].length; $i++) {
                                    $("#cat_user_roles").append("<option value='" + data['roles'][$i] + "'>" + data['roles'][$i] + "</option>");
                                }
                            }
                        })
                        .fail(function (error) {
                            console.log(error);
                        });
                }
            });
    });

    $('#cat_user_permissions').on('change', function (event) {
        event.preventDefault();
        var valueSelected = this.value;
        swal({
                title: "",
                text: "Do you want to remove the permission from the user?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel",
                closeOnConfirm: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '/admin/user/permission/revoke/' + valueSelected + "/" + $('#userAdjustID').val(),
                        dataType: 'json',
                        type: "GET",
                        beforeSend: function () {
                            $('#cat_user_permissions')
                                .find('option')
                                .remove()
                                .end()
                                .append('<option value="blank"></option>')
                                .val('whatever');
                        }
                    })
                        .done(function (data) {
                            var exists = false;
                            if (!exists && data['permissions'].length != 0) {
                                for ($i = 0; $i < data['permissions'].length; $i++) {
                                    $("#cat_user_permissions").append("<option value='" + data['permissions'][$i]['id'] + "'>" + data['permissions'][$i]['name'] + "</option>");
                                }
                            }
                        })
                        .fail(function (error) {
                            console.log(error);
                        });
                }
            });
    });

    function editRole(id) {
        $.ajax({
            url: '/admin/role/detail/' + id,
            dataType: 'json',
            type: "GET",
            beforeSend: function () {
                $('#modal-loading').modal('show');
                $('#roleID').val(id);
            }
        })
            .done(function (role) {
                $('#_rolename').val(role['role']['name']);
                $('#modal-loading').modal('hide');
                $('#roleModalEdit').modal('show');
            });
    }

    function editPermission(id) {
        $.ajax({
            url: '/admin/permission/detail/' + id,
            dataType: 'json',
            type: "GET",
            beforeSend: function () {
                $('#modal-loading').modal('show');
                $('#permissionID').val(id);
            }
        })
            .done(function (permission) {
                $('#_permissionname').val(permission['permission']['name']);
                $('#modal-loading').modal('hide');
                $('#permissionModalEdit').modal('show');
            });
    }

    $(document).ready(function () {
        $('#roleFormCreate').on('submit', function (event) {
            if (!$(this).valid()) return false;
            event.preventDefault();
            $('#roleModalCreate').modal('hide');
            var formData = new FormData(this);
            $.ajax({
                url: '/admin/role/store',
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
                    if (data['message']['status'] == 'invalid') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] == 'existed') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] == 'success') {
                        swal("", data['message']['description'], "success");
                        var table = $('#mroleTable').DataTable();
                        $.fn.dataTable.ext.errMode = 'none';
                        table.row.add(
                            [
                                data['role']['name'],
                                data['role']['guard_name'],
                                function (id) {
                                    return '<div class="text-center"><a onclick= "editRole(' + id + ')"><img src="/img/icon-control/icon_edit.svg"  width="24px" height="24px" alt="Update Icon"></a>'
                                        + '<span>  </span>' + '<a href="/admin/millionaire/delete/' + id + '" onclick="deleteRole(' + id + ')"><img src="/img/icon-control/icon_delete.svg"  width="24px" height="24px" alt="Update Icon"></a></div>'
                                }
                            ]
                        ).draw();
                    } else if (data.status == 'error') {
                        swal("", data['message']['description'], "error");
                    }
                })
                .fail(function (error) {
                    console.log(error);
                });
        });

        $('#permissionFormCreate').on('submit', function (event) {
            if (!$(this).valid()) return false;
            event.preventDefault();
            $('#permissionModalCreate').modal('hide');
            var formData = new FormData(this);
            $.ajax({
                url: '/admin/permission/store',
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
                    if (data['message']['status'] == 'invalid') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] == 'existed') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] == 'success') {
                        swal("", data['message']['description'], "success");
                        var table = $('#mpermissionTable').DataTable();
                        $.fn.dataTable.ext.errMode = 'none';
                        table.row.add(
                            [
                                data['permission']['name'],
                                data['permission']['guard_name'],
                                function (id) {
                                    return '<div class="text-center"><a onclick= "editPermission(' + id + ')"><img src="/img/icon-control/icon_edit.svg"  width="24px" height="24px" alt="Update Icon"></a>'
                                        + '<span>  </span>' + '<a href="/admin/millionaire/delete/' + id + '" onclick="deletePermission(' + id + ')"><img src="/img/icon-control/icon_delete.svg"  width="24px" height="24px" alt="Update Icon"></a></div>'
                                }
                            ]
                        ).draw();
                    } else if (data.status == 'error') {
                        swal("", data['message']['description'], "error");
                    }
                })
                .fail(function (error) {
                    console.log(error);
                });
        });

        $('#roleFormEdit').on('submit', function (event) {
            if (!$(this).valid()) return false;
            event.preventDefault();
            $('#roleModalEdit').modal('hide');
            var formData = new FormData(this);
            $.ajax({
                url: '/admin/role/update',
                method: "POST",
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
                .done(function (data) {
                    if (data['message']['status'] == 'invalid') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] == 'existed') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] == 'success') {
                        swal("", data['message']['description'], "success");
                        var table = $('#mroleTable').DataTable();
                        $.fn.dataTable.ext.errMode = 'none';
                        var rows = table.rows().data();
                        for (var i = 0; i < rows.length; i++) {
                            if (rows[i]['id'] == data['role']['id']) {
                                table.row(this).data(
                                    [
                                        data['role']['name'],
                                        data['role']['guard_name'],
                                        function (id) {
                                            return '<div class="text-center"><a onclick= "editRole(' + id + ')"><img src="/img/icon-control/icon_edit.svg"  width="24px" height="24px" alt="Update Icon"></a>'
                                                + '<span>  </span>' + '<a href="/admin/millionaire/delete/' + id + '" onclick="deleteRole(' + id + ')"><img src="/img/icon-control/icon_delete.svg"  width="24px" height="24px" alt="Update Icon"></a></div>'
                                        }
                                    ]
                                ).draw();
                            }
                        }
                    } else if (data.status == 'error') {
                        swal("", data['message']['description'], "error");
                    }
                })
                .fail(function (error) {
                    console.log(error);
                });
        });

        $('#permissionFormEdit').on('submit', function (event) {
            if (!$(this).valid()) return false;
            event.preventDefault();
            $('#permissionModalEdit').modal('hide');
            var formData = new FormData(this);
            $.ajax({
                url: '/admin/permission/update',
                method: "POST",
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
                .done(function (data) {
                    if (data['message']['status'] == 'invalid') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] == 'existed') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] == 'success') {
                        swal("", data['message']['description'], "success");
                        var table = $('#mpermissionTable').DataTable();
                        $.fn.dataTable.ext.errMode = 'none';
                        var rows = table.rows().data();
                        for (var i = 0; i < rows.length; i++) {
                            if (rows[i]['id'] == data['permission']['id']) {
                                table.row(this).data(
                                    [
                                        data['permission']['name'],
                                        data['permission']['guard_name'],
                                        function (id) {
                                            return '<div class="text-center"><a onclick= "editPermission(' + id + ')"><img src="/img/icon-control/icon_edit.svg"  width="24px" height="24px" alt="Update Icon"></a>'
                                                + '<span>  </span>' + '<a href="/admin/millionaire/delete/' + id + '" onclick="deletePermission(' + id + ')"><img src="/img/icon-control/icon_delete.svg"  width="24px" height="24px" alt="Update Icon"></a></div>'
                                        }
                                    ]
                                ).draw();
                            }
                        }
                    } else if (data.status == 'error') {
                        swal("", data['message']['description'], "error");
                    }
                })
                .fail(function (error) {
                    console.log(error);
                });
        });
    });

    function deleteRole(id) {
        event.preventDefault();
        swal({
                title: "",
                text: "Do you want to delete the role?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel",
                closeOnConfirm: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '/admin/role/delete/' + id,
                        dataType: 'json',
                        type: "GET",
                        beforeSend: function () {
                        }
                    })
                        .done(function (data) {
                            if (data['message']['status'] == 'success') {
                                swal("", data['message']['description'], "success");
                                var table = $('#mroleTable').DataTable();
                                $.fn.dataTable.ext.errMode = 'none';
                                var rows = table.rows().data();
                                for (var i = 0; i < rows.length; i++) {
                                    if (rows[i].id == data['role']['id']) {
                                        table.row(this).remove().draw();
                                    }
                                }
                            }
                            if (data['message']['status'] == 'error') {
                                swal("", data['message']['description'], "error");
                            }
                        })
                        .fail(function (error) {
                            console.log(error);
                        });
                }
            });
    }

    function deletePermission(id) {
        event.preventDefault();
        swal({
                title: "",
                text: "Do you want to delete the permission?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel",
                closeOnConfirm: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '/admin/permission/delete/' + id,
                        dataType: 'json',
                        type: "GET",
                        beforeSend: function () {
                        }
                    })
                        .done(function (data) {
                            if (data['message']['status'] == 'success') {
                                swal("", data['message']['description'], "success");
                                var table = $('#mpermissionTable').DataTable();
                                $.fn.dataTable.ext.errMode = 'none';
                                var rows = table.rows().data();
                                for (var i = 0; i < rows.length; i++) {
                                    if (rows[i].id == data['permission']['id']) {
                                        table.row(this).remove().draw();
                                    }
                                }
                            }
                            if (data['message']['status'] == 'error') {
                                swal("", data['message']['description'], "error");
                            }
                        })
                        .fail(function (error) {
                            console.log(error);
                        });
                }
            });
    }

    (function ($) {
        function floatLabel(inputType) {
            $(inputType).each(function () {
                var $this = $(this);
                // on focus add cladd active to label
                $this.focus(function () {
                    $this.next().addClass("active");
                });
                //on blur check field and remove class if needed
                $this.blur(function () {
                    if ($this.val() === '' || $this.val() === 'blank') {
                        $this.next().removeClass();
                    }
                });
            });
        }

        // just add a class of "floatLabel to the input field!"
        floatLabel(".floatLabel");
    })(jQuery);

</script>
