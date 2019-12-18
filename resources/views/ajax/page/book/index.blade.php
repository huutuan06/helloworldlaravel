<?php
/**
 * Created by PhpStorm.
 * User: vuongluis
 * Date: 4/7/2018
 * Time: 11:11 AM
 */
?>
<div id="page_content_ajax" class="right_col" role="main">
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <button id="newBook" class="btn btn-default" type="button">New Book</button>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatableBook" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 5.00%">Id</th>
                            <th style="width: 15.00%">Title</th>
                            <th style="width: 10.00%">Image</th>
                            <th style="width: 10.00%">Category</th>
                            <th style="width: 25.00%">Description</th>
                            <th style="width: 5.00%">Pages</th>
                            <th style="width: 5.00%">Price</th>
                            <th style="width: 5.00%">Amount</th>
                            <th style="width: 10.00%">Author</th>
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
@include("modal.book.create")
@include("modal.book.edit")

<script>
    $(document).ready(function () {
        $('#datatableBook').dataTable({
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
                url: '/admin/book',
                type: 'GET'
            },

            "columns": [
                {"data": "id"},
                {"data": "title"},
                {
                    "data": "image", "render": function (image) {
                        return '<div class="text-center">'
                            + '<img src="' + image + '" alt="" height="100px">'
                            + '</div>';
                    }
                },
                {"data": "category"},
                {"data": "description"},
                {"data": "total_pages"},
                {"data": "price", "render": function (price) {
                        return '<div>$'+price+'</div>'
                    }},
                {"data": "amount"},
                {"data": "author"},
                {
                    "data": "manipulation", "render": function (id) {
                        return '<div class="text-center">'
                            + '<a href="javascript:void(0)" onclick = "navReview(' + id + ')"><img src="/images/icon_cms.png"  width="18px" height="18px"></a> '
                            + '<a href="javascript:void(0)" onclick= "editBook(' + id + ')"><img src="/images/icon_edit.png"  width="18px" height="18px"></a>'
                            + '<span>  </span>' + '<a href="javascript:void(0)"  onclick="deleteBook(' + id + ')"><img src="/images/icon_delete.png"  width="18px" height="18px"></a>'
                            + '</div>';
                    }
                }
            ]
        });
    });

    $('#newBook').click(function () {
        $('#createBookModal').modal('show');
        $('#bookFormCreate').find('img').attr('src', '');
        $('#bookFormCreate').find('input[type=text], input[type=password], input[type=number], input[type=email], input[type=file], textarea, select').val('');
        $.ajax({
            url: 'admin/vogo/book/categories/',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            type: "GET",
        })
            .done(function (data) {
                if (data['message']['status'] === 'success') {
                    for ($i = 0; $i < data['categories'].length; $i++) {
                        $('#bookCategory').append('<option value="' + data['categories'][$i]["id"] + '">' + data['categories'][$i]["name"] + '</option>')
                    }
                } else if (data.status === 'error') {
                    swal("", data['message']['description'], "error");
                }
            })
            .fail(function (error) {
                console.log(error);
            });
    });

    $(document).ready(function () {
        $('#bookFormCreate').on('submit', function (event) {
            $("#bookFormCreate").validate({
                rules: {
                    title: "required",
                    image: "required",
                    category_id: "required",
                    description: "required",
                    total_pages: "required",
                    price: "required",
                    amount: "required",
                    author: "required"
                },
                messages: {
                    title: "Please fill title!",
                    image: "Please choose image!",
                    category_id: "Please choose category",
                    description: "Please fill description!",
                    total_pages: "Please fill total pages!",
                    amount: "Please fill amount!",
                    author: "Please fill author!"
                }
            });
            if (!$(this).valid()) return false;
            event.preventDefault();

            $('#createBookModal').modal('hide');
            var formdata = new FormData(this);
            $.ajax({
                url: '/admin/book',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                dataType: 'json',
                data: formdata,
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
                        var table = $('#datatableBook').DataTable();
                        $.fn.dataTable.ext.errMode = 'none';
                        table.row.add(
                            [
                                data['book']['title'],
                                data['book']['image'],
                                data['book']['category_id'],
                                data['book']['description'],
                                data['book']['total_pages'],
                                data['book']['price'],
                                data['book']['amount'],
                                data['book']['author'],
                                function (id) {
                                    return '<div class="text-center">'
                                        + '<button onclick = "navReview(' + id + ')" type="button">CMS</button> <br><br>'
                                        + '<a href="javascript:void(0)" onclick= "editBook(' + id + ')"><img src="/images/icon_edit.png"  width="18px" height="18px"></a>'
                                        + '<span>  </span>' + '<a href="javascript:void(0)" onclick="deleteBook(' + id + ')"><img src="/images/icon_delete.png"  width="18px" height="18px"></a>'
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
                })
        });
        $('#bookFormEdit').on('submit', function (event) {
            $("#bookFormEdit").validate({
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

            $('#editBookModal').modal('hide');
            var formData = new FormData(this);
            $.ajax({
                url: '/admin/book/' + $('#editId').val(),
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
                        var table = $('#datatableBook').DataTable();
                        $.fn.dataTable.ext.errMode = 'none';
                        var rows = table.rows().data();
                        for (var i = 0; i < rows.length; i++) {
                            if (rows[i].id == data['book']['id']) {
                                table.row(this).data(
                                    [
                                        data['book']['title'],
                                        data['book']['image'],
                                        data['book']['description'],
                                        data['book']['total_pages'],
                                        data['book']['price'],
                                        data['book']['amount'],
                                        data['book']['author'],
                                        function (id) {
                                            return '<div class="text-center">'
                                                + '<button onclick = "navReview(' + id + ')" type="button">CMS</button> <br><br> '
                                                + '<a href="javascript:void(0)" onclick= "editBook(' + id + ')"><img src="/images/icon_edit.png"  width="18px" height="18px"></a>'
                                                + '<span>  </span>' + '<a href="javascript:void(0)" onclick="deleteBook(' + id + ')"><img src="/images/icon_delete.png"  width="18px" height="18px"></a>'
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

    function editBook(id) {
        $.ajax({
            url: 'admin/vogo/book/categories/',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            type: "GET",
        })
            .done(function (data) {
                if (data['message']['status'] === 'success') {
                    for ($i = 0; $i < data['categories'].length; $i++) {
                        $('#editCategory').append('<option value="' + data['categories'][$i]["id"] + '">' + data['categories'][$i]["name"] + '</option>')
                    }
                } else if (data.status === 'error') {
                    swal("", data['message']['description'], "error");
                }
            })
            .fail(function (error) {
                console.log(error);
            });
        $.ajax({
            url: '/admin/book/' + id,
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
                $('#editId').val(data['book']['id']);
                $('#editTitle').val(data['book']['title']);
                $('#showEditImage').attr('src', data['book']['image']);
                $('#editCategory').val( data['book']['category_id']);
                $('#editDescription').val(data['book']['description']);
                $('#editTotalPages').val(data['book']['total_pages']);
                $('#editPrice').val(data['book']['price']);
                $('#editAmount').val(data['book']['amount']);
                $('#editAuthor').val(data['book']['author']);
                $('#modal-loading').modal('hide');
                $('#editBookModal').modal('show');
            })
            .fail(function (error) {
                console.log(error);
            });

    }

    function deleteBook(id) {
        $.ajax({
            url: '/admin/book/' + id,
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
                    var table = $('#datatableBook').DataTable();
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

    function navReview(id) {
        $.ajax({
            url: 'admin/ajax/cms/' + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            data: {id: id},
            type: 'GET',
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



