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
                                <th style="width: 25.00%">Email</th>
                                <th style="width: 40.00%">Date's order</th>
                                <th style="width: 20.00%">Status</th>
                                <th style="width: 10.00%; text-align: center">Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
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
                {"data": "email"},
                {"data": "date"},
                {"data": "status"},
                {
                    "data": "detail", "render": function (id) {
                        return '<div class="text-center">'
                            + '<a href="javascript:void(0)" onclick = "navDetail(' + id + ')"><img src="/images/icon_detail.png"  width="18px" height="18px"></a> '
                            + '</div>';
                    }
                }
            ]
        });
    });

    function navDetail(id) {
        localStorage.setItem("order_id", id);
        $.ajax({
            url: 'admin/ajax/order/detail',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            type: 'POST',
            beforeSend: function () {
                $('#modal-loading').modal('show');
            }
        })
            .done(function (data) {
                $('#modal-loading').modal('hide');
                $('#page_content_ajax').replaceWith(data['html']);
            });
    }
</script>
