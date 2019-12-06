<?php
/**
 * Created by PhpStorm.
 * User: vuongluis
 * Date: 4/7/2018
 * Time: 11:11 AM
 */
?>
<div id="page_content_ajax" class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <button id="newCategory" class="btn btn-default" type="button">New Category</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatablesCategory" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 5.00%">ID</th>
                                <th style="width: 25.00%">Name</th>
                                <th style="width: 53.00%">Description</th>
                                <th style="width: 7.00%">List Books</th>
                                <th style="width: 10.00%; text-align: center">Manipulation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
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
@include('modal.category.create')
@include('modal.category.edit')

<script>
    $(document).ready(function () {
        $('#datatablesCategory').dataTable({
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
                url: '/admin/category',
                type: 'GET'
            },

            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "description"},
                {
                    "data": "list_books", "render": function (id) {
                        return '<div class="text-center">'
                            + '<a href="javascript:void(0)" onclick= "showBooks(' + id + ')"><img src="/images/icon_books.png"  width="18px" height="18px"></a>'
                            + '</div>';
                    }
                },
                {
                    "data": "manipulation", "render": function (id) {
                        return '<div class="text-center">'
                            + '<a href="javascript:void(0)" onclick= "editCategory(' + id + ')"><img src="/images/icon_edit.png"  width="18px" height="18px"></a>'
                            + '<span>  </span>' + '<a href="javascript:void(0)"  onclick="deleteCategory(' + id + ')"><img src="/images/icon_delete.png"  width="18px" height="18px"></a>'
                            + '</div>';
                    }
                }
            ]
        });
    });

    $('#newCategory').click(function () {
        $('#createCategoryModal').modal('show');
        $('#categoryFormCreate').find('input[type=text], input[type=password], input[type=number], input[type=email], textarea').val('');
    });

    /**
     * After show form Edit.
     * We need jump into EditForm and fill in data in EditForm, right?
     * YEs
     * @param id
     */
    $(document).ready(function () {
        $('#categoryFormCreate').on('submit', function (event) {
            $("#categoryFormCreate").validate({
                rules: {
                    name: "required",
                    description: "required"
                },
                messages: {
                    name: "Please fill name",
                    description: "Please fill description"
                }
            });
            if (!$(this).valid()) return false;
            event.preventDefault();

            $('#createCategoryModal').modal('hide');
            var formData = new FormData(this);
            $.ajax({
                url: '/admin/category',
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
                        var table = $('#datatablesCategory').DataTable();
                        $.fn.dataTable.ext.errMode = 'none';
                        table.row.add(
                            [
                                data['category']['name'],
                                data['category']['description'],
                                function (id) {
                                    return '<div class="text-center">'
                                        + '<a href="javascript:void(0)" onclick= "editCategory(' + id + ')"><img src="/images/icon_edit.png"  width="18px" height="18px"></a>'
                                        + '<span>  </span>' + '<a href="javascript:void(0)" onclick="deleteCategory(' + id + ')"><img src="/images/icon_delete.png"  width="18px" height="18px"></a>'
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

        /**
         * After edit, we need get all information from Form.
         * When you click Submit and Ajax will do this manipulation.
         */
        $('#categoryFormEdit').on('submit', function (event) {
            $("#categoryFormEdit").validate({
                rules: {
                    name: "required",
                    description: "required"
                },
                messages: {
                    name: "Please fill name",
                    description: "Please fill description"
                }
            });
            if (!$(this).valid()) return false;
            event.preventDefault();

            $('#editCategoryModal').modal('hide');
            var formData = new FormData(this);
            $.ajax({
                url: '/admin/category/' + $('#editId').val(),
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
                        var table = $('#datatablesCategory').DataTable();
                        $.fn.dataTable.ext.errMode = 'none';
                        var rows = table.rows().data();
                        for (var i = 0; i < rows.length; i++) {
                            if (rows[i].id == data['category']['id']) {
                                table.row(this).data(
                                    [
                                        data['category']['name'],
                                        data['category']['description'],
                                        function (id) {
                                            return '<div class="text-center">'
                                                + '<a href="javascript:void(0)" onclick= "editCategory(' + id + ')"><img src="/images/icon_edit.png"  width="18px" height="18px"></a>'
                                                + '<span>  </span>' + '<a href="javascript:void(0)" onclick="deleteCategory(' + id + ')"><img src="/images/icon_delete.png"  width="18px" height="18px"></a>'
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

    function editCategory(id) {
        $.ajax({
            url: '/admin/category/' + id,
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
                $('#editName').val(data['category']['name']);
                $('#editDescription').val(data['category']['description']);
                $('#editId').val(data['category']['id']);
                $('#modal-loading').modal('hide');
                $('#editCategoryModal').modal('show');
            })
            .fail(function (error) {
                console.log(error);
            });
    }

    function deleteCategory(id) {
        $.ajax({
            url: '/admin/category/' + id,
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
                    var table = $('#datatablesCategory').DataTable();
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
            });
    }

    function showBooks(id) {
        localStorage.setItem("category_id", id);
        $.ajax({
            url: 'admin/ajax/books',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            data: {id: id},
            type: 'POST',
            beforeSend: function () {
                $('#modal-loading').modal('show');
            }
        })
            .done(function (data) {
                console.log(data['html']);
                $('#modal-loading').modal('hide');
                $('#page_content_ajax').replaceWith(data['html']);
            });
    }
</script>
