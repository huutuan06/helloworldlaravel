<?php
/**
 * Created by PhpStorm.
 * User: lorence
 * Date: 15/08/2018
 * Time: 17:05
 */
?>
<!-- Refer here https://getbootstrap.com/docs/4.0/components/modal/ -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLabel">Edit User</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="userFormEdit">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">User Name:</label>
                        <input name="name" type="text" class="form-control" id="editUserName">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">User Email:</label>
                        <input name="name" type="text" class="form-control" id="editUserEmail">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">User Address:</label>
                        <input name="name" type="text" class="form-control" id="editUserAddress">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">User's Date of Birth:</label>
                        <input type="datetime-local" name="editUserBirth">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">User Avatar:</label>
                        <img src="\images\img.jpg" width="24px" height="24px" name="editUserAvatar">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">User Gender:</label>
                        <br>
                        <input type="radio" name="gender" value="male"> Male<br>
                        <input type="radio" name="gender" value="female"> Female<br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send message</button>
                </div>
            </form>
        </div>
    </div>
</div>
