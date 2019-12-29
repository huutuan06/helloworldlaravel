<?php
/**
 * Created by PhpStorm.
 * User: lorence
 * Date: 15/08/2018
 * Time: 17:05
 */
?>
<!-- Refer here https://getbootstrap.com/docs/4.0/components/modal/ -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLabel">Edit</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="orderFormEdit">
                <div class="form-group">
                    <label for="order_code" class="col-form-label">Order Code: </label>
                    <input name="order_code" type="text" class="form-control" id="order_code" disabled="">
                    <input name="order_code" type="hidden" class="form-control" id="order_code">
                </div>
                <div class="form-group">
                    <label for="book_order" class="col-form-label">List of Ordered Book:</label>

                </div>
                <div class="form-group">
                    <label for="book_order" class="col-form-label">Status:</label>
                </div>
                <select class="form-group" style="padding: 5px 10px;" id="order_status">
                    <option id="confirm" selected=''>Confirm</option>
                    <option id="delivery" selected=''>Delivery</option>
                    <option id="success" selected=''>Success</option>
                    <option id="reject" selected=''>Reject</option>
                </select>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
