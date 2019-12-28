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
                    <input name="name" type="text" class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Email:</label>
                    <input name="email" type="text" class="form-control" id="email">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Password:</label>
                    <input name="password" type="password" class="form-control" id="password">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Phone number:</label>
                    <input name="phone_number" type="number" class="form-control" id="phone_number">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Avatar:</label><br>
                    <img src="https://vogobook.s3-ap-southeast-1.amazonaws.com/vogobook/avatar/data/profile.png" id="showGetAvatar" width="100px" height="100px">
                    <input name="avatar" type="file" class="" id="avatar" style="margin-top: 10px;">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Gender:</label>
                    <input type="radio" id="male" name="gender" value="0" style="margin: 0 10px;"><span>Male</span>
                    <input type="radio" id="female" name="gender" value="1" style="margin: 0 10px;"><span>Female</span>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Address:</label>
                    <input name="address" type="text" class="form-control" id="address">
                </div>
                <div class="form-group">
                    <label class="col-form-label">Date of Birth:</label>
                    <input name="date_of_birth" type="date" id="date_of_birth">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
