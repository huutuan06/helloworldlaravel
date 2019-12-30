<!-- module content -->
<script src="{{ URL::asset('js/tynimce_custom.min.js') }}"></script>
<div id="page_content_ajax" class="right_col" role="main">
    <div class="row">
        <div class="col-md-9">
            <form id="articleForm" method="post">
                <div class="row">
                    <div>
                        <input id="slugTitle" name="slugTitle" class="form-control" type="text" value="{{ $book->title }}" maxlength="255">
                        <input type="hidden" id="bookID" value="{{ $book->id }}"/>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <textarea id="bookDesc" name="bookDesc">
                        {{ $book->description }}
                    </textarea>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-sm-12 col-md-12">
                        <div class="col-sm-12 col-md-12">
                            <img id="place_holder" src="{{ $book->place_holder }}"
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
                    <textarea id="bookContent" name="bookContent">
                        {{ $book->content }}
                    </textarea>
                </div>
            </form>
        </div>
        <div class="col-md-3">
            <div class="row buttonPublish" style="margin: 0 auto;">
                <button id="pushlisher" class="btn">Publish</button>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="title" style="margin-left: 10px;">Title:</label>
                <input type="text" class="form-control" placeholder="" style="border: 0;" id="title" value="{{ $book->title }}"/>
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
                    <label for="description" style="margin-left: 10px;">Description:</label>
                    <textarea class="form-control" rows="5" id="description" style="border: 0;">{{ isset($meta) ? $meta->description : "" }}</textarea>
                </div>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="keywords" style="margin-left: 10px;">Keywords:</label>
                <input value="{{ isset($meta) ? $meta->keywords : "" }}" type="text" class="form-control" placeholder="" style="border: 0;" id="keywords"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="author" style="margin-left: 10px;">Author:</label>
                <input value="{{ isset($meta) ? $meta->author : "" }}" type="text" class="form-control" placeholder="" style="border: 0;" id="author"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="theme_color" style="margin-left: 10px;">Theme Color:</label>
                <input value="{{ isset($meta) ? $meta->theme_color : "#000000" }}" type="color" style="border: 0;" id="theme_color"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="og_title" style="margin-left: 10px;">Og Title:</label>
                <input value="{{ isset($meta) ? $meta->og_title : "" }}" type="text" class="form-control" style="border: 0;" id="og_title"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="og_image" style="margin-left: 10px;">Og Image:</label>
                <input value="{{ isset($meta) ? $meta->og_image : "" }}" type="text" class="form-control" style="border: 0;" id="og_image"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="og_url" style="margin-left: 10px;">Og URL:</label>
                <input value="{{ isset($meta) ? $meta->og_url : "" }}" type="text" class="form-control" style="border: 0;" id="og_url"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="og_site_name" style="margin-left: 10px;">Og Site Name:</label>
                <input value="{{ isset($meta) ? $meta->og_site_name : "" }}" type="text" class="form-control" style="border: 0;" id="og_site_name"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="og_description" style="margin-left: 10px;">Og Description:</label>
                <input value="{{ isset($meta) ? $meta->og_description : "" }}" type="text" class="form-control" style="border: 0;" id="og_description"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="fb_app_id" style="margin-left: 10px;">Fb App ID:</label>
                <input value="{{ isset($meta) ? $meta->fb_app_id : "" }}" type="text" class="form-control" style="border: 0;" id="fb_app_id"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="twitter_card" style="margin-left: 10px;">Twitter Card:</label>
                <input value="{{ isset($meta) ? $meta->twitter_card : "" }}" type="text" class="form-control" style="border: 0;" id="twitter_card"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="twitter_title" style="margin-left: 10px;">Twitter Title:</label>
                <input value="{{ isset($meta) ? $meta->twitter_title : "" }}" type="text" class="form-control" style="border: 0;" id="twitter_title"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="twitter_description" style="margin-left: 10px;">Twitter Description:</label>
                <input value="{{ isset($meta) ? $meta->twitter_description : "" }}" type="text" class="form-control" style="border: 0;" id="twitter_description"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="twitter_url" style="margin-left: 10px;">Twitter URL:</label>
                <input value="{{ isset($meta) ? $meta->twitter_url : "" }}" type="text" class="form-control" style="border: 0;" id="twitter_url"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="twitter_image" style="margin-left: 10px;">Twitter Image:</label>
                <input value="{{ isset($meta) ? $meta->twitter_image : "" }}" type="text" class="form-control" style="border: 0;" id="twitter_image"/>
            </div>
            <div class="row" style="margin: 10px auto 0;">
                <label for="parsely_link" style="margin-left: 10px;">Parsely Link:</label>
                <input value="{{ isset($meta) ? $meta->parsely_link : "" }}" type="text" class="form-control" style="border: 0;" id="parsely_link"/>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#pushlisher').click(function(event){
        event.preventDefault();
        var formData = new FormData();
        formData.append('slugTitle', $("#slugTitle").val());
        formData.append('bookID', $("#bookID").val());
        formData.append('bookDesc', tinyMCE.get('bookDesc').getContent());
        formData.append('bookPlaceholder', $("#place_holder").attr("src"));
        formData.append('bookContent', tinyMCE.get('bookContent').getContent());
        formData.append('title', $('#title').val());
        formData.append('referrer', $('#referrer').val());
        formData.append('description', $('#description').val());
        formData.append('keywords', $('#keywords').val());
        formData.append('author', $('#author').val());
        formData.append('theme_color', $('#theme_color').val());
        formData.append('og_title', $('#og_title').val());
        formData.append('og_image', $('#og_image').val());
        formData.append('og_url', $('#og_url').val());
        formData.append('og_site_name', $('#og_site_name').val());
        formData.append('og_description', $('#og_description').val());
        formData.append('fb_app_id', $('#fb_app_id').val());
        formData.append('twitter_card', $('#twitter_card').val());
        formData.append('twitter_title', $('#twitter_title').val());
        formData.append('twitter_description', $('#twitter_description').val());
        formData.append('twitter_url', $('#twitter_url').val());
        formData.append('twitter_image', $('#twitter_image').val());
        formData.append('parsely_link', $('#parsely_link').val());
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
                    window.location.href = 'https://vogobook.luisnguyen.com/books/'+$("#slugTitle").val().replace(/\s+/g, '-')+'.html';
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
                        $("#og_url").val(place_holder);
                        $("#twitter_url").val(place_holder)
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
