<div class="modal fade" id="createCustomerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">New Customer</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="customerFormCreate">
                <div class="form-group">
                    <label class="col-form-label">Name:</label>
                    <input name="name" type="text" class="form-control" id="userName">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Email:</label>
                    <input name="email" type="text" class="form-control" id="userEmail">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Password:</label>
                    <input name="password" type="password" class="form-control" id="userPassword">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Phone number:</label>
                    <input name="phone_number" type="number" class="form-control" id="userPhoneNumber">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Avatar:</label>
                    <br>
                    <img src="https://vogobook.s3-ap-southeast-1.amazonaws.com/vogobook/avatar/data/profile.jpg" id="showGetAvatar" width="100px" height="100px">
                    <input name="avatar" type="file" class="" id="userAvatar" style="margin-top: 10px;">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Gender:</label>
                    <input type="radio" name="gender" value="0" style="margin: 0 10px;"> Male
                    <input type="radio" name="gender" value="1" style="margin: 0 10px;"> Female
                </div>
                <div class="form-group">
                    <label class="col-form-label">Address:</label>
                    <input name="address" type="text" class="form-control" id="userAddress">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Date of Birth:</label>
                    <input name="date_of_birth" type="date" id="userBirthDay">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
