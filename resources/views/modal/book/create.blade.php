<div class="modal fade" id="createBookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLabel">New Book</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="bookFormCreate">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Title:</label>
                        <input name="title" type="text" class="form-control" id="bookTitle">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Image:</label>
                        <br>
                        <img src="" id="showGetImage" height="200px">
                        <input name="image" type="file" class="form-control" onchange="readImageCreate(this);" id="bookImage">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Category:</label>
                        <select name="category_id" class="form-control" id="bookCategory">

                        </select>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Description:</label>
                        <textarea name="description" class="form-control" id="bookDescription"/>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Total Pages:</label>
                        <input name="total_pages" type="text" class="form-control" id="bookTotalPages"/>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Price:</label>
                        <input name="price" type="text" class="form-control" id="bookPrice"/>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Amount:</label>
                        <input name="amount" type="text" class="form-control" id="bookAmount"/>
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
