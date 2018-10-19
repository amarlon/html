<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>



    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?> >

        <?=$course_status_info?>

        <div class="portlet-title col-md-10">
            <?=$course_breadcrumb?>
        </div>
        <div class="portlet-body">
            <div class="row">
                <!-- BEGIN CONTENT -->
                <div class="col-md-12 col-sm-12">
                    <div class="content-page">
                        <div class="row">
                            <div class="col-md-2 col-sm-3" id="tour-course-menu">
                                <?=$course_page_menu?>
                            </div>
                            <div class="col-md-8 col-sm-9 course-page-right-content">

                                <div class="portlet light">
                                    <?php if( $is_organisation_admin || $user['is_hotshi_admin'] ): ?>
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <span class="caption-subject text"></span>
                                            </div>
                                            <div class="actions">
                                                <a href="/org_admin/edit_course/<?=$course['id']?>/<?=$course['organisation_id']?>" class="btn btn-sm btn-default uppercase"><i class="icon-pencil"></i> Edit course </a>
                                                <?php if( $user['is_hotshi_admin'] ): ?>
                                                    <a href="javascript:" class="btn btn-sm btn-warning uppercase js-delete-course-btn" data-org-id="<?=$course['organisation_id']?>" data-course-id="<?=$course['id']?>"><i class="icon-trash"></i> Delete course </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="portlet-body" id="tour-course-overview">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="/org/org_profile/<?=$course['organisation_id']?>">
                                                    <div class="col-md-2">
                                                        <img src="<?=$course['organisation_image'] ? $course['organisation_image'] : get_default_org_avatar() ?>" class="img-responsive">
                                                    </div>
                                                    <div class="col-md-10">
                                                        <p class="course-info-description bold" style="margin: 5px 0;"><?=$course['organisation_name']?></p>
                                                        <p class="course-info-description font-12px" style="color:green;"><i class="fa fa-check-circle"></i> Verified</p>
                                                    </div>
                                                </a>
                                                <div class="col-md-12">
                                                    <hr>
                                                    <p class="font-12px"><span class="bold">Cost</span>: <?=$course['cert_cost'] ? '&euro;'.$course['cert_cost']:'FREE' ?></p>
                                                    <p class="font-12px"><span class="bold">Level</span>: <?=$course['course_level']?></p>
                                                    <p class="font-12px"><span class="bold">Starts</span>: <?=date('jS M Y', strtotime($course['start_date']));?></p>
                                                    <p class="font-12px"><span class="bold">Ends</span>: <?=date('jS M Y', strtotime($course['end_date']));?></p>
                                                    <p class="font-12px"><span class="bold"><i class="fa fa-video-camera"></i> Video lectures</span>: <?=$num_course_lectures?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="portlet light" id="tour-course-introduction">
                                    <div class="portlet-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h3 class="course-info-title">Course Introduction</h3>
                                                <hr>
                                                <?php if( $course['intro_video'] ): ?>
                                                    <video class="img-responsive" controls >
                                                        <source src="<?=$course['intro_video']?>" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                <?php else: ?>
                                                    <img src="/assets/global/img/default_intro_video.jpg" class="img-responsive">
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="portlet light">
                                    <div class="portlet-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="course-info-title">About course</h3>
                                                <hr>
                                                <p class="course-info-description"><?=$course['description']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="portlet light" id="tour-course-instructor">
                                    <div class="portlet-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="course-info-title">Instructor</h3>
                                                <hr>
                                                <a href="/page/profile/<?=$course['tutor_id']?>">
                                                    <div class="col-md-2">
                                                        <img src="<?=$course['tutor_image']?>" class="img-responsive">
                                                    </div>
                                                    <div class="col-md-10">
                                                        <p class="course-info-description bold" style="margin: 5px 0;"><?=$course['tutor_name']?></p>
                                                        <p class="course-info-description font-12px"><?=$course['tutor_profession']?></p>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="margin-top-10"></div>
                                                <div class="col-md-12">
                                                    <p><?=$course['about_tutor']?></p>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT -->
            </div>
        </div>
    </div>

<?php if( !$is_logged_in ): ?>
    </div>
    </div>
    </div>
<?php endif; ?>