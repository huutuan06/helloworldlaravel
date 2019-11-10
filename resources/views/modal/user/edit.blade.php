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
                        <label for="recipient-name" class="col-form-label">Name:</label>
                        <input name="name" type="text" class="form-control" id="editUserName">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Email:</label>
                        <input name="email" type="text" class="form-control" id="editUserEmail">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Password:</label>
                        <input name="password" type="password" class="form-control" id="editUserPassword">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Address:</label>
                        <input name="address" type="text" class="form-control" id="editUserAddress">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Date of Birth:</label>
                        <input name="date_of_birth" type="date" id="editUserBirthDay">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Avatar:</label>
                        <img src="" id="showEditAvatar" width="100px" height="100px">
                        <input name="avatar" type="file" class="form-control" onchange="readAvatarEdit(this);" id="editUserAvatar">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="editUserGender">
                        <label for="recipient-name" class="col-form-label">Gender:</label>
                        <br>
                        <input type="radio" name="gender" value="0"> Male<br>
                        <input type="radio" name="gender" value="1"> Female<br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
