/**
 * Created by vuongluis on 10/13/2019.
 */
$(document).ready(function() {

    $("#nav_index").click(function (event) {
        event.preventDefault();
        $.ajax({
            url: '/admin/index',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            type: "GET",
            beforeSend: function() {
            }
        })
            .done(function(data){
                $('#page_content_ajax').replaceWith(data['html']);
            });
    });

    $("#nav_index_2").click (function (event) {
        event.preventDefault();
        $.ajax({
            url: '/admin/index2',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            type: "GET",
            beforeSend: function(){
            }
        })
            .done(function(data){
                $('#page_content_ajax').replaceWith(data['html']);
            });
    });

    $("#nav_index_3").click (function (event) {
        event.preventDefault();
        $.ajax({
            url: '/admin/index3',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            type: "GET",
            beforeSend: function(){
            }
        })
            .done(function(data){
                $('#page_content_ajax').replaceWith(data['html']);
            });
    });

});
