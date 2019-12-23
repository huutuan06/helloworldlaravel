<?php
/**
 * Created by PhpStorm.
 * User: lorence
 * Date: 15/08/2018
 * Time: 17:05
 */
?>
<!-- Refer here https://getbootstrap.com/docs/4.0/components/modal/ -->
<div class="modal fade" id="customerUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLabel">Update Customer</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="customerFormEdit">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Name:</label>
                    <input name="_name" type="text" class="form-control" id="_name">
                    <input name="_id" type="hidden" class="form-control" id="_id">
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Phone number:</label>
                    <input name="_phone_number" type="number" class="form-control" id="_phone_number">
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Address:</label>
                    <input name="_address" type="text" class="form-control" id="_address">
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Date of Birth:</label>
                    <input name="_date_of_birth" type="date" id="_date_of_birth">
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Avatar:</label><br>
                    <img src="" id="_avatar" width="100px" height="100px">
                    <input name="_avatar" type="file" onchange="readAvatarEdit(this);" id="editUserAvatar" style="margin-top: 10px;">
                </div>
                <div class="form-group" id="_gender">
                    <label for="recipient-name" class="col-form-label">Gender:</label>
                    <br>
                    <input type="radio" name="gender" value="0"> Male<br>
                    <input type="radio" name="gender" value="1"> Female<br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
