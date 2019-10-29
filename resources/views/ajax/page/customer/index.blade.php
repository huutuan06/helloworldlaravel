<div id="page_content_ajax" class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <p class="text-muted font-13 m-b-30">
                            DataTables has most features enabled by default, so all you need to do to use it with your
                            own tables is to call the construction function: <code>$().DataTable();</code>
                        </p>
                        <table id="datatablesCustomer" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 5.00%">ID</th>
                                <th style="width: 20.00%">Name</th>
                                <th style="width: 20.00%">Email</th>
                                <th style="width: 10.00%">Date of Birth</th>
                                <th style="width: 5.00%">Avatar</th>
                                <th style="width: 25.00%">Address</th>
                                <th style="width: 5.00%">Gender</th>
                                <th style="width: 10.00%; text-align: center">Manipulation</th>
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
@include('modal.customer.edit')
<script>
    $(document).ready(function () {
        $('#datatablesCustomer').dataTable({
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
                url: '/admin/customer',
                type: 'GET'
            },

            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "email"},
                {"data": "date_of_birth"},
                {
                    "data": "avatar", "render": function (avatar) {
                        return '<img src="' + avatar + '" width="56px;" height="56px;" alt="avatar"/>';
                    }
                },
                {"data": "address"},
                {
                    "gender": "gender", "render": function (gender) {
                        if (gender === 1)
                            return '<img src="/images/icon_gender_female.png"  width="24px" height="24px">';
                        else
                            return '<img src="/images/icon_gender_male.png"  width="24px" height="24px">'
                    }
                },
                {
                    "data": "manipulation", "render": function (id) {
                        return '<div class="text-center">'
                            + '<a onclick= "editCustomer(' + id + ')"><img src="/images/icon_edit.svg"  width="24px" height="24px"></a>'
                            + '<span>  </span>' + '<a href="/admin/millionaire/delete/' + id + '" onclick="deleteCategory(' + id + ')"><img src="/images/icon_delete.svg"  width="24px" height="24px"></a>'
                            + '</div>';
                    }
                }
            ]
        });
    });

    function editCustomer(id) {
        $.ajax({
            url: '/admin/customer/' + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            type: "GET",
            beforeSend: function () {
                $('#modal-loading').modal('show');
            }
        })
            .done(function (data) {
                $('#editCustomerName').val(data['customer']['name']);
                $('#editCustomerEmail').val(data['customer']['email']);
                $('#editCustomerAddress').val(data['customer']['address']);

                // $('#editCustomerBirth').val(data['customer']['date_of_birth']);
                // $('#editCustomerAvatar').attr('src',data['customer']['avatar']);

                $('#modal-loading').modal('hide');
                $('#editCustomerModal').modal('show');
            })
            .fail(function (error) {
                console.log(error);
            });
    }

</script>
