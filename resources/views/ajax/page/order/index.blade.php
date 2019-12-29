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
        console.log(id);
    }
</script>
