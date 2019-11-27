<div id="page_content_ajax" class="right_col" role="main">
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <button id="addBook" class="btn btn-default" type="button">Add Book</button>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatableBook" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 5.00%">Id</th>
                            <th style="width: 25.00%">Title</th>
                            <th style="width: 10.00%">Image</th>
                            <th style="width: 40.00%">Description</th>
                            <th style="width: 10.00%">Pages</th>
                            <th style="width: 5.00%">Price</th>
                            <th style="width: 5.00%">Amount</th>
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
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@include("modal.book.create")
@include("modal.book.edit")
<script>
    $(document).ready(function () {
        var category_id =  localStorage.getItem("category_id");
        $('#datatableBook').dataTable({
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
                url: '/admin/vogo/category/books',
                type: 'GET',
                data: {'id':category_id},
                dataType: 'json'
            },

            "columns": [
                {"data": "id"},
                {"data": "title"},
                {
                    "data": "image", "render": function (image) {
                        return '<div class="text-center">'
                            + '<img src="' + image + '" alt="" height="100px">'
                            + '</div>';
                    }
                },
                {"data": "description"},
                {"data": "total_pages"},
                {"data": "price"},
                {"data": "amount"},
            ]
        });
    });

</script>
