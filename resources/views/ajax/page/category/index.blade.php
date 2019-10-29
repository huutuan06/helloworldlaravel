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
                        <p class="text-muted font-13 m-b-30">
                            DataTables has most features enabled by default, so all you need to do to use it with your
                            own tables is to call the construction function: <code>$().DataTable();</code>
                        </p>
                        <table id="datatablesCategory" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 20.00%">ID</th>
                                <th style="width: 60.00%">Name</th>
                                <th style="width: 60.00%">Description</th>
                                <th style="width: 20.00%; text-align: center">Manipulation</th>
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
                    "data": "manipulation", "render": function (id) {
                        return '<div class="text-center">'
                            + '<a onclick= "editCategory(' + id + ')"><img src="/images/icon_edit.svg"  width="24px" height="24px"></a>'
                            + '<span>  </span>' + '<a href="javascript:void(0)"  onclick="deleteCategory(' + id + ')"><img src="/images/icon_delete.svg"  width="24px" height="24px"></a>'
                            + '</div>';
                    }
                }
            ]
        });
    });

    $('#newCategory').click(function () {
        $('#createCategoryModal').modal('show');
        $('#roleFormCreate').find('input[type=text], input[type=password], input[type=number], input[type=email], textarea').val('');
    });

    /**
     * After show form Edit.
     * We need jump into EditForm and fill in data in EditForm, right?
     * YEs
     * @param id
     */
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
                console.log(data['category']['id']);
                $('#modal-loading').modal('hide');
                $('#editCategoryModal').modal('show');
            })
            .fail(function (error) {
                console.log(error);
            });

    }


    $(document).ready(function () {
        $('#categoryFormCreate').on('submit', function (event) {
            $("#categoryFormCreate").validate({
                rules: {
                    name: "required",
                    description: "required"
                },
                messages: {
                    name: "Vui lòng nhập name",
                    description: "Vui lòng nhập description"
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
                                        + '<a onclick= "editCategory(' + id + ')"><img src="/images/icon_edit.svg"  width="24px" height="24px"></a>'
                                        + '<span>  </span>' + '<a href="javascript:void(0)" onclick="deleteCategory(' + id + ')"><img src="/images/icon_delete.svg"  width="24px" height="24px"></a>'
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
         * After edit, we need get all informations from Form.
         * When you click Submit and Ajax will do this manipulation.
         */
        $('#categoryFormEdit').on('submit', function (event) {
            console.log("We try to get id from form: "+$('#editId').val());
        //     $("#categoryFormEdit").validate({
        //         rules: {
        //             name: "required",
        //             description: "required"
        //         },
        //         messages: {
        //             name: "Please fill name",
        //             description: "Please fill description"
        //         }
        //     });
        //     if (!$(this).valid()) return false;
        //     event.preventDefault();
        //
        //     $('#editCategoryModal').modal('hide');
        //     var formData = new FormData(this);
        //
        //     $.ajax({
        //         url: '/admin/category/' + $('#editId').val(),
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         method: 'PUT',
        //         dataType: 'json',
        //         data: formData,
        //         processData: false,
        //         contentType: false
        //     })
        //         .done(function (data) {
        //             if (data['message']['status'] === 'invalid') {
        //                 swal("", data['message']['description'], "error");
        //             }
        //             if (data['message']['status'] === 'existed') {
        //                 swal("", data['message']['description'], "error");
        //             }
        //             if (data['message']['status'] === 'success') {
        //                 swal("", data['message']['description'], "success");
        //                 var table = $('#datatablesCategory').DataTable();
        //                 $.fn.dataTable.ext.errMode = 'none';
        //                 var rows = table.rows().data();
        //                 for (var i = 0; i < rows.length; i++) {
        //                     if (rows[i].id === data['id']) {
        //                         table.row(this).replaceWith(
        //                             [
        //                                 data['category']['name'],
        //                                 data['category']['description'],
        //                                 function (id) {
        //                                     return '<div class="text-center">'
        //                                         + '<a onclick= "editCategory(' + id + ')"><img src="/images/icon_edit.svg"  width="24px" height="24px"></a>'
        //                                         + '<span>  </span>' + '<a href="javascript:void(0)" onclick="deleteCategory(' + id + ')"><img src="/images/icon_delete.svg"  width="24px" height="24px"></a>'
        //                                         + '</div>';
        //                                 }
        //                             ]
        //                         )
        //                     }
        //                 }
        //             } else if (data.status === 'error') {
        //                 swal("", data['message']['description'], "error");
        //             }
        //         })
        //         .fail(function (error) {
        //             console.log(error);
        //         });
        // });
    });


    function deleteCategory(id) {
        console.log(id);
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
                console.log(data);
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


</script>
