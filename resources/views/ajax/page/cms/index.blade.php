<div id="page_content_ajax" class="right_col" role="main">
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_title">
                <h4>New Post</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8" style="background-color: rgba(112,112,112,0.26);">
            <div class="modal-body">
                <div class="form-group">
                    <label for="input">Content</label>
                    <textarea class="form-control" name="content" id="input" rows="28"></textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-4" style="background-color: rgba(112,112,112,0.26);">
            <div class="modal-body">
                <div class="row row h-100 align-items-center justify-content-centerr">
                    <div class="col align-self-cente ">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="titleTag">Title tag</label>
                                        <input type="text" class="form-control" id="titleTag" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="descriptionTag">Description tag</label>
                                        <input type="text" class="form-control" id="descriptionTag">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="referrerTag">Referrer tag</label>
                                        <input type="text" class="form-control" id="referrerTag" value="always">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="keywordTag">Keyword tag</label>
                                        <input type="text" class="form-control" id="keywordTag">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="viewportTag">ViewPort tag</label>
                                        <input type="text" class="form-control" id="viewportTag"
                                               value="width=device-width, initial-scale=1">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="contentTypeTag">Content-Type tag</label>
                                        <input type="text" class="form-control" id="contentTypeTag"
                                               value="text/html; charset=utf-8">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Post</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ URL::to('js/vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
    var editor_config = {
        path_absolute: "{{ URL::to('/') }}/",
        selector: "textarea",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern",
        ],
        file_picker_types: 'file image media',

        toolbar: "code preview | undo redo | formatselect | fontselect | fontsizeselect | bold italic underline strikethrough backcolor | subscript superscript | numlist bullist | alignleft aligncenter alignright alignjustify | outdent indent | paste searchreplace | toc link image media charmap insertdatetime emoticons hr | table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol | removeformat",
        insertdatetime_element: true,
        media_scripts: [
            {filter: 'platform.twitter.com'},
            {filter: 's.imgur.com'},
            {filter: 'instagram.com'},
            {filter: 'https://platform.twitter.com/widgets.js'},
        ],
        relative_urls: false,
        browser_spellcheck: true,
        contextmenu: false,
        file_browser_callback: function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;
            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }
            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        }
    };
    tinymce.init(editor_config);
</script>
<script>
    $.ajax({
        url: 'admin/ajax/books',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        type: 'POST',
        beforeSend: function () {
            $('#modal-loading').modal('show');
        }
    })
        .done(function (data) {
            // console.log(data['html']);
            $('#modal-loading').modal('hide');
            console.log("here:" + data['id']);
        });
</script>
