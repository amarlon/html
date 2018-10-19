/**
 * Created by benshittu on 04/11/15.
 */

/*var audioElement = document.createElement('audio');
audioElement.setAttribute('src', '/assets/global/audio/bs_msg_notification.mp3');
audioElement.setAttribute('autoplay', 'autoplay');
audioElement.load();

$.get();

audioElement.addEventListener("load", function() {
    audioElement.pause();
}, true);*/

$( window ).load(function() {

    var $direct_msg_link = $('#direct-link-contact-id');

    if( $direct_msg_link.length ) {
        $('.bs-inbox-left div#'+$direct_msg_link.val()).click();
    } else {
        $('.bs-inbox-details.inbox-left:first').click();
    }
});


var current_messages = null;

$(function(){

    var $mobile_contacts = $('.mobile-contacts');
    var $inbox_left = $('.bs-inbox-left');
    var $show_contacts_mobile_btn = $('.bs-show-contacts-mobile-btn');

    $mobile_contacts.on('click', function(){
        $inbox_left.hide();
    });

    $show_contacts_mobile_btn.on('click', function(e){
        e.preventDefault();
        $inbox_left.toggle();
    });

});


$(function(){

    $('.bs-inbox-details.inbox-left').on('click', function(e){

        e.preventDefault();

        var $this = $(this);
        $('.bs-inbox-details.inbox-left').removeClass('active'); //remove from all

        $this.addClass('active');
        var $inbox_warning = $('.inbox-right-warning');
        var $inbox_right = $('.bs-inbox-right');
        var $form = $inbox_right.find('form');
        var $inbox_body = $('#bs-inbox-right-body');
        var sender_name = $this.find('#sender-fullname').val();
        var last_updated = $this.find('#sender-last-updated').val();
        var sender_profession = $this.find('#sender-profession').val();
        var $spin = $inbox_right.find('.fa-spin');

        $inbox_body.empty();
        $spin.show();

        $inbox_right.find('#sender-image').parent().attr('href', '/page/profile/'+$this.attr('id'));
        $inbox_right.find('#sender-image').attr('src', $this.find('#sender-avatar').val());
        $inbox_right.find('.bs-inbox-username-left').html(sender_name+', <span class="bs-inbox-date">'+last_updated+' ago</span>');
        $inbox_right.find('.bs-inbox-subject-left').html(sender_profession ? '<strong>'+sender_profession+'</strong>' : '--');

        $form.find('#hidden-input-contact-id').val($this.attr('id'));

        var message = {'contact_id' : $this.attr('id') };

        $.ajax({
            type    : 'post',
            data    : message,
            dataType : 'json',
            url     : '/ajax/account/get_contact_messages',
            success : function(data){

                var $user_id = $('#user-id');

                if( data.status == 'error' ) {
                    $spin.hide();
                    $inbox_warning.find('span').html(data.message);
                    $inbox_warning.show();
                    return false;
                }

                $.each(data, function(key, value) {
                    var img = value.image ? '<div><hr><a href="'+value.image+'" class="font-12px" target="_blank"><i class="icon-paper-clip"></i> attachment</a></div>' : '';
                    var seen = value.is_seen == 1 && value.sender_user_id == $user_id.val() ? '<i class="fa fa-check-circle-o" style="float:left;"></i>' : '';
                    if( value.sender_user_id == $user_id.val() ) {
                        $inbox_body.append('' +
                        '<div class="col-md-12">' +
                            '<div class="alert alert-info col-md-6" style="margin-left:40px;">' +
                                '<p>'+value.description+'</p>'+img+'<p class="inbox-reply-time">'+seen+value.date_created+'</p>' +
                            '</div>' +
                        '</div>');
                    } else {
                        $inbox_body.append('' +
                        '<div class="col-md-12">' +
                            '<div class="alert alert-success col-md-6">' +
                                '<p>'+value.description+'</p>'+img+'<p class="inbox-reply-time">'+value.date_created+'</p>' +
                            '</div>' +
                        '</div>');
                    }

                    current_messages = data;
                    var $target = $('html,body');
                    $target.animate({scrollTop: $target.height()}, 50);
                    doPoll();

                });

                $inbox_body.scrollTop(1E10); //scroll down a lot
                $spin.hide();

            },
            error   :   function(xhr, status, error) {
                $inbox_body.empty();
                $spin.hide();
                $inbox_warning.hide();
                alert('Error getting messages. Try again in a little bit');
            }
        });
    });

    /*  poll messages from server */
    function doPoll(){

        var contact_id = $('#hidden-input-contact-id').val();
        var $inbox_body = $('#bs-inbox-right-body');

        if( contact_id ) {

            var message = {'contact_id' : contact_id };

            $.ajax({
                type    : 'post',
                data    : message,
                dataType : 'json',
                url     : '/ajax/account/get_contact_messages',
                success : function(data){

                    if( current_messages.length == data.length ) {

                        //No update required

                    } else{

                        if( data.status == 'error' ) {
                            //$spin.hide();
                            //$inbox_warning.find('span').html(data.message);
                            //$inbox_warning.show();
                            return false;
                        }

                        $inbox_body.empty();

                        var $user_id = $('#user-id');

                        $.each(data, function(key, value) {
                            var img = value.image ? '<div><hr><a href="'+value.image+'" class="font-12px" target="_blank"><i class="icon-paper-clip"></i> attachment</a></div>' : '';
                            var seen = value.is_seen == 1 && value.sender_user_id == $user_id.val() ? '<i class="fa fa-check-circle-o" style="float:left;"></i>' : '';
                            if( value.sender_user_id == $user_id.val() ) {
                                $inbox_body.append('' +
                                '<div class="col-md-12">' +
                                '<div class="alert alert-info col-md-6" style="margin-left:40px;">' +
                                    '<p>'+value.description+'</p>'+img+'<p class="inbox-reply-time">'+seen+value.date_created+'</p>' +
                                    '</div>' +
                                '</div>');
                            } else {
                                $inbox_body.append('' +
                                '<div class="col-md-12">' +
                                    '<div class="alert alert-success col-md-6">' +
                                        '<p>'+value.description+'</p>'+img+'<p class="inbox-reply-time">'+value.date_created+'</p>' +
                                    '</div>' +
                                '</div>');
                            }
                        });

                        //play_msg_audio();

                        $inbox_body.scrollTop(1E10); //scroll down a lot
                        current_messages = data;

                        var $target = $('html,body');
                        $target.animate({scrollTop: $target.height()}, 1000);

                    }

                    setTimeout(doPoll,10000);
                },
                error   :   function(xhr, status, error) {
                    //error
                }
            });
        }
    }

    /*function play_msg_audio() {

        var timer="";
        var isBlurred=false;
        $(window).on("blur",function() {
            audioElement.play();
            isBlurred = true;
            timer=window.setInterval(function() {
                document.title = document.title == "Messaging | Site name" ? "New message" : "Messaging | Site name";
            }, 1000);
        }).on("focus",function() {
            isBlurred = false;
            document.title = "Messaging | Site name";
            clearInterval(timer);
        });

    }*/

});