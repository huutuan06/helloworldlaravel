<?php
/**
 * Created by PhpStorm.
 * User: lorence
 * Date: 15/08/2018
 * Time: 17:05
 */
?>
<!-- Refer here https://getbootstrap.com/docs/4.0/components/modal/ -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLabel">Create User</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="userFormCreate">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Name:</label>
                        <input name="name" type="text" class="form-control" id="userName">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Email:</label>
                        <input name="email" type="text" class="form-control" id="userEmail">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Password:</label>
                        <input name="password" type="password" class="form-control" id="userPassword">
                    </div>
                </div>
{{--                <div class="modal-body">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="recipient-name" class="col-form-label">Confirm Password:</label>--}}
{{--                        <input name="confirm_password" type="password" class="form-control" id="editUserConfirmPassword">--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Avatar:</label>
                        <br>
                        <img src="" id="showGetAvatar" width="100px" height="100px">
                        <input name="avatar" type="file" class="form-control" onchange="readAvatarCreate(this);" id="userAvatar">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Gender:</label>
                        <br>
                        <input type="radio" name="gender" value="0"> Male<br>
                        <input type="radio" name="gender" value="1"> Female<br>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Address:</label>
                        <input name="address" type="text" class="form-control" id="userAddress">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Date of Birth:</label>
                        <input name="date_of_birth" type="date" id="userBirthDay">
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
