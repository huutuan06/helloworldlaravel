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
                        <button id="newCategory" class="btn btn-default" type="button">New Order</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatableOrders" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 5.00%">Order ID</th>
                                <th style="width: 10.00%">Code</th>
                                <th style="width: 15.00%">Email</th>
                                <th style="width: 30.00%">Address</th>
                                <th style="width: 5.00%">Confirmed ordering</th>
                                <th style="width: 5.00%">Delivery</th>
                                <th style="width: 5.00%">Success</th>
                                <th style="width: 5.00%">Cancel</th>
                                <th style="width: 10.00%">Date</th>
                                <th style="width: 10.00%">Manipulation</th>
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
@include("modal.order.edit")
<script>
    $(document).ready(function () {
        $('#datatableOrders').dataTable({
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
                url: '/admin/order',
                type: 'GET'
            },

            "columns": [
                {"data": "id"},
                {"data": "code"},
                {"data": "email"},
                {"data": "address"},
                {"data": "confirmed_ordering", "render" : function (confirmed_ordering) {
                    if(confirmed_ordering == 1) {
                        return '<div class="text-center">'
                            + '<img src="/images/icon_tick.png"  width="18px" height="18px">'
                            + '</div>';
                    } else {
                        return '<div></div>';
                    }
                    }},
                {"data": "delivery","render" : function (delivery) {
                        if(delivery == 1) {
                            return '<div class="text-center">'
                                + '<img src="/images/icon_tick.png"  width="18px" height="18px">'
                                + '</div>';
                        } else {
                            return '<div></div>';
                        }
                    }},
                {"data": "success","render" : function (success) {
                        if(success == 1) {
                            return '<div class="text-center">'
                                + '<img src="/images/icon_tick.png"  width="18px" height="18px"> '
                                + '</div>';
                        } else {
                            return '<div></div>';
                        }
                    }},
                {"data": "cancel","render" : function (cancel) {
                        if(cancel == 1) {
                            return '<div class="text-center">'
                                + '<img src="/images/icon_tick.png"  width="18px" height="18px">'
                                + '</div>';
                        } else {
                            return '<div></div>';
                        }
                    }},
                {"data": "updated_at"},
                {"data": "manipulation", "render": function (id) {
                        return '<div class="text-center">'
                            + '<a href="javascript:void(0)" onclick = "editOrder(' + id + ')"><img src="/images/icon_detail.png"  width="18px" height="18px"></a> '
                            + '</div>';
                    }
                }
            ]
        });
    });

    function editOrder(id) {
        $.ajax({
            url: '/admin/order/' + id,
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
                console.log(data);
                $('#modal-loading').modal('hide');
                $('#orderModal').modal('show');
                $('#order_code').val(data['order']['code']);
                $('#datatableBookOrders').dataTable({
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
                    "bDestroy": true,

                    "ajax": {
                        url: '/admin/book_order/' + id,
                        type: 'GET'
                    },

                    "columns": [
                        {"data": "id"},
                        {"data": "book_title"},
                        {"data": "total_book"},
                        {"data": "price"},
                        {"data": "image", "render": function (image) {
                                return '<img src="' + image + '" alt="image"/>';
                            }
                        }
                    ]
                });
                $('#order_status option').each(function () {
                    if ($(this).css('display') != 'none') {
                        if ($(this).val() == "confirm" && data['order']['confirmed_ordering'] == 1) {
                            $(this).prop("selected", true);
                            return false;
                        }
                        if ($(this).val() == "delivery" && data['order']['delivery'] == 1) {
                            $(this).prop("selected", true);
                            return false;
                        }
                        if ($(this).val() == "success" && data['order']['success'] == 1) {
                            $(this).prop("selected", true);
                            return false;
                        }
                        if ($(this).val() == "reject" && data['order']['cancel'] == 1) {
                            $(this).prop("selected", true);
                            return false;
                        }
                    }
                });
            })
            .fail(function (error) {
                console.log(error);
            });
    }

    $('#orderFormEdit').on('submit', function (event) {
        event.preventDefault();
        $('#orderModal').modal('hide');
        var formData = new FormData(this);
        $.ajax({
            url: '/admin/order',
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
                console.log(data);
                if (data['message']['status'] === 'invalid') {
                    swal("", data['message']['description'], "error");
                }
                if (data['message']['status'] === 'existed') {
                    swal("", data['message']['description'], "error");
                }
                if (data['message']['status'] === 'success') {
                    swal("", data['message']['description'], "success");
                    var table = $('#datatableOrders').DataTable();
                    $.fn.dataTable.ext.errMode = 'none';
                    var rows = table.rows().data();
                    for (var i = 0; i < rows.length; i++) {
                        if (rows[i].id == data['order']['id']) {
                            table.row(this).data(
                                [
                                    data['order']['id'],
                                    data['order']['code'],
                                    data['order']['email'],
                                    data['order']['address'],
                                    function (confirmed_ordering) {
                                        if(confirmed_ordering == 1) {
                                            return '<div class="text-center">'
                                                + '<img src="/images/icon_tick.png"  width="18px" height="18px">'
                                                + '</div>';
                                        } else {
                                            return '<div></div>';
                                        }
                                    },
                                    function (delivery) {
                                        if(delivery == 1) {
                                            return '<div class="text-center">'
                                                + '<img src="/images/icon_tick.png"  width="18px" height="18px">'
                                                + '</div>';
                                        } else {
                                            return '<div></div>';
                                        }
                                    },
                                    function (success) {
                                        if(success == 1) {
                                            return '<div class="text-center">'
                                                + '<img src="/images/icon_tick.png"  width="18px" height="18px">'
                                                + '</div>';
                                        } else {
                                            return '<div></div>';
                                        }
                                    },
                                    function (cancle) {
                                        if(cancle == 1) {
                                            return '<div class="text-center">'
                                                + '<img src="/images/icon_tick.png"  width="18px" height="18px">'
                                                + '</div>';
                                        } else {
                                            return '<div></div>';
                                        }
                                    },
                                    data['order']['updated_at'],
                                    function (id) {
                                        return '<div class="text-center">'
                                            + '<a href="javascript:void(0)" onclick = "editOrder(' + id + ')"><img src="/images/icon_detail.png"  width="18px" height="18px"></a> '
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

</script>
