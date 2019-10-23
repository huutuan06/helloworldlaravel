<?php
/**
 * Created by PhpStorm.
 * User: vuongluis
 * Date: 4/7/2018
 * Time: 11:11 AM
 */
?>
<div id="page_content_ajax" class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Users
                    <small>Some examples to get you started</small>
                </h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Default Example
                            <small>Users</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <p class="text-muted font-13 m-b-30">
                            DataTables has most features enabled by default, so all you need to do to use it with your
                            own tables is to call the construction function: <code>$().DataTable();</code>
                        </p>
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Total Pages</th>
                                <th>Price</th>
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
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#datatable').dataTable({
            "pageLength": 15,
            "lengthMenu": [[15,30,45,-1], [15,30,45,'All']],
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: '/admin/book',
                type: 'GET'
            },

            "columns": [
                { "data": "id" },
                { "data": "title" },
                { "data": "image" },
                { "data": "description" },
                { "data": "total_pages" },
                { "data": "price" },

            ]
        });
    });
</script>
