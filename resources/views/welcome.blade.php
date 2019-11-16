<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row text-center">
        <div class="col-xs-10 col-xs-offset-1">
            <h1>Using TinyMCE with Laravel</h1>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-xs-10 col-xs-offset-1">
            <form action="" method="post">
                <div class="form-group">
                    <label for="input">Your Input</label>
                    <textarea class="form-control" name="content" id="input" rows="25"></textarea>
                </div>
                {{ csrf_field() }}
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>
<script src="{{ URL::to('js/vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
    var editor_config = {
        selector: "textarea",
        plugins: "lists advlist autolink autoresize charmap code emoticons hr image insertdatetime link media paste preview searchreplace table textpattern toc visualblocks visualchars wordcount quickbars",
        toolbar: "code preview | undo redo | formatselect | fontselect | fontsizeselect | bold italic underline strikethrough backcolor | subscript superscript | numlist bullist | alignleft aligncenter alignright alignjustify | outdent indent | paste searchreplace | toc link image media charmap insertdatetime emoticons hr | table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol | removeformat",
        insertdatetime_element: true,
        media_scripts: [
            {filter: 'platform.twitter.com'},
            {filter: 's.imgur.com'},
            {filter: 'instagram.com'},
            {filter: 'https://platform.twitter.com/widgets.js'},
        ],
        browser_spellcheck: true,
        contextmenu: false,

    };
    tinymce.init(editor_config);
</script>
</body>
</html>
