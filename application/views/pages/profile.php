<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>

    <div style="<?=$is_logged_in ? 'margin-top:30px;' : 'margin-top:100px;'?>"></div>

<?php if( isset($_GET['message']) ): ?>
    <input type="hidden" id="bs-auto-msg-modal" value="1">
<?php endif; ?>

<style>
    p{ font-weight:normal; }
    .posts-feed-col{
        margin-left: 50px;
    }

    @media (max-width: 991px){
        .posts-feed-col{
            margin-left: 0;
        }
    }
</style>

<div class="row margin-top-10">
    <div class="col-md-12">
        <div class="profile-sidebar col-md-3">
            <div class="portlet profile-sidebar-portlet">
                <div class="profile-userpic">
                    <?php if( $user['id'] == $this->session->userdata('id') ): ?>
                        <a href="/account/edit_profile?clicktab=bs-edit-avatar"><img src="<?=isset($user['image']) ? $user['image'] : get_default_avatar(); ?>" class="img-responsive" alt=""></a>
                    <?php else: ?>
                        <img src="<?=isset($user['image']) ? $user['image'] : get_default_avatar(); ?>" class="img-responsive" alt="">
                    <?php endif; ?>
                </div>

                <?php if( $user['id'] != $this->session->userdata('id') ): ?>
                    <div class="profile-userbuttons">
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#bs-msg-user-modal"> <?=$is_contact ? '<i class="fa fa-envelope"></i> Message':'<i class="icon-user-follow"></i> Add as contact' ?></a>
                    </div>
                <?php endif; ?>
            </div>

            <br>
            <?php if( $is_french_user ): ?>
                <p class="course-level-list"><a href="/page/profile/<?=$user['id']?>?posts">- <?=$user['id'] == $this->session->userdata('id') ? 'Mes publications' : ''.$user['firstname'].'\'s publications' ?></a></p>
                <hr>
            <?php else: ?>
                <p class="course-level-list"><a href="/page/profile/<?=$user['id']?>?posts">- <?=$user['id'] == $this->session->userdata('id') ? 'My Posts' : ''.$user['firstname'].'\'s Posts' ?></a></p>
                <hr>
            <?php endif; ?>

            <?php if( $is_french_user ): ?>
                <p class="course-level-list"><a href="/page/articles/<?=$user['id']?>">- <?=$user['id'] == $this->session->userdata('id') ? 'Mes articles' : ''.$user['firstname'].'\'s articles' ?></a></p>
            <?php else: ?>
                <p class="course-level-list"><a href="/page/articles/<?=$user['id']?>">- <?=$user['id'] == $this->session->userdata('id') ? 'My Articles' : ''.$user['firstname'].'\'s Articles' ?></a></p>
            <?php endif; ?>

            <?php if( $user['country_name'] ): ?>
                <hr>
                <h4><?=$is_french_user ? 'Localisation':'Location' ?></h4>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-map-marker"></i>
                    <a href="javascript:;"><?=$user['country_name']?></a>
                </div>
            <?php endif; ?>

            <?php if( $user['country_origin_name'] ): ?>
                <hr>
                <h4><?=$is_french_user ? "PAYS D'ORIGINE":"Country of Origin" ?></h4>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-map-marker"></i>
                    <a href="javascript:;"><?=$user['country_origin_name']?></a>
                </div>
            <?php endif; ?>

            <?php if( $user['website'] ): ?>
                <hr>
                <h5><?=$is_french_user ? 'Site Internet':'Website' ?></h5>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-globe"></i>
                    <?php if( strpos($user['website'], "http://") == false || strpos($user['website'], "https://") == false ): ?>
                        <a href="<?='http://'.$user['website']?>" target="_blank" class="website"><?=$user['website']?></a>
                    <?php else: ?>
                        <a href="<?=$user['website']?>" target="_blank" class="website"><?=$user['website']?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if( $thisuser['is_hotshi_admin'] || $user['id'] == $this->session->userdata('id') ): ?>
                <hr>
                <h5><?=$is_french_user ? 'CV (Information Privée)':'CV (private info)' ?></h5>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-file-text"></i>
                    <?php if( $user['cv'] ): ?>
                        <a href="<?=$user['cv']?>" style="cursor:pointer !important;text-decoration:underline !important;"><?=$is_french_user ? 'Télécharger':'Download' ?></a>
                    <?php else: ?>
                        <a href="javascript:">---</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if( $thisuser['is_hotshi_admin'] ): ?>
                <hr>
                <a href="/account/login_u_admin?e=<?=$user['email']?>" class="btn btn-warning" style="cursor:pointer !important;">Login as</a>
                <hr>
            <?php endif; ?>

        </div>

        <?php if( $posts ): ?>

            <?=$posts_feed?>

        <?php else: ?>

            <div class="col-md-9 bs-profile-info-right">
                <div class="portlet light portlet-no-bg">
                    <div class="portlet-title">
                        <div class="caption search-results-caption">
                            <span class="caption-subject uppercase"><?=$user['fullname']?><br></span>
                            <div class="margin-top-10"></div>
                            <?php if($user['profession']): ?>
                                <span class="caption-helper"><?=$user['profession']?><br><br></span>
                            <?php endif; ?>
                        </div>
                        <div class="actions">
                            <?php if( $user['id'] == $this->session->userdata('id') ): ?>
                                <a href="/account/edit_profile" class="btn btn-primary btn-large"><i class="fa fa-pencil"></i> <?=$is_french_user ? 'EDITER LE PROFIL':'Edit Profile' ?></a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="portlet-body bs-edit-pages">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="bold"><?=$is_french_user ? 'Compétences':'Skills' ?></h4>
                                <?php
                                if( $user['tags'] ) {
                                    $tags = explode(',', $user['tags']);
                                    foreach( $tags as $tag ) {
                                        echo '<a href="/page/search?q='.$tag.'" class="btn bs-btn-tags">'.$tag.'</a>';
                                    }
                                } else{
                                    echo '---';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="bold"><?=$is_french_user ? 'À Propos':'About' ?></h4>
                                <p><?=$user['about'] ? $user['about'] : '---'?></p>
                            </div>
                        </div>

                        <?php if($tutor_courses): ?>
                            <hr>
                            <div class="row profile-courses-row">
                                <div class="col-md-12">
                                    <h4 class="bold"><?=$is_french_user ? 'Tutorat':'Tutoring' ?></h4>
                                    <?php foreach($tutor_courses as $tc): ?>
                                        <!--<p><a href="/org/course/<?/*=$tc['organisation_id']*/?>/<?/*=$tc['id']*/?>"><?/*=$tc['title']*/?></a></p>-->
                                        <a href="/org/course/<?=$tc['organisation_id']?>/<?=$tc['id']?>" class="icon-btn col-md-3 col-sm-3 col-xs-12">
                                            <i class="icon-graduation"></i>
                                            <div><?=$tc['title']?></div>
                                            <!--<span class="badge badge-danger">2 </span>-->
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <hr>

                        <div class="row profile-courses-row">
                            <div class="col-md-12">
                                <h4 class="bold"><?=$is_french_user ? 'Projets':'Projects' ?></h4>
                                <?php foreach($projects as $project): ?>
                                    <a href="/page/project/<?=$project['id']?>">
                                        <div class="col-md-4">
                                            <?php if( $project['image'] ): ?>
                                                <img src="<?=$project['image']?>" class="img-responsive">
                                            <?php else: ?>
                                                <img src="<?=get_default_opportunity_img()?>" class="img-responsive">
                                            <?php endif; ?>
                                            <p class="font-12px pt5"><?=$project['title']?></p>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <hr>

                        <div class="row profile-courses-row">
                            <div class="col-md-12">
                                <h4 class="bold"><?=$is_french_user ? 'Emplois publiés':'Posted Jobs' ?></h4>
                                <?php foreach($jobs as $job): ?>
                                    <a href="/page/opportunity/<?=$job['id']?>">
                                        <div class="col-md-4">
                                            <?php if( $job['image'] ): ?>
                                                <img src="<?=$job['image']?>" class="img-responsive">
                                            <?php else: ?>
                                                <img src="<?=get_default_opportunity_img()?>" class="img-responsive">
                                            <?php endif; ?>
                                            <p class="font-12px pt5"><?=$job['title']?></p>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <hr>

                        <div class="row mix-grid thumbnails">
                            <div class="col-md-12">
                                <h4 class="bold">Photos</h4>
                                <?php if($user['gallery_desc']): ?>
                                    <p style="color:#000;"><?=$user['gallery_desc']?></p>
                                <?php endif; ?>
                                <ul id="grid" class="grid cs-style-3">
                                    <?php foreach( $user['gallery'] as $img ): ?>
                                        <li class="gridPhoto">
                                            <a class="fancybox-button" rel="group" href="<?=$img['image']?>">
                                                <figure>
                                                    <img src="<?=$img['image']?>">
                                                </figure>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        <?php endif; ?>


    </div>
</div>

<?=isset($message_user_modal) ? $message_user_modal : ''?>
<?=isset($publish_post_modal) ? $publish_post_modal : ''?>

<?php if( !$is_logged_in ): ?>
    </div>
    </div>
    </div>
<?php endif; ?>