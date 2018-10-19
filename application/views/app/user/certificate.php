<?php if( isset($_GET['download']) && $_GET['download'] ): ?>
    <input type="hidden" id="download-cert-hidden">
<?php endif; ?>

<div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?> >
    <div class="portlet-title">
        <div class="caption search-results-caption">
            <span class="caption-subject text">
                <?php if( $course_student['certified_by'] ): ?>
                    <?php if( $course_student['is_certified'] ): ?>
                        Congratulations! <br><br><i class="fa fa-star certificate-star"></i> <i class="fa fa-star certificate-star"></i> <i class="fa fa-star certificate-star"></i> <i class="fa fa-star certificate-star"></i> <i class="fa fa-star certificate-star"></i>
                    <?php else: ?>
                        We're sorry.
                    <?php endif; ?>
                <?php else: ?>
                    Certification pending.
                <?php endif; ?>

            </span>
            <div class="margin-top-20"></div>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <!-- BEGIN CONTENT -->
            <div class="col-md-12 col-sm-12">
                <div class="content-page">
                    <div class="row">



                        <div class="col-lg-12">

                            <?php if( $course_student['certified_by'] ): ?> <!-- Cert has been issued. Student will either pass or fail -->
                                <?php if( $course_student['is_certified'] ): ?> <!-- Student Passed course -->
                                    <h4>You have been awarded a <b>Certificate Of Completion</b> for <a href="/org/course/<?=$course['organisation_id']?>/<?=$course['id']?>"><?=$course['title']?></a>.</h4>
                                <?php else: ?> <!-- Student failed course -->
                                    <h4>Unfortunately you have not passed the <b><a href="/org/course/<?=$course['organisation_id']?>/<?=$course['id']?>"><?=$course['title']?></a></b> course, according to your course tutor.</h4>
                                <?php endif; ?>
                            <?php else: ?> <!-- Cert is yet to be issued -->
                                <h4>You have yet to be certified for <b><a href="/org/course/<?=$course['organisation_id']?>/<?=$course['id']?>"><?=$course['title']?></a></b>.</h4>
                            <?php endif; ?>

                            <hr>

                            <div class="portlet light bg-white p0">
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12 cert-container">

                                            <?php if( $course_student['certified_by'] ): ?> <!-- Cert has been issued. Student will either pass or fail -->
                                                <?php if( $course_student['is_certified'] ): ?> <!-- Student Passed course -->
                                                    <div class="" id="cert-section-final">
                                                        <p class="js-generate-cert">
                                                            <a href="?download=true" class="btn btn-primary btn-lg"><?= $is_french_user ? 'GÉNÉRER CERTIFICAT':'GENERATE CERTIFICATE'  ?></a>
                                                        </p>
                                                        <hr>
                                                        <p class="cert-message-section">If you have any further questions, you can <a href="/page/profile/<?=$course['tutor_id']?>" class="underline">message your course tutor</a>.</p>
                                                        <p class="cert-message-section">- or contact us at: <a href="mailto:info@hotshi.com?Subject=Hello" class="">info@hotshi.com</a>.</p>
                                                        <br class="cert-message-section">
                                                        <p class="cert-message-section"><i>Thank you for using Hotshi.</i></p>
                                                        <?php if( $course_student['tutor_comment'] ): ?>
                                                            <hr>
                                                            <p>Tutor comments: <?=$course_student['tutor_comment']?></p>
                                                        <?php endif; ?>
                                                        <div class="js-cert-wrapper hide-elem">
                                                            <p class="certificate-dynamic certificate-fullname"><?=$user['fullname']?></p>
                                                            <p class="certificate-dynamic certificate-organisation-name uppercase">By: <?=$organisation['name']?></p>
                                                            <p class="certificate-dynamic certificate-course-title uppercase"><?=$course['title']?></p>
                                                            <p class="certificate-dynamic certificate-date"><?=date('d/m/Y')?></p>
                                                            <p class="certificate-dynamic certificate-tutor"><?=$tutor['fullname']?></p>
                                                            <img src="/assets/admin/layout3/img/certificate_blank.png?v=<?=FILE_VERSION?>" class="cert-img" style="width:100%;">
                                                        </div>

                                                    </div>
                                                <?php else: ?> <!-- Student Failed course -->
                                                    <p>Nothing to worry about. You can simply enroll again on the next enrolment dates.</p>
                                                    <p>If you have any questions in the mean time, you can <a href="/page/profile/<?=$course['tutor_id']?>" class="underline">message your course tutor</a></p>
                                                    <p>- or contact us at: <a href="mailto:info@hotshi.com?Subject=Hello" class="underline">info@hotshi.com</a>.</p>
                                                    <br><br>
                                                    <p><i>Thank you for using Hotshi.</i></p>
                                                    <?php if( $course_student['tutor_comment'] ): ?>
                                                        <hr>
                                                        <p>Tutor comments: <?=$course_student['tutor_comment']?></p>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php else: ?> <!-- Cert is yet to be issued -->
                                                <div class="col-lg-8 p0">
                                                    <p>Your cert will be displayed here sometime after <b><?=date('jS M Y', strtotime($course['end_date']));?></b> (course end date). You'll receive an email once available.</p>
                                                    <p>If you have any questions in the mean time, you can <a href="/page/profile/<?=$course['tutor_id']?>" class="underline">message your course tutor</a>, or if you've completed this course in the past and would like a copy of your previous certificates, then send an email to <a href="mailto:info@hotshi.com?Subject=Hello" class="bold underline">info@hotshi.com</a>.</p>
                                                    <p>- or contact us at: <a href="mailto:info@hotshi.com?Subject=Hello" class="underline">info@hotshi.com</a> for other enquiries.</p>
                                                </div>
                                            <?php endif; ?>

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