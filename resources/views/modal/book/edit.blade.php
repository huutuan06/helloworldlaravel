<?php
/**
 * Created by PhpStorm.
 * User: lorence
 * Date: 15/08/2018
 * Time: 17:05
 */
?>
<!-- Refer here https://getbootstrap.com/docs/4.0/components/modal/ -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLabel">Edit Book</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="bookFormEdit">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Title:</label>
                        <input name="title" type="text" class="form-control" id="editTitle">
                        <input name="id" type="hidden" class="form-control" id="editId">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Image:</label>
                        <br>
                        <img src="" id="showImage" height="200px">
                        <input name="image" type="file" class="form-control" id="editImage">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Description:</label>
                        <textarea name="description" class="form-control" id="editDescription"/>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Total Pages:</label>
                        <input name="total_pages" type="number" class="form-control" id="editTotalPages"/>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Price:</label>
                        <input name="price" type="text" class="form-control" id="editPrice"/>
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
