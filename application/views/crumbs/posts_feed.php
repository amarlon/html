<div class="col-md-8 posts-feed-col" style="padding:0;">

    <?php if( isset($default_feed) ): ?>
        <div class="col-md-12 bs-feed-wrapper">
            <div class="col-md-2">
                <a href="/page/profile/<?=$this->session->userdata('id')?>">
                    <img src="<?=$user['image'] ? $user['image'] : get_default_avatar() ?>" class="bs-user-img">
                </a>
            </div>

            <div class="col-md-8 bs-feed-post-section">

                <div class="portlet light bs-create-post-top" style="padding: 3px 10px;">
                    <div class="portlet-body">
                        <form class="form-ajax form-horizontal" enctype="multipart/form-data" action="/ajax/account/create_post">
                            <div class="form">

                                <div class="form-group" style="margin-bottom:10px;">
                                    <div class="col-md-12">
                                        <textarea name="description" class="form-control" rows="3" placeholder="What's on your mind?" required=""></textarea>
                                    </div>
                                </div>

                                <?php if( $this->router->method == 'discussions' ): ?>
                                    <input type="hidden" name="course_id" value="<?=$course['id']?>">
                                <?php endif; ?>

                                <div class="form-group bs-post-category-date" id="bs-post-category-date">
                                    <div class="col-md-12">
                                        <div class="input-icon">
                                            <i class="fa fa-calendar"></i>
                                            <input name="event_date" id="event-date-picker" type="text" class="form-control todo-taskbody-due" placeholder="Event Date...">
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="is_followers_only" value="0">

                                <div class="form-actions right todo-form-actions" style="padding:10px 10px;margin-bottom:0;padding-left:0;">
                                    <div class="col-md-9 col-xs-5" style="padding-left:5px;padding-top:6px;">
                                        <input type="file" name="file" accept="image/*" />
                                    </div>
                                    <button type="submit" class="btn btn-circle btn-primary uppercase" style="margin-bottom:10px;padding-right:30px;padding-left:30px;">Post</button>
                                    <i class="fa fa-spinner fa-spin"></i>
                                    <div class="alert alert-danger form-error display-hide" style="text-align:left;">
                                        <a href="" class="close" data-close="alert"></a>
                                        <span></span>
                                    </div>
                                    <div class="alert alert-success form-success display-hide" style="text-align:left;">
                                        <a href="" class="close" data-close="alert"></a>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <input type="hidden" id="bs-feed-area-hidden">

    <?php if( isset($posts[0]) && $posts[0]['num_hidden_posts'] > 0 ): ?>
        <p class="num-of-hidden-posts-p"><span id="num-of-hidden-posts"><?=$posts[0]['num_hidden_posts']?></span> hidden - <a href="javascript:;" class="bs-show-hidden-posts">show</a></p>
    <?php else: ?>
        <p class="num-of-hidden-posts-p hide-by-default"><span id="num-of-hidden-posts">0</span> hidden - <a href="javascript:;" class="bs-show-hidden-posts">show</a></p>
    <?php endif; ?>

    <?php foreach( $posts as $post ): ?>

        <div class="col-md-12 bs-feed-wrapper post-id-<?=$post['id']?> <?=isset($post['is_hidden']) ? 'bs-hidden-post':'' ?>" id="<?=$post['id']?>">
            <!--<div class="col-md-2">

            </div>-->

            <div class="col-md-10 bs-feed-post-section">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption bs-feed-title-parent">
                            <a href="/page/profile/<?=$post['poster_id']?>" class="posts-feed-user-icon">
                                <img src="<?=$post['poster_avatar'] ? $post['poster_avatar'] : get_default_avatar() ?>" class="bs-feed-users-img">
                            </a>
                            <p class="bs-feed-poster-info">
                                <a href="/page/profile/<?=$post['poster_id']?>"><?=$post['poster_id'] == $this->session->userdata('id') ? 'You' : $post['poster_name'] ?></a><?=$post['poster_profession'] ? ',':''?> <a href="/page/search?q=<?=$post['poster_profession']?>"><?=$post['poster_profession']?></a>
                                <br><span class="bs-post-timestamp badge"><?=time_elapsed_string(strtotime($post['date_created']))?> ago</span>
                            </p>

                        </div>
                        <div class="tools">

                            <ul class="nav navbar-right settings-icon-user-profile">
                                <li class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-settings"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-right-mobile">
                                        <?php if( $post['poster_id'] == $this->session->userdata('id') ): ?>
                                            <li><a href="/account/edit_post/<?=$post['id']?>"><i class="icon-pencil"></i> Edit post</a></li>
                                        <?php endif; ?>
                                        <?php if( $this->router->method != 'discussions' ): ?>
                                            <li><a href="/account/feed/<?=$post['id']?>" class="bs-get-direct-link" id="<?=base_url()?>account/feed/<?=$post['id']?>"><i class="fa fa-link"></i> Get direct link</a></li>
                                        <?php endif; ?>
                                        <?php if( $post['user_id'] != $this->session->userdata('id') ): ?>
                                            <?php if( isset($post['is_hidden']) ): ?>
                                                <li class="unhide-post-li"><a href="javascript:;" class="bs-unhide-post" id="<?=$post['id']?>"><i class="fa fa-eye"></i> Un-hide post</a></li>
                                                <li class="hide-post-li hidden-hide-post-link"><a href="javascript:;" class="bs-hide-post" id="<?=$post['id']?>"><i class="fa fa-eye-slash"></i> Hide post</a></li>
                                            <?php else: ?>
                                                <li class="unhide-post-li hidden-hide-post-link"><a href="javascript:;" class="bs-unhide-post" id="<?=$post['id']?>"><i class="fa fa-eye"></i> Un-hide post</a></li>
                                                <li class="hide-post-li"><a href="javascript:;" class="bs-hide-post" id="<?=$post['id']?>"><i class="fa fa-eye-slash"></i> Hide post</a></li>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if( $post['poster_id'] == $this->session->userdata('id') ): ?>
                                            <li><a href="javascript:;" class="bs-delete-post" id="<?=$post['id']?>"><i class="icon-trash"></i> Delete post</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="portlet-body">

                        <p class="bs-feed-summary">
                            <?=preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1" target="_blank" class="posts-feed-auto-link">$1</a>', $post['description']);?>
                        </p>

                        <?php if( $post['image'] ): ?>
                            <img src="<?=$post['image']?>" class="img-responsive js-fee-img">
                        <?php endif; ?>
                        <div class="margin-top-20"></div>
                        <a href="javascript:;" id="<?=$post['id']?>" class="bs-feed-comments-link"><i class="fa fa-comments"></i> (<span class="bs-num-comments-count"><?=$post['num_of_comments']?></span>)</a>
                    </div>

                    <div class="row">

                        <div class="col-md-12 bs-view-comments-feed-wrapper" style="padding-top:20px;">

                            <form role="form" action="/ajax/account/add_comment" class="form-ajax post-comment-form" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="form-group">
                                        <textarea name="comment" id="bs-comment-textarea" class="form-control bs-comment-textarea" rows="2" placeholder="Add a comment..." required=""></textarea>
                                    </div>
                                    <input type="hidden" name="post_id" class="hidden-input-bs-post-id" value="<?=$post['id']?>">
                                </div>

                                <div class="row bs-post-comment-btn-wrapper" id="bs-post-comment-btn-wrapper">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger form-error display-hide" style="text-align:left;">
                                            <a href="" class="close" data-close="alert"></a>
                                            <span></span>
                                        </div>
                                        <!--<div class="alert alert-success form-success display-hide" style="text-align:left;">
                                            <a href="" class="close" data-close="alert"></a>
                                            <span></span>
                                        </div>-->
                                        <button type="button" class="btn btn-sm btn-warning bs-cancel-comment-btn">Cancel</button>
                                        <button type="submit" class="btn btn-sm btn-primary">Post</button>
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </div>
                                </div>

                            </form>

                            <div class="row">
                                <div class="col-md-12 bs-comments-section">

                                    <p style="text-align:center;">
                                        <i class="fa fa-refresh fa-spin"></i>
                                    </p>

                                    <div class="comment-section-inner">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    <?php endforeach; ?>

    <?php if( $this->router->method == 'discussions' && !$can_view_discussions ): ?>
        <?php if( $is_logged_in ): ?>
            <h4 class="text-center">You must be enrolled to view course discussions.</h4>
        <?php else: ?>
            <h4 class="text-center">You must be logged in to view course discussions.</h4>
        <?php endif; ?>
        <p class="text-center text-purple">Sorry about that.</p>
    <?php elseif( $this->router->method == 'discussions' && !$posts ): ?>
        <p style="padding-left:15px;" class="text-purple">There are currently no discussions in this course. You can create one.</p>
    <?php elseif( $this->router->method != 'feed' && !$posts ): ?>
        <p style="padding-left:15px;" class="text-purple">No posts. <a href="/account/feed" class="underline">Create one</a></p>
    <?php endif; ?>

</div>