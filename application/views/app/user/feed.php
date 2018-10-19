<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>


<input type="hidden" id="user-id" value="<?=$user['id']?>">
<input type="hidden" id="base-url" value="<?=base_url()?>">

<style>
    .portlet.light > .portlet-title > .tools {
        padding-top: 0;
    }
</style>

<?php if( isset( $_GET['showcomments'] ) ): ?>
    <input type="hidden" id="autoshowcomments" value="<?=$_GET['showcomments']?>">
<?php endif; ?>

<div class="feed-img-large-overlay fade-in">
    <p class="close-img-large-overlay"><a href="javascript:"><i class="fa fa-close"></i> </a> <div class="img-section"></div> </p>
</div>

<div class="row" id="bs-feed-top" style="min-height:600px;">
    <div class="col-md-12">

        <div class="todo-content bs-feed-right">
            <div class="portlet feed-portlet-main" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?>>

                <?php if( $this->router->method == 'discussions' && !$can_view_discussions ): ?>
                    <style>
                        .bs-feed-post-section, .bs-feed-wrapper{
                            display: none !important;
                        }
                    </style>
                <?php endif; ?>

                <div class="portlet-title">
                    <div class="caption bs-welcome-username-wrapper">

                        <?php if( isset($default_feed) ): ?>
                            <span class="caption-helper bs-welcome-username">
                            <?php if( $this->router->method == 'discussions'  ): ?>
                                <a href="/org/course/<?=$course['organisation_id']?>/<?=$course['id']?>" style="color:#000;text-decoration:none;font-size:25px;font-weight:100;display:block;padding-top:20px;padding-bottom:20px;"><span class="">Discussions: <?=$course['title']?></span></a>
                            <?php else: ?>
                                <a href="/page/profile/<?=$this->session->userdata('id')?>" style="color:#000;text-decoration:none;"><span class="bold"><?=$user['fullname']?></span> <br><?=$user['profession']?></a>
                            <?php endif; ?>
                            </span>
                            <span class="caption-helper pull-right invite-friends-wrapper">
                                <a href="javascript:;" data-toggle="modal" data-target="#bs-invite-friends-modal" class="btn btn-large btn-success uppercase"><i class="fa fa-users" style="color:#fff !important;"></i> <?=$is_french_user ? 'Inviter des amis':'Invite friends' ?> </a>
                            </span>
                        <?php else: ?>
                            <span class="caption-helper bs-welcome-username bs-filter-feed-title">
                                <div style="padding-top:20px;"></div>
                                <span class="bold"><?=$feed_title?><!--(<?=$num_of_posts?>)--></span>
                                <?php if(isset($single_post)): ?>
                                    <span style="font-size:11px;"><br>... <?=$posts[0]['title']?></span>
                                <?php endif; ?>
                                <div style="padding-bottom:15px;"></div>
                            </span>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <?php if( $this->router->method == 'discussions'  ): ?>
                            <div class="col-md-2 col-sm-3" id="tour-course-menu">
                                <?=$course_page_menu?>
                            </div>

                        <?php endif; ?>

                        <?=$posts_feed?>

                        <?php if( $this->router->method != 'discussions'  ): ?>
                            <?=$feed_right_sidebar?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?=$view_comments_feed_modal?>
<?=$alert_modal?>
<?=$invite_friends_modal?>


<?php if( !$is_logged_in ): ?>
    </div>
    </div>
    </div>
<?php endif; ?>