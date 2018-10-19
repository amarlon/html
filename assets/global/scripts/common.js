/**
 * Created by benshittu on 09/11/15.
 */


/*****************/

$(function(){

    //-----------------
    $('#bs-signup-btn, .bs-signup-btn').on('click', function(e){

        e.preventDefault();

        var $form = $('#signup-form');
        var $select = $form.find('#cities-counties');
        var $spin = $select.parent().find('.fa-spin');
        var $form_error = $select.closest('form').find('.form-error');

        $form_error.find('.form-errors-top').remove();
        $select.empty();
        $spin.css({'display':'inline-block'});

        $.ajax({
            type    : 'get',
            dataType : 'json',
            url     : '/ajax/auth/get_cities_counties',
            success : function(data){
                $select.append('<option selected disabled>Where in Ireland do you live?</option>');
                $.each(data, function(key,value) {
                    $select.append('<option value="'+value.id+'">'+value.name+'</option>');
                });

                $spin.hide();
            },
            error   :   function(xhr, status, error) {
                $spin.hide();
                $form_error.fadeIn('fast');
                $form_error.append('<span class="form-errors-top">Problem loading cities/counties. Try refreshing your browser.</span>');
            }
        });
    });

    //-----------------
    $('#cities-counties').on('change', function(){

        var $form = $(this).parents('form');
        var $city_area = $form.find('#city-area');
        var $select = $city_area.find('select');
        var $spin = $city_area.find('.fa-spin');
        var $form_error = $city_area.closest('form').find('.form-error');

        $form_error.find('.form-errors-top').remove();
        $select.empty();
        $spin.css({'display':'inline-block'});

        var message = {'city_county_id' : $(this).val() };

        $.ajax({
            type    : 'post',
            data    : message,
            dataType : 'json',
            url     : '/ajax/auth/get_city_county_areas',
            success : function(data){

                $select.append('<option selected disabled>Select your area</option>');

                $.each(data, function(key,value) {
                    //console.log(value.name);
                    $select.append('<option value="'+value.id+'">'+value.name+'</option>');
                });

                $spin.hide();

            },
            error   :   function(xhr, status, error) {
                //alert(xhr.responseText);
                $spin.hide();
                $form_error.fadeIn('fast');
                $form_error.append('<span class="form-errors-top">Problem loading subcategories. Try refreshing your browser.</span>');
            }
        });
    });

});

/*****************/

$(function(){

    //-----------------
    $('.bs-hide-post').on('click', function(){

        var $this = $(this);
        var message = {'post_id' : $this.attr('id') };
        var $wrapper = $this.parents('.bs-feed-wrapper');
        $wrapper.addClass('bs-hidden-post');
        $wrapper.removeClass('bs-unhide-hidden-post');
        $wrapper.find('.hide-post-li').hide();
        $wrapper.find('.unhide-post-li').show();
        //$wrapper.addClass('hidden-post-opacity');

        var $num_hidden_posts = $('#num-of-hidden-posts');
        $num_hidden_posts.text( parseInt($num_hidden_posts.text()) + 1 );

        var $toggle_all_link = $('.bs-hide-hidden-posts');
        $toggle_all_link.addClass('bs-show-hidden-posts');
        $toggle_all_link.removeClass('bs-hide-hidden-posts');
        $toggle_all_link.text('show');

        $num_hidden_posts.parent().fadeIn('fast');

        $.ajax({
            type    : 'post',
            data    : message,
            dataType : 'json',
            url     : '/ajax/account/hide_post',
            success : function(data){},
            error   :   function(xhr, status, error) {}
        });

    });

    //-----------------
    $('.bs-unhide-post').on('click', function(){

        var $this = $(this);
        var message = {'post_id' : $this.attr('id') };
        var $wrapper = $this.parents('.bs-feed-wrapper');
        $wrapper.addClass('bs-unhide-hidden-post');
        $wrapper.removeClass('bs-hidden-post');
        $wrapper.find('.unhide-post-li').hide();
        $wrapper.find('.hide-post-li').show();
        //$wrapper.removeClass('hidden-post-opacity');

        var $num_hidden_posts = $('#num-of-hidden-posts');
        $num_hidden_posts.text( parseInt($num_hidden_posts.text()) - 1 );

        var $toggle_all_link = $('.bs-hide-hidden-posts');
        $toggle_all_link.addClass('bs-show-hidden-posts');
        $toggle_all_link.removeClass('bs-hide-hidden-posts');
        $toggle_all_link.text('show');

        if( parseInt($num_hidden_posts.text()) <= 0 ) {
            $num_hidden_posts.parent().fadeOut('fast');
        }

        $.ajax({
            type    : 'post',
            data    : message,
            dataType : 'json',
            url     : '/ajax/account/unhide_post',
            success : function(data){},
            error   :   function(xhr, status, error) {}
        });

    });

    //-----------------
    $('.bs-delete-post').live('click', function(){

        var $this = $(this);

        bootbox.confirm("Delete forever?", function(result) {
            if( result ) {
                var message = {'post_id' : $this.attr('id') };
                $this.parents('.bs-feed-wrapper').fadeOut();

                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/delete_post',
                    success : function(data){},
                    error   :   function(xhr, status, error) {}
                });
            }
        });


    });

    $('#bs-hide-default-post').on('click', function(){

        $(this).parents('.bs-feed-wrapper').fadeOut();

        $.ajax({
            type    : 'post',
            dataType : 'json',
            url     : '/ajax/account/hide_default_post',
            success : function(data){},
            error   :   function(xhr, status, error) {}
        });

    });

    //-----------------
    $('.bs-get-direct-link').live('click', function(){
        //var $alert_modal = $('#bs-alert-modal');
        //var link = $(this).attr('id');
        //$alert_modal.find('.modal-title span').text(' Direct link');
        //$alert_modal.find('.modal-body').html('<p><a href="'+link+'">'+link+'</a></p>');
        //window.prompt("Copy to clipboard: Ctrl+C, Enter", link);
        //$alert_modal.modal('show');
    });

    $('.bs-show-hidden-posts').live('click', function(e){

        event.preventDefault();

        var $this = $(this);
        $this.removeClass('bs-show-hidden-posts');
        $this.addClass('bs-hide-hidden-posts');
        $this.text('hide');
        $('.bs-hidden-post').addClass('bs-unhide-hidden-post');

    });

    $('.bs-hide-hidden-posts').live('click', function(e){

        event.preventDefault();

        var $this = $(this);
        $this.addClass('bs-show-hidden-posts');
        $this.removeClass('bs-hide-hidden-posts');
        $this.text('show');
        $('.bs-hidden-post').removeClass('bs-unhide-hidden-post');

    });

});

/*****************/
$(function(){

    $('#bs-new-member-link-login-form').on('click', function(e){
        e.preventDefault();
        $('#bs-login-modal').modal('hide');
        $('#bs-signup-btn').click();
    });

    $('#bs-already-member-link-signup-form').on('click', function(e){
        e.preventDefault();
        $('#bs-signup-modal').modal('hide');
        $('#bs-login-modal').modal('show');
    });

    $('.alert .close').on('click', function(e){
        e.preventDefault();
       $(this).parent().hide();
    });

    $('#bs-search-modal').on('shown.bs.modal', function () {
        $(this).find('input').focus();
    });

});

/*****************/
$(function(){

    $('.global-search-arrow-right').on('click', function(){
        $(this).closest('form').submit();
    });

    $('.global-search-form').on('submit', function(e){
        $val = $(this).find('input').val();
        if( $val.length < 2 ) {
            alert('Please enter 2 or more characters');
            e.preventDefault();
        }
    });

    $('.upload-video-container, .upload-file-container').on('change', function(){
        var $that = $(this);
        $that.parents('form').find('.upload-btn-hidden.hide-elem').show();
        var $input = $(this).find('input');
        var $input_name_elem = $(this).find('.file-input-name');
        $input_name_elem.text($input.val().split('\\').pop());
        $input_name_elem.show();
        $input_name_elem.append(' <a href="javascript:;" class="clear-img-upload"><b>remove</b></a>');

        if( $that.hasClass('upload-video-container') ) {
            $('.video-process-message').fadeIn('slow');
        }

        //$input.attr('data-original-title', 'Change image');

        $('.clear-img-upload').on('click', function(e){
            e.preventDefault();
            var $input_name_elem = $that.find('.file-input-name');
            $input_name_elem.empty();
            $input_name_elem.hide();
            resetFormElement($input);
            //$input.attr('data-original-title', 'Add image');
        });
    });

    function resetFormElement(e) {
        e.wrap('<form>').closest('form').get(0).reset();
        e.unwrap();
    }

    $('.clear-previous-upload').on('click', function(e){
        var $input = $(this).closest('input');
        e.preventDefault();
        var $input_name_elem = $('.file-input-name');
        $input_name_elem.empty();
        $input_name_elem.hide();
        resetFormElement($input);
        //$input.attr('data-original-title', 'Add image');
    });

});

$(function(){

    $('input[type=file]').on('change', function(){
        $(this).parents('form').find('.hide-save-button').removeClass('hide-save-button');
    });

});

/*****************/
$(function(){

    $('#bs-post-category-select').on('change', function(){

        var $this = $(this);
        var $category_date_wrapper = $('#bs-post-category-date');

        if( $this.val() == 4 ) {
            $category_date_wrapper.show();
            $category_date_wrapper.find('input').prop('required', true);
        } else {
            $category_date_wrapper.hide();
            $category_date_wrapper.find('input').prop('required', false);
        }

    });

    $('.delete-img-btn').on('click', function(e){

        e.preventDefault();
        var $this = $(this);
        var message = '';

        bootbox.confirm("Delete forever?", function(result) {
            if( result ) {

                var url = '';
                if( $this.hasClass('delete-avatar') ) {
                    url = '/ajax/account/remove_avatar';
                } else if( $this.hasClass('delete-post-img') ) {
                    url = '/ajax/account/remove_post_img';
                    message = {'post_id' : $this.parents('form').find('#post-id').val() };
                } else if( $this.hasClass('delete-article-img') ) {
                    url = '/ajax/account/remove_article_image';
                    message = {'article_id' : $this.parents('form').find('#article-id').val() };
                } else if( $this.hasClass('delete-lesson-doc') ) {
                    url = '/ajax/org_tutor/remove_lesson_doc';
                    message = {'organisation_id' : $this.parents('form').find('#organisation-id').val(), 'lesson_id' : $this.parents('form').find('#lesson-id').val() };
                } else if( $this.hasClass('delete-lecture-vid') ) {
                    url = '/ajax/org_tutor/remove_lecture_vid';
                    message = {'organisation_id' : $this.attr('data-organisation-id'), 'lesson_id' : $this.attr('data-lesson-id'), 'video_id' : $this.attr('data-video-id'), 'vid_public_id' : $this.attr('data-vid-public-id') };
                } else if( $this.hasClass('delete-course-intro-video') ) {
                    url = '/ajax/org_admin/remove_course_intro_video';
                    message = {'organisation_id' : $this.parents('form').find('#organisation-id').val(), 'course_id' : $this.parents('form').find('#course-id').val() };
                } else if( $this.hasClass('delete-profile-intro-video') ) {
                    url = '/ajax/org_admin/remove_profile_intro_video';
                    message = {'organisation_id' : $this.parents('form').find('.organisation-id').val() };
                } else if( $this.hasClass('delete-org-avatar') ) {
                    url = '/ajax/org_admin/remove_org_avatar';
                    message = {'organisation_id' : $this.parents('form').find('#organisation-id').val()};
                }

                $this.removeClass('delete-img-btn');
                $this.text('Please wait...');
                $this.parents('.videos-grid').hide();

                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : url,
                    success : function(data){
                        if( data.status == 'error' ) {
                            alert(data.message);
                            $this.parents('.videos-grid').show();
                        } else {
                            $this.parents('form').find('img').attr('src', data.imgsrc);
                            $this.hide();
                            $this.parents('form').find('.file-input-name').text('Attach');
                        }

                        if( url == '/ajax/account/remove_avatar' ) {
                            $('.dropdown-user img').attr('src', data.imgsrc);
                        }

                    },
                    error   :   function(xhr, status, error) {
                        alert('Problem communicating with server. Try again in a little bit.');
                        $this.addClass('delete-img-btn');
                        $this.text('Remove');
                        $this.parents('.videos-grid').show();
                    }
                });

            }
        });

    });

    $('.deactivate-account-form').on('submit', function(e){

        e.preventDefault();
        var $this = $(this);
        var $button = $(this).find('button');
        var message = {'curr_password' : $this.find('#curr_password_deactivate').val() };

        bootbox.confirm("De-activate your account?", function(result) {
            if( result ) {

                $button.text('Please wait...');

                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/deactivate_account',
                    success : function(data){
                        alert(data.message);
                        location.reload();
                    },
                    error   :   function(xhr, status, error) {
                        alert('Problem communicating with server. Try again in a little bit.');
                        $button.text('De-activate my account');
                    }
                });

            }
        });

    });

    $('.enrol-course-btn').on('click', function(e){

        e.preventDefault();
        var $this = $(this);
        var $button = $(this);
        var message = {'course_id' : $this.attr('id') };

        bootbox.confirm("Enrol?", function(result) {
            if( result ) {

                $button.html('<i class="fa fa-spinner fa-spin" style="display:inline-block;"></i> Please wait');

                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/enrol',
                    success : function(data){

                        if( data.status == 'error' ) {
                            alert(data.message);
                            $button.html('<i class="fa fa-graduation-cap"></i> Enrol');
                        }

                        location.reload();
                    },
                    error   :   function(xhr, status, error) {
                        alert('Problem communicating with server. Try again in a little bit.');
                        $button.html('<i class="fa fa-graduation-cap"></i> Enrol');
                    }
                });

            }
        });

    });

    $('.unenroll-course-btn').on('click', function(){

        var $button = $(this);
        var message = {'course_id' : $button.attr('id') };

        bootbox.confirm("Are you sure you want to leave this course?", function(result) {
            if( result ) {

                $button.html('<i class="fa fa-spinner fa-spin" style="display:inline-block;"></i> Please wait');

                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/unenroll',
                    success : function(data){

                        if( data.status == 'error' ) {
                            alert(data.message);
                            $button.html('<i class="fa fa-times"></i> Leave course');
                        }

                        location.reload();
                    },
                    error   :   function(xhr, status, error) {
                        alert('Problem communicating with server. Try again in a little bit.');
                        $button.html('<i class="fa fa-times"></i> Leave course');
                    }
                });

            }
        });

    });

    $('.resend-email-verification-btn').on('click', function(e){

        e.preventDefault();

        var $button = $(this);
        $button.text('Please wait...');
        $button.removeClass('resend-email-verification-btn');

        $.ajax({
            type    : 'post',
            dataType : 'json',
            url     : '/ajax/account/resend_verification_email',
            success : function(data){
                $button.text('Verify my email');
                $button.addClass('resend-email-verification-btn');
                alert(data.message);
            },
            error   :   function(xhr, status, error) {
                $button.text('Verify my email');
                $button.addClass('resend-email-verification-btn');
                alert('Problem communicating with server. Try again in a little bit.');
            }
        });

    });

});

/*****************/
$(function(){

    if( $('#bs-auto-msg-modal').length ) {
        $('#bs-msg-user-modal').modal('show');
    }

    if( $('#bs-first-time-user').length ) {
        $('#bs-first-time-modal').modal('show');

        $.ajax({
            type    : 'post',
            dataType : 'json',
            url     : '/ajax/account/first_intro_completed',
            success : function(data){},
            error   :   function(xhr, status, error) {}
        });
    }

});

/*****************/
$(function(){

    var $click_tab = $('#bs-click-tab');

    if( $click_tab.length ) {

        $('.'+$click_tab.val()).click();

    }

});

$(function(){

    var lastScrollTop = 0;
    var $page_header_menu = $('.page-header-menu');

    $(window).scroll(function(event){
        var st = $(this).scrollTop();
        if (st > lastScrollTop || st < 80){
            $page_header_menu.removeClass('fixed-page-header-menu');
        } else {
            if( !$page_header_menu.hasClass('fixed-page-header-menu') ) {
                $page_header_menu.addClass('fixed-page-header-menu');
            }
        }
        lastScrollTop = st;
    });

});

$(function(){

    var $feed_comments_link = $('.bs-feed-comments-link');
    var total_comments = 0;

    //load comments
    $feed_comments_link.live('click', function(e){

        e.preventDefault();

        var $this = $(this);
        $this.removeClass('bs-feed-comments-link');
        $this.addClass('bs-feed-hide-comments-link');

        var post_id = $this.attr('id');

        var $comment_modal = $this.parents('.bs-feed-post-section').find('.bs-view-comments-feed-wrapper');
        var $comments_section = $comment_modal.find('.bs-comments-section .comment-section-inner');
        var $comment_input = $comment_modal.find('.bs-comment-textarea');
        var $spin = $comments_section.parent().find('.fa-refresh');

        var $form_error = $comment_modal.find('.form-error');
        var $form_success = $comment_modal.find('.form-success');

        //$comment_modal.find('.post-comment-form .hidden-input-post-id').val( post_id );
        var post_title = $(this).parents('.bs-feed-post-section').find('.bs-feed-title').text().split('-');

        //$comment_modal.find('.comments-post-title').html('<i class="fa fa-comments"></i>'+post_title[1] );
        $comments_section.empty();
        $form_error.find('.form-errors-top').remove();
        $form_error.hide();
        $form_success.find('.form-success-top').remove();
        $form_success.hide();

        $spin.css({'display':'inline-block'});

        $.ajax({
            type    : 'get',
            dataType : 'json',
            url     : '/ajax/account/get_post_comments/'+post_id,
            success : function( data ) {

                if( data.status == 'error' ) {

                    $spin.hide();
                    $comment_input.focus();
                    $form_error.fadeIn('fast');
                    $form_error.find('.form-errors-top').remove();
                    $form_error.append('<span class="form-errors-top">'+data.message+'</span>');

                    return false;

                }

                total_comments = data.length;

                $.each(data, function(index, comment) {

                    var reply = comment.poster_id == $('#user-id').val() ? '' : ' / <a href="javascript:;" data-comment-id="'+comment.id+'" data-poster-id="'+comment.poster_id+'" data-poster-name="'+comment.poster_name+'" class="bs-reply-comment-btn">Reply </a>';
                    var delete_comment_btn = comment.poster_id == $('#user-id').val() ? ' | <a href="javascript:" class="js-delete-feed-comment" data-comment-id="'+comment.id+'"><i class="fa fa-trash"></i></a>' : '';

                    total_comments += comment.num_of_replies;

                    $comments_section.append('' +
                        '<div class="media comment-id-'+comment.id+'" id="'+comment.id+'">' +
                            '<a href="/page/profile/'+comment.poster_id+'" class="pull-left">' +
                                '<img alt="" src="'+comment.poster_avatar+'" class="media-object">' +
                            '</a>' +
                            '<div class="media-body">' +
                                '<p class="media-heading comments-feed-username bold"><a href="/page/profile/'+comment.poster_id+'" style="text-decoration:none;">'+comment.poster_name+'</a> <span>'+comment.date_created+' ago'+reply+'</span>'+delete_comment_btn+'</p>' +
                                '<p>'+comment.comment+'.</p>'+
                            '</div>'+
                        '</div>'+'<hr>');

                    $.each(comment.replies, function(index2, replies) {

                        var reply_to_response = replies.from_user_id == $('#user-id').val() ? '' : ' / <a href="javascript:;" data-comment-id="'+replies.comment_id+'" data-poster-id="'+replies.from_user_id+'" data-poster-name="'+replies.poster_name+'" class="bs-reply-comment-btn">Reply </a>';
                        var delete_comment_reply_btn = replies.from_user_id == $('#user-id').val() ? ' | <a href="javascript:" class="js-delete-feed-comment-reply" data-comment-reply-id="'+replies.id+'"><i class="fa fa-trash"></i></a>' : '';

                        $comments_section.find('.comment-id-'+replies.comment_id).append('' +
                            '<div class="media bs-comment-response" id="'+replies.comment_id+'">' +
                                '<hr>'+
                                '<a href="/page/profile/'+replies.poster_id+'" class="pull-left user-img-link">' +
                                    '<img alt="" src="'+replies.poster_avatar+'" class="media-object">' +
                                '</a>' +
                                '<div class="media-body">' +
                                    '<p class="media-heading comments-feed-username bold"><a href="/page/profile/'+replies.poster_id+'" style="text-decoration:none;">'+replies.poster_name+'</a> <span>'+replies.date_created+' ago'+reply_to_response+'</span> '+delete_comment_reply_btn+'</p>' +
                                    '<p>'+replies.comment+'.</p>'+
                                '</div>'+
                            '</div>');
                    });
                });

                $('.js-delete-feed-comment').on('click', function(e){
                    e.preventDefault();
                    var $this = $(this);
                    bootbox.confirm("This action cannot be undone. All comment replies will also be deleted.<br><br><b>Delete comment?</b>", function(result) {
                        if( result ) {
                            $this.parents('.media').remove();
                            var message = {
                                'comment_id' : $this.attr('data-comment-id')
                            };

                            $.ajax({
                                type    : 'post',
                                data    : message,
                                dataType : 'json',
                                url     : '/ajax/account/delete_feed_comment',
                                success : function(data){

                                },
                                error   :   function(xhr, status, error) {
                                    alert('Oops! Problem communicating with server. Try again in a little bit.');
                                }
                            });
                        }
                    });
                });

                $('.js-delete-feed-comment-reply').on('click', function(e){
                    e.preventDefault();
                    var $this = $(this);
                    bootbox.confirm("This action cannot be undone.<br><br><b>Delete comment?</b>", function(result) {
                        if( result ) {
                            $this.parents('.bs-comment-response').remove();
                            var message = {
                                'comment_reply_id' : $this.attr('data-comment-reply-id')
                            };

                            $.ajax({
                                type    : 'post',
                                data    : message,
                                dataType : 'json',
                                url     : '/ajax/account/delete_feed_comment_reply',
                                success : function(data){

                                },
                                error   :   function(xhr, status, error) {
                                    alert('Oops! Problem communicating with server. Try again in a little bit.');
                                }
                            });
                        }
                    });
                });

                $spin.hide();
            },
            error   :   function(xhr, status, error) {

                alert('Problems loading comment. Try again in a little bit.');
                $spin.hide();

            }
        });

    });

    $('.bs-reply-comment-btn').live('click', function(){

        var $this = $(this);
        var post_id = $this.parents('.bs-feed-wrapper').find('.hidden-input-bs-post-id').val();
        var comment_id = $this.attr('data-comment-id');
        var to_user_id = $this.attr('data-poster-id');
        var poster_name = '@'+$this.attr('data-poster-name')+ ' - ';
        var $wrapper = $this.parents('.media-body');

        $wrapper.find('form').remove();

        $wrapper.after('' +
        '<form role="form" action="/ajax/account/reply_comment" class="form-ajax" enctype="multipart/form-data">' +
            '<div class="form-body">' +
                '<div class="form-group">' +
                    '<textarea name="comment" id="bs-reply-comment-textarea" class="form-control" rows="3" placeholder="Add a comment..." required="">'+poster_name+' </textarea>' +
                    '<input type="hidden" name="comment_id" value="'+comment_id+'">'+
                    '<input type="hidden" name="to_user_id" value="'+to_user_id+'">'+
                    '<input type="hidden" name="post_id" value="'+post_id+'">'+
                '</div>' +
            '</div>'+
            '<div class="row bs-reply-form-btn-wrapper" style="text-align:right;">' +
                '<div class="col-md-12">' +
                    '<div class="alert alert-danger form-error display-hide" style="text-align:left;">' +
                        '<a href="" class="close" data-close="alert"></a>' +
                        '<span></span>' +
                    '</div>'+
                    '<button type="button" class="btn btn-warning bs-cancel-reply-btn" style="margin-right: 5px;">Cancel</button>' +
                    '<button type="submit" class="btn btn-primary">Post</button>'+
                '</div>' +
            '</div>'+
        '</form>');

        $('#bs-reply-comment-textarea').focus().val(poster_name);

    });

    $('.bs-comment-textarea').on('focus', function(){
        var $this = $(this);
        $this.parents('form').find('.bs-post-comment-btn-wrapper').fadeIn('fast');
        $this.attr('rows', '3');
    });

    $('.bs-cancel-comment-btn').on('click', function(e){
        e.preventDefault();
        var $this = $(this);
        $this.parents('form').find('.bs-post-comment-btn-wrapper').hide();
        $this.parents('form').find('.bs-comment-textarea')
            .val('')
            .attr('rows', '2');
    });

    $('.bs-cancel-reply-btn').live('click', function(){
        $(this).parents('form').remove();
    });

    $('.bs-feed-hide-comments-link').live('click', function(){
        var $this = $(this);
        var $comment_modal = $this.parents('.bs-feed-post-section').find('.bs-view-comments-feed-wrapper');
        var $comments_section = $comment_modal.find('.bs-comments-section .comment-section-inner');
        $comments_section.empty();
        $this.removeClass('bs-feed-hide-comments-link');
        $this.addClass('bs-feed-comments-link');
    });

});

$(function(){

    var $autoshowcomments = $('#autoshowcomments');

    if( $autoshowcomments.length ) {
        $('.bs-feed-comments-link').click();
        $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    }

});

$(function(){

    var $lesson_desc = $('#lesson-desc');
    var placeholder = 'Lesson description, e.g...\n\nLecture 1 title\nLecture 2 title';
    $lesson_desc.attr('value', placeholder);

    $lesson_desc.focus(function(){
        if($(this).val() === placeholder){
            $(this).attr('value', '');
        }
    });

    $lesson_desc.blur(function(){
        if($(this).val() ===''){
            $(this).attr('value', placeholder);
        }
    });

    var $add_lecture_form = $('.add-lecture-form');

    $('#add-lecture-btn').on('click', function(e){
        e.preventDefault();
        $(this).fadeOut('fast');
        $add_lecture_form.fadeIn('fast');
    });

    var $question_input_row = $('.question-input-row');
    var $questions_input_row_wrapper = $('.questions-input-row-wrapper');
    var $submit_question_btn_row = $('.submit-questions-btn-row');

    $('#add-question-btn').on('click', function(e){
        e.preventDefault();
        var $form = $question_input_row.clone();
        $form.find('input, textarea').val('');
        $form.find('.remove-question-btn').show();
        $questions_input_row_wrapper.append($form);
        $questions_input_row_wrapper.append('<hr>');
        $submit_question_btn_row.show();
    });

    $('.remove-question-btn').live('click', function(e){
        e.preventDefault();
        var $this = $(this);
        var $parent = $this.parents('.question-input-row');
        $parent.next('hr').remove();
        $parent.remove();

        if( !$.trim( $questions_input_row_wrapper.html() ).length ) {
            $submit_question_btn_row.hide();
        }

    });

});

$(function(){

    var $answers_input_wrapper_inner = $('.answers-input-wrapper-inner');

    $('.add-answers-btn').on('click', function(e){

        e.preventDefault();

        var $this = $(this);
        var question_id = $this.attr('id');
        var $new_answer_wrapper = $answers_input_wrapper_inner.clone();
        $new_answer_wrapper.removeClass('answers-input-wrapper-inner');
        $new_answer_wrapper.find('input[type=text]').attr('name', 'questions[answers]['+question_id+'][text][]');
        var $input_check = $new_answer_wrapper.find('input[type=checkbox]');
        var $input_hidden = $new_answer_wrapper.find('input[type=hidden]');
        $input_check.attr('name', 'questions[answers]['+question_id+'][is_correct][]');
        $input_hidden.attr('name', 'questions[answers]['+question_id+'][is_correct][]');

        //adding answers
        $input_check.live('click', function(){
            var $input = $(this);
            if($input.is(':checked')) {
                $input.parent().find('input[type=hidden]').prop('disabled', true);
            } else {
                $input.parent().find('input[type=hidden]').prop('disabled', false);
            }
        });

        $this.parent().find('.answers-input-wrapper').append($new_answer_wrapper);
        $new_answer_wrapper.show();

    });

    $('.remove-answer-input-btn').live('click', function(e){

        e.preventDefault();

        var $this = $(this);
        $this.parent().parent().remove();

    });


    //updating answers
    $('.input-checkbox-show').on('click', function(){
        var $input = $(this);
        if($input.is(':checked')) {
            $input.parent().find('input[type=hidden]').prop('disabled', true);
        } else {
            $input.parent().find('input[type=hidden]').prop('disabled', false);
        }
    });

});

$(function(){
    var hash = window.location.hash;
    hash && $('ul.nav a[href="' + hash + '"]').tab('show');

    $('.nav-tabs a').click(function (e) {
        $(this).tab('show');
        var scrollmem = $('body').scrollTop();
        window.location.hash = this.hash;
        $('html,body').scrollTop(scrollmem);
    });
});

$(function(){

    $('.enable-course-enrolment-btn').on('click', function(e){

        e.preventDefault();

        var $this = $(this);
        var $spin = '<i class="fa fa-spinner fa-spin"></i>';
        $this.html($spin);
        $this.find('i').css({'display': 'inline-block'});
        $this.find('i').show();

        var message = {'course_id' : $(this).attr('id') };

        $.ajax({
            type    : 'post',
            data    : message,
            dataType : 'json',
            url     : '/ajax/org_admin/enable_course_enrolment',
            success : function(data){

                if( data.status == 'error' ) {
                    alert(data.message);
                    $this.html('CLICK HERE');
                    return false;
                }

                location.reload();

            },
            error   :   function(xhr, status, error) {
                alert('Problem activating course. Try again in a little bit.');
                $this.html('CLICK HERE');
            }
        });

    });

});

$('.remove-organisation-user').on('click', function(e){

    e.preventDefault();

    var $this = $(this);
    var $spinner = $this.parents('tr').find('.fa-spinner');

    bootbox.confirm("When you remove a user, any courses they're currently tutoring within your organisation will be automatically assigned to you.<br><br><b>Remove user?</b>", function(result) {
        if( result ) {
            var message = {'tutor_id' : $this.attr('data-tutor-id'), 'organisation_id' : $this.attr('data-organisation-id') };
            $this.hide();
            $spinner.css({'display':'inline-block'});

            $.ajax({
                type    : 'post',
                data    : message,
                dataType : 'json',
                url     : '/ajax/org_admin/remove_organisation_user',
                success : function(data){
                    if( data.status == 'ok' ) {
                        $this.parents('tr').fadeOut();
                    } else {
                        alert(data.message);
                        $this.show();
                        $spinner.hide();
                    }
                },
                error   :   function(xhr, status, error) {
                    alert('Problem communicating with server. Try again in a little bit.');
                    $this.show();
                    $spinner.hide();
                }
            });
        }
    });
});

$(function(){

    $('.add-found-tutor-btn').on('click', function(e){

        e.preventDefault();

        var $this = $(this);
        var $cancel_btn = $this.parent().find('.cancel-found-tutor-btn');
        var $spinner = $this.parent().find('.fa-spinner');

        var message = {
            'user_id' : $this.attr('data-user-id'),
            'organisation_id' : $this.attr('data-organisation-id'),
            'fullname' : $this.attr('data-user-fullname')
        };

        $this.hide();
        $cancel_btn.hide();
        $spinner.css({'display':'inline-block'});

        $.ajax({
            type    : 'post',
            data    : message,
            dataType : 'json',
            url     : '/ajax/org_admin/add_organisation_user',
            success : function(data){
                if( data.status == 'ok' ) {
                    location.reload();
                } else {
                    alert(data.message);
                    $this.show();
                    $cancel_btn.show();
                    $spinner.hide();
                }
            },
            error   :   function(xhr, status, error) {
                alert('Problem communicating with server. Try again in a little bit.');
                $this.show();
                $cancel_btn.show();
                $spinner.hide();
            }
        });

    });

    $('.cancel-found-tutor-btn').on('click', function(){
        var $this = $(this);
        $this.parents('.admin-tutor-search-wrapper').hide();
        $this.parents('.modal-content').find('.form-body').fadeIn();
        $this.parents('.modal-content').find('.modal-footer').fadeIn();
    });
});

$(function(){

    $('.send-tutor-invitation-btn').on('click', function(){

        var $this = $(this);
        var $cancel_btn = $this.parent().find('.cancel-found-tutor-btn');
        var $spinner = $this.parent().find('.fa-spinner');

        var message = {
            'email' : $this.attr('data-user-email'),
            'organisation_id' : $this.attr('data-organisation-id')
        };

        $this.hide();
        $cancel_btn.hide();
        $spinner.css({'display':'inline-block'});

        $.ajax({
            type    : 'post',
            data    : message,
            dataType : 'json',
            url     : '/ajax/org_admin/invite_organisation_user',
            success : function(data){
                if( data.status == 'ok' ) {
                    location.reload();
                } else {
                    alert(data.message);
                    $this.show();
                    $cancel_btn.show();
                    $spinner.hide();
                }
            },
            error   :   function(xhr, status, error) {
                alert('Problem communicating with server. Try again in a little bit.');
                $this.show();
                $cancel_btn.show();
                $spinner.hide();
            }
        });

    });

});


$(function(){

    $('.certify-btn').on('click', function(e){

        e.preventDefault();

        var $this = $(this);
        var $failed_btn = $this.parents('tr').find('.failed-course-btn');
        var $spinner = $this.parent().find('.fa-spinner');

        bootbox.confirm("<p>Student will be informed by email that they have passed the course. <span class='text-red'>This action cannot be undone</span>. <br><br><b>Approve certification?</b></p>", function(result) {
            if( result ) {
                var message = {
                    'student_id' : $this.attr('data-student-id'),
                    'course_id' : $this.attr('data-course-id'),
                    'organisation_id' : $this.attr('data-organisation-id')
                };

                $this.hide();
                $failed_btn.hide();
                $spinner.css({'display':'inline-block'});

                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/org_tutor/certify',
                    success : function(data){

                        if( data.status == 'error' ){
                            alert(data.message);
                            $spinner.hide();
                            $this.show();
                            $failed_btn.show();
                        } else {
                            $this.parent().html('<p class="bold theme-font"><i class="fa fa-check-circle"></i> Certified</p>');
                            $failed_btn.parent().html('<p class="bold theme-font"><i class="fa fa-check-circle"></i> Passed</p>');
                            $('.failed-course-text').parent().html('<p class="bold theme-font"><i class="fa fa-check-circle"></i> Passed</p>');
                        }


                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Please try again shortly.');
                        $spinner.hide();
                        $this.show();
                        $failed_btn.show();
                    }
                });
            }
        });

    });


    $('.failed-course-btn').on('click', function(e){

        e.preventDefault();

        var $this = $(this);
        var $certify_btn = $this.parents('tr').find('.certify-btn');
        var $spinner = $this.parent().find('.fa-spinner');

        bootbox.confirm("<p>Student will be informed by email that they have not passed this course. You can later approve a certification for this student if there is dispute. <br><br><b>Continue?</b></p>", function(result) {
            if( result ) {
                var message = {
                    'student_id' : $this.attr('data-student-id'),
                    'course_id' : $this.attr('data-course-id'),
                    'organisation_id' : $this.attr('data-organisation-id')
                };

                $this.hide();
                $certify_btn.hide();
                $spinner.css({'display':'inline-block'});

                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/org_tutor/failed_course',
                    success : function(data){

                        if( data.status == 'error' ){
                            alert(data.message);
                            $spinner.hide();
                            $this.show();
                            $certify_btn.show();
                        } else {
                            $this.parent().html('<p class="bold text-red failed-course-text"><i class="fa fa-times"></i> Failed</p>');
                            $certify_btn.show();
                        }


                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Please try again shortly.');
                        $spinner.hide();
                        $this.show();
                        $certify_btn.show();
                    }
                });
            }
        });

    });

});

$(function(){

    if( $('#download-cert-hidden').length && $('.cert-img').length ){
        var $cert_container = $('.cert-container');
        var $body = $('body');
        var $message_section = $('.cert-message-section');

        $message_section.hide();
        $body.html($cert_container);

        $('.certificate-fullname').css({'top':'47%'});
        $('.certificate-organisation-name').css({'top':'56%'});
        $('.certificate-course-title').css({'top':'67%'});

        $('.js-cert-wrapper').removeClass('hide-elem');
        $('.js-generate-cert').hide();

        html2canvas(document.body, {
            onrendered: function(canvas) {


                $cert_container.hide();
                //$('.js-generate-cert').hide();
                $body.css({'text-align':'center'});
                document.body.appendChild(canvas);
                $body.prepend('<a href="javascript:" id="downloadLnk" class="btn btn-primary btn-large" download="hotshi_certificate.png" style="margin:20px 0;"><i class="fa fa-save"></i> Save to computer</a>');
                function download() { this.href = canvas.toDataURL('image/png');}
                downloadLnk.addEventListener('click', download, false);

            }
            //width: 300,
            //height: 300
        });

    }
});

$(function(){

    $('.student-tests-list').on('change', function(){
        var $this = $(this);
        var lesson_id = $this.val();
        var course_id = $this.parent().find('.course-id-hidden').val();
        var student_id = $this.attr('data-student-id');
        window.location = '/org_tutor/grade_lesson_test/'+course_id+'/'+lesson_id+'/'+student_id;
        return false;
    });

});

$(function(){

    $('.grade-student-btn').on('click', function(e){

        e.preventDefault();

        var $this = $(this);
        var grade = $this.attr('data-grade');
        var $spinner = $this.parent().find('.fa-spinner');
        var $tutor_comment = $('#tutor_comment');
        var $pass_fail_section = $('.student-pass-fail-section-top');

        if( grade != 'pass' ) {
            grade = 'fail';
        }

        bootbox.confirm("<p>You're about to mark this test as <b>"+grade.toUpperCase()+"</b>. <br><br><span class='text-red'>This action cannot be undone</span>. <br><br><b>Continue?</b></p>", function(result) {
            if( result ) {
                var message = {
                    'student_id' : $this.attr('data-student-id'),
                    'course_id' : $this.attr('data-course-id'),
                    'organisation_id' : $this.attr('data-organisation-id'),
                    'lesson_id' : $this.attr('data-lesson-id'),
                    'grade' : grade,
                    'tutor_comment' : $tutor_comment.val()
                };

                $('.grade-student-btn').hide();
                $spinner.css({'display':'inline-block'});

                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/org_tutor/grade_lesson_test',
                    success : function(data){

                        if( data.status == 'error' ){
                            alert(data.message);
                            $spinner.hide();
                            $('.grade-student-btn').show();
                        } else {

                            if( grade == 'pass' ) {
                                $this.parent().html('<p class="bold text-green"><i class="fa fa-check-circle"></i> Passed</p> <p><a href="javascript:history.back()" class="underline">Go back</a></p>');
                                $pass_fail_section.append('<br><span class="text-green font-13px bold"><i class="fa fa-check-circle"></i> Passed</span>');
                            } else {
                                $this.parent().html('<p class="bold text-red"><i class="fa fa-times"></i> Failed</p> <p><a href="javascript:history.back()" class="underline">Go back</a></p>');
                                $pass_fail_section.append('<br><span class="text-red font-13px bold"><i class="fa fa-times"></i> Failed</span>');
                            }

                            $tutor_comment.prop('disabled', true);
                            $('.test-answer-p').css({'background':'#eee'});
                        }

                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Please try again shortly.');
                        $spinner.hide();
                        $('.grade-student-btn').show();
                    }
                });
            }
        });

    });

});

$(function(){

    /*function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    }
    function showPosition(position) {
        console.log("Latitude: " + position.coords.latitude + "Longitude: " + position.coords.longitude);
    }

    getLocation();*/

});

$(function(){
   $('.js-delete-article-button').on('click', function( e ){
       var $this = $(this);
       e.preventDefault();
       bootbox.confirm("<p>Delete article forever? <br><br><span class='text-red'>This action cannot be undone</span>.</p>", function(result) {
           if( result ) {

               $this.hide();

               var message = { 'article_id' : $this.attr('data-article-id') };

               $.ajax({
                   type    : 'post',
                   data    : message,
                   dataType : 'json',
                   url     : '/ajax/account/delete_article',
                   success : function(data){
                       if( data.status == 'error' ){
                           alert(data.message);
                           $this.show();
                       } else {
                            window.location = '/page/articles'
                       }
                   },
                   error   :   function(xhr, status, error) {
                       alert('Oops! Technical problems. Please try again shortly.');
                       $this.show();
                   }
               });
           }
       });
   });
});

$(function(){
    $('.js-fee-img').on('click', function(){
        $overlay = $('.feed-img-large-overlay');
        $overlay.find('.img-section').html('<img src="'+$(this).attr('src')+'" class="img-responsive">');
        $overlay.show();
    });

    $('.close-img-large-overlay a, .feed-img-large-overlay').on('click', function() {
        $('.feed-img-large-overlay ').hide();
    });
});

$(function(){
    $('.js-delete-cv-btn').on('click', function( e ){
        var $this = $(this);
        e.preventDefault();
        bootbox.confirm("<p>Delete CV forever? <br><br><span class='text-red'>This action cannot be undone</span>.</p>", function(result) {
            if( result ) {

                $this.hide();

                $.ajax({
                    type    : 'post',
                    dataType : 'json',
                    url     : '/ajax/account/delete_cv',
                    success : function(data){
                        if( data.status == 'error' ){
                            alert(data.message);
                            $this.show();
                        } else {
                            location.reload();
                        }
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Please try again shortly.');
                        $this.show();
                    }
                });
            }
        });
    });
});

$(function(){

    $('.js-follow-org').on('click', function( e ){
        var $this = $(this);
        e.preventDefault();
        bootbox.confirm("<p>Follow "+$this.attr('data-org-name')+" ? </p>", function(result) {
            if( result ) {

                $this.hide();

                var message = {
                  'org_id' : $this.attr('data-org-id')
                };

                $.ajax({
                    type    : 'post',
                    dataType : 'json',
                    data : message,
                    url     : '/ajax/account/follow_org',
                    success : function(data){
                        if( data.status == 'error' ){
                            alert(data.message);
                            $this.show();
                        } else {
                            location.reload();
                        }
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Please try again shortly.');
                        $this.show();
                    }
                });
            }
        });
    });

    $('.js-unfollow-org').on('click', function( e ){
        var $this = $(this);
        e.preventDefault();
        bootbox.confirm("<p>Un-follow "+$this.attr('data-org-name')+" ? </p>", function(result) {
            if( result ) {

                $this.hide();

                var message = {
                    'org_id' : $this.attr('data-org-id')
                };

                $.ajax({
                    type    : 'post',
                    dataType : 'json',
                    data : message,
                    url     : '/ajax/account/unfollow_org',
                    success : function(data){
                        if( data.status == 'error' ){
                            alert(data.message);
                            $this.show();
                        } else {
                            location.reload();
                        }
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Please try again shortly.');
                        $this.show();
                    }
                });
            }
        });
    });
});

$(function(){

    $('.js-hide-lesson-btn').on('click', function( e ){
        var $this = $(this);
        e.preventDefault();
        bootbox.confirm("<p>Remove this lesson? </p>", function(result) {
            if( result ) {

                $this.parent().parent().parent().hide();

                var message = {
                    'organisation_id' : $this.attr('data-org-id'),
                    'course_id' : $this.attr('data-course-id'),
                    'lesson_id' : $this.attr('data-lesson-id')
                };

                $.ajax({
                    type    : 'post',
                    dataType : 'json',
                    data : message,
                    url     : '/ajax/org_tutor/remove_lesson',
                    success : function(data){
                        if( data.status == 'error' ){
                            alert(data.message);
                            $this.parent().parent().parent().show();
                        }
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Please try again shortly.');
                        $this.parent().parent().parent().show();
                    }
                });
            }
        });
    });

});

$(function(){
    $('.js-request-course-creation-btn').on('click', function(e){
        e.preventDefault();
        var $this = $(this);
        $this.prop('disabled', true);
        var message = {
            'organisation_id' : $this.attr('data-org-id')
        };

        $.ajax({
            type    : 'post',
            dataType : 'json',
            data : message,
            url     : '/ajax/org_admin/request_course_creation',
            success : function(data){
                if( data.status == 'error' ){
                    $this.prop('disabled', false);
                    alert(data.message);
                } else {
                    $('.request-course-creation-wrapper').html('<h2 class="text-green">Done!</h2><p class="text-green">Hotshi admin will be in touch with you over the next few hours.</p><p class="text-green">Thank you.</p>')
                }
            },
            error   :   function(xhr, status, error) {
                $this.prop('disabled', false);
                alert('Oops! Technical problems. Please try again shortly.');
            }
        });
    });
});

$(function(){
    $('.toggle_course_creation_status').on('click', function(e){
        e.preventDefault();
        var $this = $(this);
        $this.prop('disabled', true);
        var message = {
            'org_id' : $this.attr('data-org-id')
        };

        $.ajax({
            type    : 'post',
            dataType : 'json',
            data : message,
            url     : '/ajax/account/'+$this.attr('data-api'),
            success : function(data){
                if( data.status == 'error' ){
                    $this.prop('disabled', false);
                    alert(data.message);
                } else {
                    alert(data.message);
                    location.reload();
                }
            },
            error   :   function(xhr, status, error) {
                $this.prop('disabled', false);
                alert('Oops! Technical problems. Please try again shortly.');
            }
        });
    });
});


$(function(){
    if( $('#preloader').length ) {
        $('#start-date').datepicker({
            startDate: '-0m'
            //endDate: '+2d'
        }).on('changeDate', function(ev){
            $('#start-date').datepicker('hide');
            $('#start-date').parent().find('.parsley-errors-list').remove();
            var val = $('#start-date').val().split('/');
            val = val[1]+'/'+val[0]+'/'+val[2];
            $('#start-date').val(val);
        });

        $('#end-date').datepicker({
            startDate: '-0m'
            //endDate: '+2d'
        }).on('changeDate', function(ev){
            $('#end-date').datepicker('hide');
            $('#end-date').parent().find('.parsley-errors-list').remove();
            var val = $('#end-date').val().split('/');
            val = val[1]+'/'+val[0]+'/'+val[2];
            $('#end-date').val(val);
        });
    }
});

$(function(){

    $('.js-delete-ad-btn').on('click', function(){
        var $this = $(this);
        bootbox.confirm("Delete forever? Please note: There are no refunds for deleted ads.", function(result) {
            if( result ) {
                var message = {'ad_id' : $this.attr('data-ad-id') };
                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/delete_ad',
                    success : function(data){
                        alert(data.message);
                        if( data.status == 'error' ) {

                        } else {
                            location.reload();
                        }
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Try again in a little bit.');
                    }
                });
            }
        });
    });

});

$(function(){

    $('.js-approve-ad-btn').on('click', function(){
        var $this = $(this);
        bootbox.confirm("Approving this Ad will make it appear on all user feed.<br><br>Are you sure?", function(result) {
            if( result ) {
                var message = {'ad_id' : $this.attr('data-ad-id') };
                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/approve_ad',
                    success : function(data){
                        alert(data.message);
                        if( data.status == 'error' ) {

                        } else {
                            location.reload();
                        }
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Try again in a little bit.');
                    }
                });
            }
        });
    });

});

$(function(){

    $('.js-disapprove-ad-btn').on('click', function(){
        var $this = $(this);
        bootbox.confirm("Dis-approved Ads will stop appearing on all user feed.<br><br>Are you sure?", function(result) {
            if( result ) {
                var message = {'ad_id' : $this.attr('data-ad-id') };
                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/disapprove_ad',
                    success : function(data){
                        alert(data.message);
                        if( data.status == 'error' ) {

                        } else {
                            location.reload();
                        }
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Try again in a little bit.');
                    }
                });
            }
        });
    });

});

$(function(){

    var $cert_cost_row = $('#cert-cost-row');

    $('#course-type-select').on('change', function(){
        var $this = $(this);
        if( $this.val() === 'FREE' ) {
            $cert_cost_row.hide();
            $cert_cost_row.find('input').removeAttr('required');
        } else {
            $cert_cost_row.show();
            $cert_cost_row.find('input').attr('required', '');
        }
    });

    if( $('#show-cert-section').length ) {
        $('#cert-section-final').removeClass('hide-elem');
    }

});

$(function(){

    $('#js-add-another-email').on('click', function(e){
        e.preventDefault();
        var $form = $('#invite-friends-form');
        var $new_input_wrapper = $form.find('#first-email-input-wrapper').clone();
        $('.invite-friends-input-wrapper').last().after($new_input_wrapper);
        $new_input_wrapper.attr('id', '');
        $new_input_wrapper.find('input').val('');
        $new_input_wrapper.find('.js-remove-friend-email').removeClass('hide-elem');

        $new_input_wrapper.find('.js-remove-friend-email').on('click', function(){
            var $this = $(this);
            $this.parents('.invite-friends-input-wrapper').remove();
        });
    });

});

$(function(){

    $('.js-activate-opportunity-btn').on('click', function(){
        var $this = $(this);
        bootbox.confirm("Activating opportunity will make it accessible to all users. <br><br>Continue?", function(result) {
            if( result ) {
                var message = {'opportunity_id' : $this.attr('data-opportunity-id') };
                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/activate_opportunity',
                    success : function(data){
                        alert(data.message);
                        if( data.status == 'error' ) {

                        } else {
                            location.reload();
                        }
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Try again in a little bit.');
                    }
                });
            }
        });
    });

    $('.js-deactivate-opportunity-btn').on('click', function(){
        var $this = $(this);
        bootbox.confirm("De-activating opportunity will make it inaccessible to all users. <br><br>Continue?", function(result) {
            if( result ) {
                var message = {'opportunity_id' : $this.attr('data-opportunity-id') };
                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/deactivate_opportunity',
                    success : function(data){
                        alert(data.message);
                        if( data.status == 'error' ) {

                        } else {
                            location.reload();
                        }
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Try again in a little bit.');
                    }
                });
            }
        });
    });

    $('.js-delete-opportunity-btn').on('click', function(){
        var $this = $(this);
        bootbox.confirm("Deleting opportunity will completely remove it from Hotshi. This action cannot be undone. <br><br>Continue?", function(result) {
            if( result ) {
                var message = {'opportunity_id' : $this.attr('data-opportunity-id') };
                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/delete_opportunity',
                    success : function(data){
                        alert(data.message);
                        if( data.status == 'error' ) {

                        } else {
                            window.location = '/page/jobs/my';
                        }
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Try again in a little bit.');
                    }
                });
            }
        });
    });

    $('.js-apply-for-opportunity-btn').on('click', function(){
        var $this = $(this);
        /*bootbox.confirm("Once you apply for this opportunity, Hotshi will have access to your profile and CV. Make sure that you have built a good profile and upload your CV before applying for this opportunity. <br><br>Do you want to apply now?", function(result) {
            if( result ) {
                var message = {'opportunity_id' : $this.attr('data-opportunity-id') };
                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/apply_for_opportunity',
                    success : function(data){
                        alert(data.message);
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Try again in a little bit.');
                    }
                });
            }
        });*/

        bootbox.prompt({
            title: $("#js-opportunity-popup-text").val(),
            inputType: 'textarea',
            buttons: {
                confirm: {
                    label: $('#js-opportunity-btn-yes').val(),
                    className: 'btn-success'
                },
                cancel: {
                    label: $('#js-opportunity-btn-no').val(),
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if( result ) {
                    var message = {
                        'opportunity_id' : $this.attr('data-opportunity-id'),
                        'message' : result
                    };
                    $.ajax({
                        type    : 'post',
                        data    : message,
                        dataType : 'json',
                        url     : '/ajax/account/apply_for_opportunity',
                        success : function(data){
                            alert(data.message);
                        },
                        error   :   function(xhr, status, error) {
                            alert('Oops! Technical problems. Try again in a little bit.');
                        }
                    });
                } else {
                    alert('Please enter a message.');
                    //return false;
                }
            }
        });

    });

});

$(function(){

    $('.js-activate-project-btn').on('click', function(){
        var $this = $(this);
        bootbox.confirm("Activating project will make it accessible to all users. <br><br>Continue?", function(result) {
            if( result ) {
                var message = {'project_id' : $this.attr('data-opportunity-id') };
                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/activate_project',
                    success : function(data){
                        alert(data.message);
                        if( data.status == 'error' ) {

                        } else {
                            location.reload();
                        }
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Try again in a little bit.');
                    }
                });
            }
        });
    });

    $('.js-deactivate-project-btn').on('click', function(){
        var $this = $(this);
        bootbox.confirm("De-activating project will make it inaccessible to all users. <br><br>Continue?", function(result) {
            if( result ) {
                var message = {'project_id' : $this.attr('data-opportunity-id') };
                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/deactivate_project',
                    success : function(data){
                        alert(data.message);
                        if( data.status == 'error' ) {

                        } else {
                            location.reload();
                        }
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Try again in a little bit.');
                    }
                });
            }
        });
    });

    $('.js-delete-project-btn').on('click', function(){
        var $this = $(this);
        bootbox.confirm("Deleting project will completely remove it from Hotshi. This action cannot be undone. <br><br>Continue?", function(result) {
            if( result ) {
                var message = {'project_id' : $this.attr('data-opportunity-id') };
                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/delete_project',
                    success : function(data){
                        alert(data.message);
                        if( data.status == 'error' ) {

                        } else {
                            window.location = '/page/projects/my';
                        }
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Try again in a little bit.');
                    }
                });
            }
        });
    });

    $('.js-apply-for-project-btn').on('click', function(){
        var $this = $(this);
        /*bootbox.confirm("Once you apply for this opportunity, Hotshi will have access to your profile and CV. Make sure that you have built a good profile and upload your CV before applying for this opportunity. <br><br>Do you want to apply now?", function(result) {
            if( result ) {
                var message = {'opportunity_id' : $this.attr('data-opportunity-id') };
                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/apply_for_opportunity',
                    success : function(data){
                        alert(data.message);
                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Technical problems. Try again in a little bit.');
                    }
                });
            }
        });*/

        bootbox.prompt({
            title: $("#js-project-interest-popup-text").val(),
            inputType: 'textarea',
            buttons: {
                confirm: {
                    label: $('#js-project-interest-btn-yes').val(),
                    className: 'btn-success'
                },
                cancel: {
                    label: $('#js-project-interest-btn-no').val(),
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if( result ) {
                    var message = {
                        'project_id' : $this.attr('data-opportunity-id'),
                        'message' : result
                    };
                    $.ajax({
                        type    : 'post',
                        data    : message,
                        dataType : 'json',
                        url     : '/ajax/account/apply_for_project',
                        success : function(data){
                            alert(data.message);
                        },
                        error   :   function(xhr, status, error) {
                            alert('Oops! Technical problems. Try again in a little bit.');
                        }
                    });
                } else {
                    alert('Please enter a message.');
                    //return false;
                }
            }
        });

    });

});

$(function(){
    var $global_search_input = $('.global-search-input');
    var $user_search_option = $('#searchOptionsRadios2');
    var $dynamic_container = $('.users-dynamic-container');
    var $dynamic_container_inner = $('.users-dynamic-container-inner');

    $('.search-form-landing').on('submit', function(e){
        if($user_search_option.is(':checked')){
            e.preventDefault();
        }
    });

    $global_search_input.on('keyup', function(){
        var $this = $(this);

        if( $this.val().length >= 3 ) {
            if($user_search_option.is(':checked')) {
                var message = {
                    'query' : $this.val()
                };
                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/auth/search_users_dynamic',
                    success : function(data){
                        if( data.status === 'error' ) {
                            $dynamic_container_inner.html('');
                            $dynamic_container.hide();
                        } else {
                            $dynamic_container_inner.html('');
                            $dynamic_container.show();
                            $.each(data.users, function(key, value) {
                                var $template = $('.dynamic-user-template.hide-elem').clone();
                                $template.find('.dynamic-user-link').attr('href', '/page/profile/'+value.id);
                                $template.find('.dynamic-user-pic').attr('src', value.image);
                                $template.find('.dynamic-user-name').text(value.fullname);
                                $template.removeClass('hide-elem');
                                $dynamic_container_inner.append($template);
                                $dynamic_container_inner.append('<hr>');
                            });
                        }

                    },
                    error   :   function(xhr, status, error) {}
                });
            }
        } else {
            $dynamic_container.hide();
            $dynamic_container_inner.html('');
        }
    });

   $('.searchOptionsRadios').on('change', function(){
        var $this = $(this);
        if( $this.val() === 'courses' ) {
            $global_search_input.attr('placeholder', 'Search courses, press enter...');
        } else {
            $global_search_input.attr('placeholder', 'Search users...');
        }
   });
});

$(function(){

    $('.js-send-campaign-btn').on('click', function(){
        var $this = $(this);
        var $preloader = $('#preloader');
        bootbox.confirm("Email campaign will be sent to selected users. This action cannot be undone. <br><br>Continue?", function(result) {
            if( result ) {

                $preloader.show();

                var message = {'campaign_id' : $this.attr('data-campaign-id') };

                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/send_email_campaign',
                    success : function(data){
                        if( data.status == 'error'){
                            alert(data.message);
                        } else {
                            alert('Email sent successfully!');
                        }

                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Problem sending email campaign. Try again in a little bit.');
                    },
                    complete : function() {
                        $preloader.hide();
                    }
                });
            }
        });
    });

    $('.js-delete-campaign-btn').on('click', function(){
        var $this = $(this);
        bootbox.confirm("Delete email campaign. This action cannot be undone. <br><br>Continue?", function(result) {
            if( result ) {

                var message = {'campaign_id' : $this.attr('data-campaign-id') };

                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/account/delete_email_campaign',
                    success : function(data){
                        if( data.status == 'error'){
                            alert(data.message);
                        } else {
                            alert('Email deleted successfully!');
                            location.reload();
                        }

                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Problem deleting email campaign. Try again in a little bit.');
                    }
                });
            }
        });
    });

});

$('#toggle-lang-btn').on('click', function(){
    var $this = $(this);
    var message = {'lang' : $this.find('b').attr('data-lang') };
    $.cookie('user_lang', $this.find('b').attr('data-lang'), { expires: 365, path: '/' });
    location.reload();
});

$(function(){
    if( $('#is-android-web-view').length && $('#js-is-logged-in-input').length ) {
        var curr_device_id = $('#js-user-android-device-id').val();
        var device_id = Android.get_device_token();
        if( !curr_device_id || curr_device_id != device_id  ) {
            var message = {'device_id' : device_id };
            $.ajax({
                type    : 'post',
                data    : message,
                dataType : 'json',
                url     : '/ajax/account/update_android_device_id',
                success : function(data){},
                error   :   function(xhr, status, error) {}
            });
        }
    }
});

$(function(){

    $('.js-delete-course-btn').on('click', function(){
        var $this = $(this);
        bootbox.confirm("Delete course? This action cannot be undone. <br><br>Continue?", function(result) {
            if( result ) {

                var message = {
                    'course_id' : $this.attr('data-course-id'),
                    'organisation_id' : $this.attr('data-org-id')
                };

                $.ajax({
                    type    : 'post',
                    data    : message,
                    dataType : 'json',
                    url     : '/ajax/org_admin/delete_course',
                    success : function(data){
                        if( data.status == 'error'){
                            alert(data.message);
                        } else {
                            alert('Course Deleted.');
                            location.reload();
                        }

                    },
                    error   :   function(xhr, status, error) {
                        alert('Oops! Problem deleting email campaign. Try again in a little bit.');
                    }
                });
            }
        });
    });

});
