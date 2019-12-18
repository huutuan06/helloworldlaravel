<!-- module content -->
<script src="{{ URL::asset('js/tynimce_custom.min.js') }}"></script>
<div id="page_content_ajax" class="right_col" role="main">
    <div class="row">
        <div class="col-md-9">
            <form id="articleForm" method="post">
                <div class="row">
                    <div>
                        <input id="slugTitle" name="slugTitle" class="form-control" type="text" value="{{ $book->title }}" maxlength="255">
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <textarea id="bookDesc" name="bookDesc">Write your description here!</textarea>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-sm-12 col-md-12">
                        <div class="col-sm-12 col-md-12">
                            <img id="place_holder" src="https://vogobook.s3-ap-southeast-1.amazonaws.com/cms/placeholder_cms.png"
                                 alt="" class="img-rounded img-responsive" />
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <label for="exampleInputFile">Chọn tập tin ảnh</label>
                            <input name="bookPlaceholder" type="file" id="bookPlaceholder" accept="image/*" >
                        </div>
                    </div>
                </div>
                <div class="_clearFix"></div>
                <div class="row" style="margin-top: 20px;">
                    <textarea id="bookContent" name="bookContent">Write your content here!</textarea>
                </div>
            </form>
        </div>
        <div class="col-md-3">
            <div class="row buttonPublish" style="margin: 0 auto;">
                <button id="pushlisher" class="btn">Publish</button>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="title" style="margin-left: 10px;">Title:</label>
                <input type="text" class="form-control" placeholder="" style="border: 0;" id="title"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <div class="form-group">
                    <label for="referrer" style="margin-left: 10px;">Referrer:</label>
                    <select class="form-control" id="referrer"  style="border: 0;">
                        <option>none</option>
                        <option>none-when-downgrade</option>
                        <option>origin</option>
                        <option>origin-when-crossorigin</option>
                        <option>unsafe-url</option>
                        <option>always</option>
                    </select>
                </div>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <div class="form-group">
                    <label for="_description" style="margin-left: 10px;">Description:</label>
                    <textarea class="form-control" rows="5" id="description" style="border: 0;"></textarea>
                </div>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_keywords" style="margin-left: 10px;">Keywords:</label>
                <input type="text" class="form-control" placeholder="" style="border: 0;" id="keywords"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_meta_author" style="margin-left: 10px;">Author:</label>
                <input type="text" class="form-control" placeholder="" style="border: 0;" id="author"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_meta_theme_color" style="margin-left: 10px;">Theme Color:</label>
                <input type="color" class="" value="#000000" style="border: 0;" id="theme_color"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_meta_og_title" style="margin-left: 10px;">Og Title:</label>
                <input type="text" class="form-control" style="border: 0;" id="og_title"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_meta_og_image" style="margin-left: 10px;">Og Image:</label>
                <input type="text" class="form-control" style="border: 0;" id="_meta_og_image"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_meta_og_url" style="margin-left: 10px;">Og URL:</label>
                <input type="text" class="form-control" style="border: 0;" id="_meta_og_url"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_meta_og_site_name" style="margin-left: 10px;">Og Site Name:</label>
                <input type="text" class="form-control" style="border: 0;" id="_meta_og_site_name"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_meta_og_description" style="margin-left: 10px;">Og Description:</label>
                <input type="text" class="form-control" style="border: 0;" id="_meta_og_description"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_meta_fb_app_id" style="margin-left: 10px;">Fb App ID:</label>
                <input type="text" class="form-control" style="border: 0;" id="_meta_fb_app_id"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_meta_twitter_card" style="margin-left: 10px;">Twitter Card:</label>
                <input type="text" class="form-control" style="border: 0;" id="_meta_twitter_card"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_meta_twitter_title" style="margin-left: 10px;">Twitter Title:</label>
                <input type="text" class="form-control" style="border: 0;" id="_meta_twitter_title"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_meta_twitter_description" style="margin-left: 10px;">Twitter Description:</label>
                <input type="text" class="form-control" style="border: 0;" id="_meta_twitter_description"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_meta_twitter_url" style="margin-left: 10px;">Twitter URL:</label>
                <input type="text" class="form-control" style="border: 0;" id="_meta_twitter_url"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_meta_twitter_image" style="margin-left: 10px;">Twitter Image:</label>
                <input type="text" class="form-control" style="border: 0;" id="_meta_twitter_image"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="_meta_parsely_link" style="margin-left: 10px;">Parsely Link:</label>
                <input type="text" class="form-control" style="border: 0;" id="_meta_parsely_link"/>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#pushlisher').click(function(event){
        event.preventDefault();
        var formData = new FormData();
        formData.append('slugTitle', $("#slugTitle").val());
        formData.append('bookDesc', tinyMCE.get('bookDesc').getContent());
        formData.append('bookPlaceholder', $("#imageUpload").attr("src"));
        formData.append('bookContent', tinyMCE.get('bookContent').getContent());
        formData.append('title', $('#title').val());
        formData.append('referrer', $('#referrer').val());
        formData.append('description', $('#description').val());
        formData.append('keywords', $('#keywords').val());
        formData.append('author', $('#_meta_author').val());
        formData.append('theme_color', $('#theme_color').val());
        formData.append('_meta_og_title', $('#_meta_og_title').val());
        formData.append('_meta_og_image', $('#_meta_og_image').val());
        formData.append('_meta_og_url', $('#_meta_og_url').val());
        formData.append('_meta_og_site_name', $('#_meta_og_site_name').val());
        formData.append('_meta_og_description', $('#_meta_og_description').val());
        formData.append('_meta_fb_app_id', $('#_meta_fb_app_id').val());
        formData.append('_meta_twitter_card', $('#_meta_twitter_card').val());
        formData.append('_meta_twitter_title', $('#_meta_twitter_title').val());
        formData.append('_meta_twitter_description', $('#_meta_twitter_description').val());
        formData.append('_meta_twitter_url', $('#_meta_twitter_url').val());
        formData.append('_meta_twitter_image', $('#_meta_twitter_image').val());
        formData.append('_meta_parsely_link', $('#_meta_parsely_link').val());
        $.ajax({
            url: '/admin/cms/new',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $('#modal-loading').modal('show');
            }
        })
            .done(function (data) {
                $('#modal-loading').modal('hide');
                if(data['message']['status'] === 'invalid') {
                    swal("", data['message']['description'], "error");
                }
                if (data['message']['status'] === 'existed') {
                    swal("", data['message']['description'], "error");
                }
                if (data['message']['status'] === 'success') {
                    $.ajax({
                        url: '/admin/articles',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        type: "GET"
                    })
                        .done(function(data) {
                            tinyMCE.remove();
                            $('#page_content_ajax').replaceWith(data['html']);
                        });
                } else if (data.status === 'error') {
                    swal("", data['message']['description'], "error");
                }
            })
            .fail(function (error) {
                console.log(error);
            });
    });

    $(function(){
        $("#bookPlaceholder").change(function(event) {
            if (!$(this).valid()) return false;
            event.preventDefault();
            var form = document.createElement('form');
            form.enctype = "application/x-www-form-urlencoded";
            var formData = new FormData(form);
            var file = document.getElementById("bookPlaceholder").files[0];
            if (file) {
                formData.append('bookPlaceholder', file);
            }
            $.ajax({
                url: '/admin/cms/placeholder',
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
                .done(function (data) {
                    if(data['message']['status'] === 'success') {
                        swal("", data['message']['description'], "success");
                        var place_holder = data['place_holder'];
                        $("#place_holder").attr("src", place_holder);
                    }
                    if(data['message']['status'] === 'error') {
                        swal("", data['message']['description'], "error");
                    }
                })
                .fail(function (error) {
                    console.log(error);
                });
        });
    });
</script>
