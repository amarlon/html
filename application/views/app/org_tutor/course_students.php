<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>

    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?> >
        <div class="portlet-title">
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
                            <div class="col-md-8 col-sm-9">

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

                                <div class="col-md-12 pl0 pr0 pl0">
                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="text-purple bold">STUDENT</p></div>
                                    <!--<div class="col-md-4 col-sm-6 col-xs-6"><p class="text-purple bold">SCORE</p></div>-->
                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="text-purple bold">GRADE TESTS</p></div>
                                    <div class="col-md-12"><hr></div>

                                    <?php foreach( $course_students as $cs ): ?>
                                        <div class="col-md-6">
                                            <p class="font-12px" style="padding-left:5px;">
                                                <img src="<?=$cs['student_photo']?>" style="width:50px;">
                                        <span style="padding-left:10px;display:inline-block;"><?=$cs['student_name']?></span>
                                            </p>
                                        </div>
                                        <!--<div class="col-md-4 pt14">
                                           <p>
                                               <?php /*if( $cs['final_grade'] ): */?>
                                                   <span class="bold text-green"><?/*=$cs['final_grade']*/?></span>
                                               <?php /*else: */?>
                                                   <span class="bold text-red">Not graded</span>
                                               <?php /*endif; */?>
                                           </p>
                                        </div>-->
                                        <div class="col-md-6 pt14">
                                            <input type="hidden" value="<?=$course['id']?>" class="course-id-hidden">
                                            <select class="form-control bs-select student-tests-list" data-show-subtext="true" data-student-id="<?=$cs['student_id']?>">
                                                <option selected disabled></option>
                                                <?php foreach( $course_tests as $ct ): ?>
                                                    <option value="<?=$ct['lesson_id']?>" data-icon="fa-glass icon-pencil"><?=$ct['test_title']?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12"><hr></div>
                                    <?php endforeach; ?>

                                    <?php if(!$course_students): ?>
                                        <p>No enrolments. You'll receive an email alert when students enrol in your courses,</p>
                                    <?php endif; ?>

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