<input type="hidden" id="user-id" value="<?=$user['id']?>">

<?php if( isset($_GET['contactid']) ): ?>
    <input type="hidden" id="direct-link-contact-id" value="<?=$_GET['contactid']?>" />
<?php endif; ?>

<style>
    
    body{
        /*overflow: hidden;*/
    }

    .page-content{
        /*padding-top: 0;
        padding-bottom: 0;*/
    }

    .container{
        /*height: 100vh;*/
        /*background: red;*/
    }

    .portlet{
        /*padding-bottom: 0;
        margin-bottom: 0;*/
    }

    .portlet.light{
        /*margin-bottom: 0;*/
    }

    .logged-in-body .view-container {
        /*margin-bottom: 0;*/
    }

    .bs-inbox-left-wrapper{
        max-height: 1050px;
        /*height: 100vh;*/
        /*height: 100%;
        padding-bottom: 150px;*/
        overflow-y: auto;
    }

    .bs-inbox-right{
        /*height: 100vh;*/
        height: 100%;
    }

    .bs-reply-from-wrapper{
        /*position: absolute;
        z-index: 9;
        bottom: 135px;
        padding-bottom: 20px;*/
    }

    .bs-reply-from-wrapper{
        /*background: #fff;*/
    }

    .bs-reply-from-wrapper .form-group{
        padding: 0 15px;
    }

    .go2top.scroll {
        display: none;
    }

    @media(max-width: 991px) {
        body{
            overflow-y: scroll;
        }
        
        .container{
            height: auto;
        }

        .bs-reply-from-wrapper{
            margin-bottom: 0;
            position: relative;
        }

        .bs-inbox-left-wrapper{
            padding-bottom: 0;
        }
    }

    @media(max-width: 480px) {
        .file-input-name {
            margin-top: -15px;
        }

        .submit-button-wrapper{
            text-align: left;
        }
    }
</style>

<div class="portlet margin-top-10 col-md-3 bs-inbox-left-wrapper">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold">Inbox <i class="icon-envelope-open"></i></span>
            <?php if(is_mobile_device()): ?>
                <br><br>
                <a href="" class="btn btn-default btn-sm bs-show-contacts-mobile-btn">Toggle contacts</a>
                <style>
                    .bs-inbox-right-body .alert-info{ margin-left:0 !important; }
                    .bs-inbox-right-body .alert-success{ margin-left:0 !important; }
                </style>
            <?php endif; ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row bs-inbox-left">

            <?php foreach( $inbox_contacts as $contact ): ?>
                <div id="<?=$contact['id']?>" class="bs-inbox-details inbox-left <?=is_mobile_device() ? 'mobile-contacts' : '' ?>">
                    <img id="sender-image" src="<?=$contact['image']?>" alt="Profile image">
                    <h4 class="bs-inbox-username-left"><b><?=$contact['fullname']?></b>, <span class="bs-inbox-date"><?=$contact['last_updated_msg']?></span></h4>
                    <p class="bs-inbox-subject-left"><?=$contact['profession'] ? $contact['profession'] : '--' ?></p>
                    <input type="hidden" id="sender-avatar" value="<?=$contact['image']?>">
                    <input type="hidden" id="sender-fullname" value="<?=$contact['fullname']?>">
                    <input type="hidden" id="sender-profession" value="<?=$contact['profession']?>">
                    <input type="hidden" id="curr-sender-id" value="<?=$contact['id']?>">
                    <input type="hidden" id="sender-last-updated" value="<?=$contact['last_updated_msg']?>">
                </div>
                <hr>
            <?php endforeach; ?>

            <?php if( !$inbox_contacts ): ?>
                <p class="no-messages" style="padding-left:15px;">No messages</p>
            <?php endif; ?>

        </div>
    </div>
</div>

<div class="portlet light margin-top-10 col-md-9 bs-inbox-right bs-inbox-right-title">
    <div class="portlet-title">
        <div class="bs-inbox-details" style="padding-bottom:15px;">
            <a href="javascript:;">
                <img id="sender-image" src="<?=get_default_avatar()?>" alt="Profile image">
                <h4 class="bs-inbox-username-left">--<span class="bs-inbox-date"></span></h4>
                <p class="bs-inbox-subject-left">--</p>
            </a>
            <!--<a href="" class="bs-reply-btn" data-toggle="modal" data-target="#bs-reply-inbox-modal"><i class="fa fa-reply"></i> Reply</a>-->
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">

            <div class="alert alert-danger display-hide inbox-right-warning" style="text-align:center;">
                <a href="" class="close" data-close="alert"></a>
                <span></span>
            </div>

            <p class="centered-text">
                <i class="fa fa-refresh fa-spin"></i>
            </p>

            <div class="col-md-12 bs-inbox-right-body" id="bs-inbox-right-body"></div>

        </div>
    </div>

    <div class="row">

        <?php if( $inbox_contacts ): ?>
            <div class="col-md-12 bs-reply-from-wrapper" style="margin-left:-5px;">

                <form role="form" action="/ajax/account/send_message_reply" class="form-ajax" enctype="multipart/form-data">
                    <div class="form-body">

                        <div class="form-group">
                            <textarea name="message" class="form-control bs-comment-textarea" rows="4" placeholder="Write a reply" required="" style="font-size:14px !important;"></textarea>
                        </div>



                        <input type="hidden" name="contact_id" id="hidden-input-contact-id" value="">
                    </div>

                    <div class="row bs-post-comment-btn-wrapper">
                        <div class="col-md-12">
                            <div class="alert alert-danger form-error display-hide" style="text-align:left;">
                                <a href="" class="close" data-close="alert"></a>
                                <span></span>
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-12" style="padding-top:12px;">
                                <input type="file" name="file">
                            </div>
                            <div class="col-md-5 col-md-5 col-xs-12 submit-button-wrapper pull-right">
                                <button type="submit" class="btn btn-lg btn-success pull-right inbox-send-btn" style="width:150px;height:45px;">Send</button>
                                <!--<button type="button" class="btn btn-sm btn-warning bs-cancel-comment-btn pull-right">Cancel</button>-->
                                <i class="fa fa-spinner fa-spin pull-right"></i>
                            </div>


                        </div>
                    </div>

                </form>

            </div>
        <?php endif; ?>

    </div>

</div>