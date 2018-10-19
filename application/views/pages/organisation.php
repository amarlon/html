<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>

<div style="<?=$is_logged_in ? 'margin-top:30px;' : 'margin-top:100px;'?>"></div>

    <style>
        .posts-feed-col{
            margin-left: 50px;
        }

        @media (max-width: 991px){
            .posts-feed-col{
                margin-left: 0;
            }
        }
    </style>

    <div class="row margin-top-10" style="min-height:600px;">
        <div class="col-md-12">

            <div class="profile-sidebar col-md-3">

                <div class="portlet profile-sidebar-portlet">
                    <div class="profile-userpic">
                        <img src="<?=$organisation['profile_image'] ? $organisation['profile_image'] : get_default_org_avatar(); ?>" class="img-responsive" alt="">
                    </div>
                </div>

                <?php if( $this->session->userdata('id') ): ?>
                    <div class="profile-userbuttons">
                        <?php if( $org_admin_id != $this->session->userdata('id') ): ?>
                            <a href="" class="btn btn-default" data-toggle="modal" data-target="#bs-msg-user-modal"> <i class="fa fa-envelope"></i> Message</a>
                        <?php endif; ?>
                        <a href="javascript:" data-org-name="<?=$organisation['name']?>" data-org-id="<?=$organisation['id']?>" class="btn <?=$organisation['is_following'] ? 'btn-default js-unfollow-org':'btn-primary js-follow-org'  ?>"> <?=$organisation['is_following'] ? '<i class="icon-users"></i> Unfollow ('.$organisation['num_followers'].')':'<i class="icon-users"></i> Follow ('.$organisation['num_followers'].') ' ?></a>
                    </div>
                <?php endif; ?>

                <br>
                <?php if( $is_french_user ): ?>
                    <hr>
                    <p class="course-level-list"><a href="/org/org_profile/<?=$org_admin_id?>?posts">- <?=$org_admin_id == $this->session->userdata('id') ? 'Mes publications' : ''.$organisation['name'].'\'s publications' ?></a></p>
                <?php else: ?>
                    <hr>
                    <p class="course-level-list"><a href="/org/org_profile/<?=$org_admin_id?>?posts">- <?=$org_admin_id == $this->session->userdata('id') ? 'My Posts' : ''.$organisation['name'].'\'s Posts' ?></a></p>
                <?php endif; ?>

                <?php if( $is_french_user ): ?>
                    <hr>
                    <p class="course-level-list"><a href="/page/articles/<?=$org_admin_id?>">- <?=$org_admin_id == $this->session->userdata('id') ? 'Mes articles' : ''.$organisation['name'].'\'s articles' ?></a></p>
                <?php else: ?>
                    <hr>
                    <p class="course-level-list"><a href="/page/articles/<?=$org_admin_id?>">- <?=$org_admin_id == $this->session->userdata('id') ? 'My Articles' : ''.$organisation['name'].'\'s Articles' ?></a></p>
                <?php endif; ?>

                <?php if($organisation['institution_name']): ?>
                    <hr>
                    <h4>Institution</h4>
                    <div class="margin-top-20 profile-desc-link">
                        <i class="fa fa-bank"></i>
                        <a href="javascript:;"><?=$organisation['institution_name']?></a>
                    </div>
                <?php endif; ?>

                <hr>
                <h5>Location</h5>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-map-marker"></i>
                    <a href="javascript:;"><?=$organisation['country_name']?></a>
                </div>

                <hr>
                <h5>Website</h5>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-globe"></i>
                    <?php if( strpos($organisation['website'], "http://") == false || strpos($organisation['website'], "https://") == false ): ?>
                        <a href="<?='http://'.$organisation['website']?>" target="_blank" class="website"><?=$organisation['website']?></a>
                    <?php else: ?>
                        <a href="<?=$organisation['website']?>" target="_blank" class="website"><?=$organisation['website']?></a>
                    <?php endif; ?>
                </div>

                <?php if( $thisuser['is_hotshi_admin'] ): ?>
                    <hr>
                    <a href="/account/login_u_admin?e=<?=$organisation['email']?>" class="btn btn-warning" style="cursor:pointer !important;">Login as</a>
                    <hr>
                <?php endif; ?>

            </div>

            <?php if( $posts ): ?>

                <?=$posts_feed?>

            <?php else: ?>

                <div class="col-md-9 bs-profile-info-right">

                    <div class="portlet light" style="background:none;">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bs-feed-title uppercase" style="font-size:25px;font-weight:400;"><?=$organisation['name']?></span>
                            </div>

                            <?php if( $is_organisation_admin  ): ?>
                                <div class="actions">
                                    <a href="/org_admin/edit_org/<?=$organisation['id']?>" id="tour-manage-org" class="btn btn-default uppercase btn-sm"><i class="icon-pencil"></i> Manage organisation </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row padding-bottom-10">
                        <div class="col-md-12">
                            <h4 class="bold"><?=$is_french_user ? 'À propos':'About' ?></h4>
                            <p><?=$organisation['about'] ? $organisation['about'] : '---'?></p>
                        </div>
                    </div>

                    <div class="portlet light" id="tour-org-intro">
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h3 class="course-info-title">Introduction</h3>
                                    <hr>
                                    <?php if( $organisation['intro_video'] ): ?>
                                        <video class="img-responsive" controls >
                                            <source src="<?=$organisation['intro_video']?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else: ?>
                                        <img src="/assets/global/img/default_intro_video.jpg" class="img-responsive">
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="portlet light" id="tour-org-tutors">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bs-feed-title bold"><i class="icon-users"></i> <?=$is_french_user ? 'Équipe':'Team' ?></span>
                            </div>
                            <?php if( $is_organisation_admin  ): ?>
                                <div class="actions">
                                    <a href="/org_admin/edit_org/<?=$organisation['id']?>#tab_15_4" class="btn btn-default uppercase btn-sm"><i class="icon-plus"></i> <?=$is_french_user ? 'AJOUTER DES MEMBRES':'Add users' ?> </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="portlet-body">
                            <?php foreach( $tutors as $tutor ): ?>
                                <a href="/page/profile/<?=$tutor['user_id']?>"><img src="<?=$tutor['image']?>" class="bs-new-users-img tooltips" data-placement="top" data-original-title=""></a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="portlet light" id="tour-manager-courses">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bs-feed-title bold"><i class="icon-graduation"></i> <?=$is_french_user ? 'Cours':'Courses' ?></span>
                            </div>
                            <div class="actions">
                                <?php if( $is_organisation_admin ): ?>
                                    <a href="/org_admin/add_course/<?=$organisation['id']?>" class="btn btn-default uppercase btn-sm"><i class="fa fa-plus"></i> <?=$is_french_user ? 'CRÉER UN NOUVEAU COURS':'Create new course' ?> </a>
                                <?php endif; ?>
                                <?php if( $user['is_hotshi_admin'] ): ?>
                                    <?php if( $organisation['can_create_course'] ): ?>
                                        <button class="btn btn-danger uppercase btn-sm toggle_course_creation_status" data-org-id="<?=$organisation['id']?>" data-api="disable_course_creation"><i class="fa fa-times"></i> Disable course creation</button>
                                    <?php else: ?>
                                        <button class="btn btn-success uppercase btn-sm toggle_course_creation_status" data-org-id="<?=$organisation['id']?>" data-api="enable_course_creation"><i class="fa fa-check"></i> Enable course creation</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="portlet-body">
                            <?php if( $organisation_courses ): ?>
                                <div class="row">
                                    <?php foreach( $organisation_courses as $course ): ?>

                                        <a href="/org/course/<?=$organisation['id']?>/<?=$course['id']?>">
                                            <div class="col-md-4 videos-grid">

                                                <?php if( $course['intro_video'] ): ?>
                                                    <video class="img-responsive"  >
                                                        <source src="<?=$course['intro_video']?>" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                <?php else: ?>
                                                    <img src="/assets/global/img/default_intro_video.jpg" class="img-responsive">
                                                <?php endif; ?>
                                                <p class="font-12px padding-top-10"><?php if( $is_organisation_admin && (!$course['can_enrol'] || $course['end_date'] < date('Y-m-d') ) ): ?><i class="fa fa-warning"></i> (expired) - <?php endif; ?> <?=$course['title']?></p>
                                            </div>
                                        </a>

                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <?php if( $user['id'] == $this->session->userdata('id') ): ?>

                                <?php else: ?>
                                    <p>No courses.</p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>


                    </div>

                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bs-feed-title bold"><i class="icon-list"></i> <?=$is_french_user ? 'Projets':'Projects' ?></span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
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
                        </div>
                    </div>

                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject bs-feed-title bold"><i class="icon-list"></i> <?=$is_french_user ? 'Emplois publiés':'Posted Jobs' ?></span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
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
                        </div>
                    </div>



                </div>

            <?php endif; ?>

        </div>
    </div>

<?=isset($message_user_modal) ? $message_user_modal : ''?>

<?php if( !$is_logged_in ): ?>
    </div>
    </div>
    </div>
<?php endif; ?>