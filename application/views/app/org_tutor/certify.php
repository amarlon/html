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
                        <div class="col-md-9 col-sm-9">

                            <h3>Certify course students</h3>
                            <p>The below certificate template has been generated for you by Hotshi.</p>
                            <p>You can find your list of students below. Simply click the - <b>approve</b> - button to issue a certificate for each student.</p>

                            <hr>

                            <div class="portlet light bg-white p0">
                                <!--<div class="portlet-title">
                                    <div class="caption text-center" style="width:100%;">
                                        <span class="caption-subject text bold"><i class="icon-badge"></i> Certificate template</span>
                                    </div>
                                </div>-->
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <img src="/assets/admin/layout3/img/certificate.png?v=<?=FILE_VERSION?>" style="width: 100%;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-scrollable table-scrollable-borderless">
                                <table class="table table-hover table-light students-table">
                                    <thead>
                                    <tr class="uppercase">
                                        <th colspan="2">
                                            STUDENT
                                        </th>
                                        <!--<th>
                                            GRADE
                                        </th>
                                        <th>
                                            COMMENTS
                                        </th>-->
                                        <th>COURSE</th>
                                        <th>PASSED</th>
                                        <th>APPROVE</th>
                                        <th>DISAPPROVE</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach( $course_students as $student ): ?>
                                        <tr>
                                            <td class="fit">
                                                <img class="user-pic" src="<?=$student['student_photo']?>">
                                            </td>
                                            <td>
                                                <a href="javascript:;" class=""><?=$student['student_name']?></a>
                                            </td>
                                            <td>
                                                <p><?=$student['course_title']?> lessons</p>
                                            </td>
                                            <td>
                                                <p><?=$student['student_lesson_score']?> lessons</p>
                                            </td>
                                            <!--<td>
                                                <span><?/*=$student['final_grade']*/?></span>
                                            </td>-->
                                            <!--<td>
                                                <?/*=$student['tutor_comment']*/?>
                                            </td>-->
                                            <td class="">
                                                <?php if( $student['is_certified'] ): ?>
                                                    <p class="bold theme-font"><i class="fa fa-check-circle"></i> Certified</p>
                                                <?php else: ?>
                                                    <a href="javascript:" data-student-id="<?=$student['student_id']?>" data-course-id="<?=$student['course_id']?>" data-organisation-id="<?=$course['organisation_id']?>" class="btn btn-large btn-primary uppercase certify-btn"><i class="icon-like"></i> Approve</a>
                                                    <i class="fa fa-spinner fa-spin text-center"></i>
                                                <?php endif; ?>

                                            </td>
                                            <td class="">
                                                <?php if( $student['is_certified'] ): ?>
                                                    <p class="bold theme-font"><i class="fa fa-check-circle"></i> Passed</p>
                                                <?php elseif( $student['is_failed'] ): ?>
                                                    <p class="bold text-red failed-course-text"><i class="fa fa-times"></i> Failed</p>
                                                <?php else: ?>
                                                    <a href="javascript:" class="btn btn-default btn-large failed-course-btn uppercase" data-student-id="<?=$student['student_id']?>" data-course-id="<?=$student['course_id']?>" data-organisation-id="<?=$course['organisation_id']?>"><i class="icon-dislike"></i> Disapprove</a>
                                                    <i class="fa fa-spinner fa-spin text-center"></i>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
 </div>