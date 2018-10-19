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
                            <div class="col-md-2 col-sm-3">
                                <?=$course_page_menu?>
                            </div>
                            <div class="col-md-8 col-sm-9 course-page-right-content">

                                <div class="portlet light">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <span class="caption-subject text">Instructor</span>
                                        </div>
                                        <div class="actions">
                                            <?php if( $is_course_owner ): ?>
                                                <a href="/org_tutor/add_lesson/<?=$course['id']?>" class="btn btn-sm btn-default uppercase"><i class="fa fa-plus"></i> Add a lesson</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row">
                                            <div class="col-md-12">
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
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="text-center" style="margin:0;">Lessons</h3>
                                        <hr>

                                        <?php
                                        $controls = $is_course_owner || $is_enrolled_in_course ? 'controls' : '';
                                        ?>

                                        <?php if( !$controls ): ?>
                                            <div class="alert alert-danger col-md-12">
                                                <button class="close" data-close="alert"></button>
                                                <i class="fa fa-warning"></i>
                                                <span class="font-12px">You must be enrolled to watch lesson videos.</span>
                                            </div>
                                        <?php endif; ?>


                                    </div>
                                </div>

                                <?php $i=1; foreach( $lessons as $lesson ): ?>
                                        <?php if( !$lesson['is_deleted'] ): ?>
                                            <div class="portlet light">
                                                <div class="portlet-title">
                                                    <div class="caption">
                                                        <span class="caption-subject text"><?=$i?>. <?=$lesson['title'] ? $lesson['title'] : 'Lesson '.$i; ?></span>
                                                    </div>
                                                    <?php if( $is_course_owner ): ?>
                                                        <div class="actions">
                                                            <?php /*if( !$lesson['test_id'] ): */?><!--
                                                                <a href="/org_tutor/create_test/<?/*=$lesson['id']*/?>" class="btn btn-sm btn-primary uppercase"><i class="fa fa-plus"></i> Create a test</a>
                                                            <?php /*endif; */?>
                                                            <?php /*if( !$lesson['lesson_lectures'] ): */?>
                                                                <a href="/org_tutor/add_lectures/<?/*=$lesson['id']*/?>" class="btn btn-sm btn-primary uppercase"><i class="fa fa-plus"></i> Add lectures</a>
                                                            --><?php /*endif; */?>
                                                            <a href="javascript:" data-lesson-id="<?=$lesson['id']?>" data-course-id="<?=$course['id']?>" data-org-id="<?=$course['organisation_id']?>" class="btn btn-sm btn-primary uppercase js-hide-lesson-btn"><i class="icon-trash"></i> Remove</a>
                                                            <a href="/org_tutor/update_lesson/<?=$lesson['id']?>" class="btn btn-sm btn-default uppercase"><i class="icon-pencil"></i> Update</a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p><?=$lesson['description'] ? $lesson['description'] : 'No description.'?></p>
                                                            <hr>
                                                            <div class="row padding-top-10">
                                                                <div class="col-md-12">
                                                                    <?php if($lesson['doc']): ?>
                                                                        <div class="col-md-3">
                                                                            <p class="bold font-12px">
                                                                                <?php if( $is_enrolled_in_course || $is_course_owner ): ?>
                                                                                    <a href="<?=$lesson['doc']?>" target="_blank" class="no-text-decoration btn btn-default btn-large"><i class="icon-paper-clip"></i> Help doc</a>
                                                                                <?php else: ?>
                                                                                    <a href="" data-toggle="modal" data-target="#bs-must-enrol-modal" class="no-text-decoration btn btn-default btn-large" data-help-doc="true"><i class="icon-paper-clip"></i> Help doc</a>
                                                                                <?php endif; ?>
                                                                            </p>
                                                                        </div>

                                                                    <?php endif; ?>
                                                                    <?php if($lesson['test_id']): ?>
                                                                        <div class="col-md-9">
                                                                            <p class="bold font-12px">
                                                                                <?php if( $is_enrolled_in_course ): ?>
                                                                                    <?php if( $lesson['is_completed_lesson_test'] ): ?>
                                                                                        <a href="" style="cursor:default;" class="text-green"><i class="fa fa-check-circle"></i> You've completed the test for this lesson</a>
                                                                                        <p class="font-12px">Score: <b><?=$lesson['num_passed_questions']?></b> / <b><?=$lesson['num_questions']?></b></p>
                                                                                    <?php else: ?>
                                                                                        <a href="/account/start_lesson_test/<?=$course['id']?>/<?=$lesson['id']?>" class="no-text-decoration btn btn-default btn-large"><i class="icon-note"></i> Take the test</a>
                                                                                    <?php endif; ?>
                                                                                <?php else: ?>
                                                                                    <a href="" data-toggle="modal" data-target="#bs-must-enrol-modal" class="no-text-decoration btn btn-default btn-large"><i class="icon-note"></i> Take the test</a>
                                                                                <?php endif; ?>
                                                                            </p>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div class="col-md-9">
                                                                            <p class="font-12px"><i class="fa fa-warning color-danger"></i> No lesson test</p>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>

                                                            <hr>

                                                        </div>
                                                        <div class="col-md-12">

                                                            <?php foreach( $lesson['lesson_lectures'] as $lecture ): ?>
                                                                <div class="col-md-6 videos-grid">
                                                                    <div class="">
                                                                        <video class="img-responsive" <?=$controls?> >
                                                                            <source src="<?=$lecture['video']?>" type="video/mp4">
                                                                            Your browser does not support the video tag.
                                                                        </video>
                                                                    </div>
                                                                    <p class="font-12px padding-top-10"><?=$lecture['video_title']?></p>
                                                                </div>
                                                            <?php endforeach; ?>

                                                            <?php if( !$lesson['lesson_lectures'] ): ?>
                                                                <div class="col-md-12">
                                                                    <p class="font-12px"><i class="fa fa-warning color-danger"></i> No video lectures</p>
                                                                </div>

                                                            <?php endif; ?>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php $i++; endforeach; ?>

                                <?php if( !$lessons ): ?>
                                    <p>No results</p>
                                <?php endif; ?>

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