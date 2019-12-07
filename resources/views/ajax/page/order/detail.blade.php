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
                                <th style="width: 15.00%">Customer</th>
                                <th style="width: 15.00%">Email</th>
                                <th style="width: 20.00%">Products</th>
                                <th style="width: 5.00%">Amount</th>
                                <th style="width: 10.00%">Date's order</th>
                                <th style="width: 15.00%">Address for shipping</th>
                                <th style="width: 10.00%">Status order</th>
                                <th style="width: 5.00%; text-align: center">Decline</th>
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
        var order_id = localStorage.getItem("order_id");
        // $('#datatableOrders').dataTable({
        //     "pageLength": 15,
        //     "lengthMenu": [[15, 30, 45, -1], [15, 30, 45, 'All']],
        //     'paging': true,
        //     'lengthChange': true,
        //     'searching': true,
        //     'ordering': true,
        //     'info': true,
        //     'autoWidth': false,
        //     "processing": true,
        //     "serverSide": true,
        //
        //     "ajax": {
        //         url: '/admin/vogo/order/detail/' + order_id,
        //         type: 'GET',
        //         data: {'id': order_id},
        //         dataType: 'json'
        //     },
        //
        //     "columns": [
        //         {"data": "order_id"},
        //         {"data": "customer_name"},
        //         {"data": "email"},
        //         {"data": "books"},
        //         {"data": "amount"},
        //         {"data": "date"},
        //         {"data": "address"},
        //         {"data": "order_status"},
        //         {
        //             "data": "manipulation", "render": function (id) {
        //                 return '<div class="text-center">'
        //                     + '<a href="javascript:void(0)" onclick= "decline(' + id + ')"><img src="/images/icon_edit.png"  width="18px" height="18px"></a>'
        //                     + '</div>';
        //             }
        //         }
        //     ]
        // });
    });
</script>
