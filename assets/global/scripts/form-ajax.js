/**
 * Created by benshittu on 06/11/15.
 */

$(function(){

    $(document).on("keypress", "form.form-ajax input", function(e){
        if(e.which == 13){
            e.preventDefault();
            $(this).closest('form.form-ajax').submit();
        }
    });

    $(document).on("submit", "form.form-ajax", function(e){

        e.preventDefault();

        var $form = $(this);
        var $inputs = $form.find('input, select, textarea');
        var $form_error = $form.find('.form-error');
        var $form_success = $form.find('.form-success');
        var can_submit = true;

        $form_error.find('.form-errors-top').remove();
        $form_error.hide();
        $form_success.find('.form-success-top').remove();
        $form_success.hide();

        $inputs.each(function(){
            var $input = $(this);
            $input.css({'border' : ''});
            $input.parent().find('.red-message').remove();
        });

        $inputs.each(function(){

            var $input = $(this);
            var attr = $input.attr('required');

            if (typeof attr !== typeof undefined && attr !== false) {

                if( $.trim($input.val()) === '' || $.trim($input.val()) == '0' || $input.is(':disabled')) {

                    $input.css({'border' : '1px solid red'});
                    //$input.parent().append('<p class="red-message">Field required</p>');
                    $input.focus();
                    can_submit = false;
                    return false;
                }
            }
        });

        if( can_submit ) {

            var $formData = new FormData($(this)[0]);
            var $form_btns = $form.find('button');
            var $form_btns2 = $form.find('.modal-footer a');
            var $spinner = $form.find('.fa-spinner');

            $form_btns.hide();
            $form_btns2.hide();
            $spinner.css({'display':'inline-block'});

            var action = !$form.attr('action') ? window.location.href : $form.attr('action');
            var method = !$form.attr('method') ? 'POST' : $form.attr('method');

            $.ajax({
                type        : method,
                url         : action,
                data        : $formData,
                dataType    : "json",
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request

                success     : function(data){

                    $spinner.hide();
                    $('.video-process-message').hide();

                    if( data.status == 'error' ){

                        $form_error.fadeIn('fast');
                        var message = data.message;
                        //console.log(message);
                        if( $.isPlainObject( message ) ) {
                            $form_error.append('<span class="form-errors-top">'+message[Object.keys(message)[0]]+'</span>');
                        } else {
                            $form_error.append('<span class="form-errors-top">'+message+'</span>');
                        }

                        $form_btns.show();
                        $form_btns2.show();

                    } else if( data.status == 'ok' ){

                        $form_success.fadeIn('fast');
                        var msg = data.message;
                        //console.log(msg);
                        $form_success.append('<span class="form-success-top">'+msg+'</span>');
                        $form_btns.show();
                        $form_btns2.show();

                        if( data.found_tutor ) {
                            $form.find('.modal-footer').hide();
                            $form.find('.form-body').fadeOut('fast', function(){
                                var $search_content_wrapper = $form.parent().find('.admin-tutor-search-wrapper');
                                $search_content_wrapper.find('.found-fullname').html('Found <a href="/page/profile/'+data.user_id+'" target="_blank" style="text-decoration:underline;"><b>'+data.fullname+'</b></a>');
                                $search_content_wrapper.find('.add-found-tutor-btn').show();
                                $search_content_wrapper.find('.found-image').show();
                                $search_content_wrapper.find('.found-image').attr('src', data.image);
                                $search_content_wrapper.find('.add-found-tutor-btn').attr('data-user-id', data.user_id);
                                $search_content_wrapper.find('.add-found-tutor-btn').attr('data-user-fullname', data.fullname);
                                $search_content_wrapper.find('.send-tutor-invitation-btn').hide();
                                $search_content_wrapper.fadeIn('fast');
                            });
                        }

                        if( data.tutor_not_found ) {

                            $form.find('.modal-footer').hide();
                            $form.find('.form-body').fadeOut('fast', function(){
                                var $search_content_wrapper = $form.parent().find('.admin-tutor-search-wrapper');
                                $search_content_wrapper.find('.found-fullname').html('<p>User <b>'+data.user_email+'</b> not found. <br><br>You can send them an invitation.</p>');
                                $search_content_wrapper.find('.found-image').hide();
                                $search_content_wrapper.find('.add-found-tutor-btn').hide();
                                $search_content_wrapper.find('.send-tutor-invitation-btn').show();
                                $search_content_wrapper.find('.send-tutor-invitation-btn').attr('data-user-email', data.user_email);
                                $search_content_wrapper.fadeIn('fast');
                            });
                        }

                        if( data.alert ) {
                            alert(data.alert);
                        }

                        if( data.imgsrc ) {
                            $form.find('img').attr('src', data.imgsrc);
                            $('.delete-img-btn').show();
                        }

                        if( action == '/ajax/account/update_avatar' || action == '/ajax/account/remove_avatar' || action == '/ajax/org_admin/update_avatar' || action == '/ajax/org_admin/remove_org_avatar') {
                            $('.dropdown-user img').attr('src', data.imgsrc);
                        }

                        if( data.noreset ) {

                        } else {
                            $form[0].reset();
                        }

                        if( data.hideform ) {
                            $form.find('.modal-body').hide();
                            $form.find('button[type=submit]').hide();
                            $form.find('.upload-file-container').parents('.row').hide();
                        }

                        if( data.remove_submit_btn ) {
                            $form.find('button[type=submit]').remove();
                        }

                        var $file_input_name = $form.find('.file-input-name');
                        if( data.inbox_reply_id ) {
                            $file_input_name.text('Attach');
                        } else {
                            //$file_input_name.text('Update photo');
                        }

                        if(data.lecture_added) {
                            $file_input_name.text('Select video');
                        }

                        $file_input_name.show();

                        if( data.post_id ) {

                            var post = data.post;
                            var profession = post['poster_profession'] ? '<a href="/page/search?q='+post['poster_profession']+'">'+post['poster_profession']+'</a>' : '';
                            var post_img = post['image'] ? '<img src="'+post['image']+'" class="img-responsive">' : '' ;
                            var comma = post['poster_profession'] ? ',':'';
                            var comment_links = '<a href="javascript:;" id="'+post['id']+'" class="bs-feed-comments-link"><i class="fa fa-comments"></i> (<span class="bs-num-comments-count">0</span>)</a>';

                            $('#bs-feed-area-hidden').after('' +
                            '<div class="col-md-12 bs-feed-wrapper post-id-'+post['id']+' u-latest-post" id="'+post['id']+'">' +
                                '<div class="col-md-10 bs-feed-post-section">' +
                                    '<div class="portlet light">' +
                                        '<div class="portlet-title">' +
                                            '<div class="caption bs-feed-title-parent">' +
                                                '<a href="/page/profile/'+post['poster_id']+'">' +
                                                    '<img src="'+post['poster_avatar']+'" class="bs-feed-users-img">' +
                                                '</a>' +
                                                '<p class="bs-feed-poster-info"><a href="/page/profile/'+post['poster_id']+'">'+post['poster_name']+'</a>'+comma+' '+profession+'<br><span class="bs-post-timestamp badge">just now</span></p>'+
                                            '</div>' +
                                            '<div class="tools">' +
                                                '<ul class="nav navbar-right settings-icon-user-profile">' +
                                                    '<li class="dropdown">' +
                                                        '<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-settings"></i></a>' +
                                                        '<ul class="dropdown-menu dropdown-menu-right dropdown-menu-right-mobile">' +
                                                            '<li><a href="/account/edit_post/'+post['id']+'"><i class="icon-pencil"></i> Edit post</a></li>'+
                                                            '<li><a href="/account/feed/'+post['id']+'" class="bs-get-direct-link" id="'+$('#base-url').val()+'account/feed/'+post['id']+'"><i class="fa fa-link"></i> Get direct link</a></li>'+
                                                            '<li><a href="javascript:;" class="bs-delete-post" id="'+post['id']+'"><i class="icon-trash"></i> Delete post</a></li>'+
                                                        '</ul>'+
                                                    '</li>' +
                                                '</ul>' +
                                            '</div>'+
                                        '</div>' +
                                        '<div class="portlet-body">' +
                                            '<p class="bs-feed-summary">'+post['description']+'</p>' +
                                            post_img +
                                            '<div class="margin-top-20"></div>'+
                                            comment_links +
                                        '</div>'+
                                    '</div>' +
                                '</div>'+
                            '</div>');

                            $file_input_name.text('Add image');
                            $file_input_name.show();

                            $('html,body').animate({
                                    scrollTop: $('.bs-feed-wrapper.u-latest-post').offset().top-270},
                                1500, 'easeInOutQuart');
                        }

                        if( data.comment_id ) {

                            var $comment_modal = $('.post-id-'+data.comment_post_id).find('.bs-view-comments-feed-wrapper');
                            var $comments_section = $comment_modal.find('.bs-comments-section .comment-section-inner');
                            var comment = data.comment;

                            $comments_section.prepend('' +
                                '<div class="media u-latest-comment comment-id-'+comment.id+'" id="'+comment.id+'">' +
                                    '<a href="/page/profile/'+comment.poster_id+'" class="pull-left">' +
                                        '<img alt="" src="'+comment.poster_avatar+'" class="media-object">' +
                                    '</a>' +
                                    '<div class="media-body">' +
                                        '<p class="media-heading comments-feed-username bold"><a href="/page/profile/'+comment.poster_id+'" style="text-decoration:none;">'+comment.poster_name+'</a> <span>'+comment.date_created+
                                        '<p>'+comment.comment+'.</p>'+
                                    '</div>'+
                                '</div>'+'<hr>');

                            var comments_count = $('.post-id-'+comment.post_id).find('.bs-num-comments-count');
                            var new_comments_count = parseInt(comments_count.text()) + 1;
                            $('.comments-modal-num-of-comments').text(new_comments_count);
                            comments_count.text( new_comments_count );

                            $comment_modal.find('.post-comment-form').find('.btn-warning').click();

                        }

                        if( data.reply_id ) {

                            var $comment_modal = $('.post-id-'+data.comment_post_id).find('.bs-view-comments-feed-wrapper');
                            var $comments_section = $comment_modal.find('.bs-comments-section .comment-section-inner');
                            var replies = data.comment;

                            $comments_section.find('.comment-id-'+replies.comment_id).find('.media-body:first').after('' +
                            '<div class="media bs-comment-response u-latest-comment" id="'+replies.comment_id+'">' +
                                '<hr>'+
                                '<a href="/page/profile/'+replies.poster_id+'" class="pull-left user-img-link">' +
                                    '<img alt="" src="'+replies.poster_avatar+'" class="media-object">' +
                                '</a>' +
                                '<div class="media-body">' +
                                    '<p class="media-heading comments-feed-username bold"><a href="/page/profile/'+replies.poster_id+'" style="text-decoration:none;">'+replies.poster_name+'</a> <span>'+replies.date_created+
                                    '<p>'+replies.comment+'.</p>'+
                                '</div>'+
                            '</div>');

                            $comments_section.find('.comment-id-'+replies.comment_id).find('form').remove();

                        }

                        if( data.inbox_reply_id ){

                            var inbox_reply = data.inbox_reply;
                            var $inbox_body = $('#bs-inbox-right-body');
                            var inbox_reply_img = inbox_reply.image ? '<div><hr><a href="'+inbox_reply.image+'" class="font-12px" target="_blank"><i class="icon-paper-clip"></i> attachment</a></div>' : '';

                            $inbox_body.append('' +
                            '<div class="col-md-12 u-latest-inbox-reply">' +
                                '<div class="alert alert-info col-md-6" style="margin-left:40px;">' +
                                '<p>'+inbox_reply.description+'</p>' +
                                inbox_reply_img+'<p class="inbox-reply-time">just now</p>'+
                                '</div>' +
                            '</div>');

                            $inbox_body.scrollTop($inbox_body[0].scrollHeight);

                        }

                    }else{

                        if( data.alert ) {
                            alert(data.alert);
                        }
                        if(data.redirect) {
                            window.location = data.redirect;
                        } else {
                            location.reload();
                        }
                    }
                },
                error: function(){
                    $spinner.hide();
                    $form_btns.show();
                    $form_btns2.show();
                    $form_error.fadeIn('fast');
                    $form_error.append('<span class="form-errors-top">Problem submitting your form. Please ensure mandatory field are not empty.</span>');
                },
                complete:function(){
                    //$spinner.hide();
                    //$form_btns.show();
                    //$('body, html').animate({scrollTop:'0px'}, 'slow');
                }
            });
        }
    });
});

function is_json( msg ) {

    var IS_JSON = true;
    try{
        var json = $.parseJSON(msg);
    }catch(err){
        IS_JSON = false;
    }

    return IS_JSON;
}