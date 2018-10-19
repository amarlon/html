<div class="portlet light portlet-no-bg" style="padding-bottom:0;">
    <div class="portlet-title">
        <?=$course_breadcrumb?>
    </div>
</div>

<?php
$test_grade = null;
foreach( $lesson_test_grades as $tg ) {
    if( $tg['lesson_id'] == $lesson['id'] ) {
        $test_grade = $tg;
    }
}
?>

<div class="portlet light col-md-12 padding-bottom-40">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"> Lesson: <?=$lesson['title']?></span><br>
            <div style="padding-top:10px;"></div>
            <p class="font-12px"> <i class="icon-pencil"></i> Test: <?=$lesson_test['title']?></p>
        </div>
    </div>
    <div class="portlet-body">

        <div class="row">
            <div class="col-md-12">

                <form class="update-details-form bs-update-pic-form">
                    <div class="form-body">

                        <input type="hidden" name="organisation_id" value="<?=$course['organisation_id']?>">
                        <input type="hidden" name="lesson_id" value="<?=$lesson['id']?>">

                        <?php if( $lesson_test ): ?>
                            <input type="hidden" name="lesson_test_id" value="<?=$lesson_test['id']?>">

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="font-12px" style="padding-left:5px;">
                                        <a href="/page/profile/<?=$course_student['id']?>">
                                            <img src="<?=$course_student['image']?>" style="width:110px;">
                                            <span style="padding-left:10px;display:inline-block;vertical-align:middle;" class="student-pass-fail-section-top">
                                                <?=$course_student['fullname']?>
                                                <?php if( isset($num_questions) && isset($num_passed_questions) ): ?>
                                                    <br>
                                                    <span style="color:#FF7A00;font-size:20px;">
                                                        <span style="color:#000;" class="font-12px">Scored: </span><b><?=$num_passed_questions?></b> / <b><?=$num_questions?></b>
                                                    </span>

                                                <?php endif; ?>
                                                <?php if( $test_grade ): ?>
                                                    <br>
                                                    <span class="<?=$test_grade['grade'] == 'pass' ? 'text-green':'text-red'?> font-13px bold">
                                                        <?php if( $test_grade['grade'] == 'pass' ): ?>
                                                            <i class="fa fa-check-circle"></i> Passed
                                                        <?php else: ?>
                                                            <i class="fa fa-times"></i> Failed
                                                        <?php endif; ?>
                                                    </span>

                                                <?php endif; ?>
                                            </span>
                                        </a>
                                    </p>

                                </div>
                            </div>

                            <hr>

                            <?php if( $lesson_test['questions'][0]['answers'] ): ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><b>Instructions:</b></p>
                                        <p><b>1</b>. Grading should be done after <b><?=date('jS M Y', strtotime($course['end_date']));?></b> (course end date).</p>
                                        <p><b>2</b>. Review student score.<!--compared to the <a href="/org_tutor/update_lesson/<?/*=$lesson['id']*/?>#portlet_tab4" target="_blank" class="underline">answers you provided</a> when test was created.--></p>
                                        <p><b>3</b>. Click PASS or FAIL button.</p>
                                    </div>
                                </div>

                                <hr>
                            <?php endif; ?>

                            <?php if( $lesson_test['questions'] && $lesson_test['questions'][0]['answers'] ): ?>
                                <?php $test_count=1; foreach($lesson_test['questions'] as $tq): ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <h3 class="padding-bottom-20 question-heading"><?=$test_count?>. <?=strip_tags($tq['question'])?></h3>

                                                    <?php if($tq['answers']): ?>
                                                        <input type="hidden" name="questions[qid][]" value="<?=$tq['id']?>">
                                                        <!--<a href="javascript:;" id="<?/*=$tq['id']*/?>" class="btn btn-sm btn-warning margin-bottom-10 add-answers-btn"><i class="fa fa-plus"></i> add an answer</a>-->
                                                    <?php endif; ?>


                                                    <div class="answers-input-wrapper">

                                                        <?php if($tq['answers']): ?>
                                                            <?php foreach($tq['answers'] as $answer): ?>
                                                                <div class="col-md-12 margin-bottom-10 padding-left-0 update-answers-input-wrapper-inner">
                                                                    <div class="col-md-8 col-sm-10 col-xs-10 padding-left-0">
                                                                        <p class="test-answer-p" style="<?=$test_grade ? 'background:#eee;':''?>">* <?=$answer['answer']?></p>
                                                                        <input type="hidden" name="questions[answers][<?=$answer['lesson_test_question_id']?>][answer_id][]" value="<?=$answer['id']?>">
                                                                        <input name="questions[answers][<?=$answer['lesson_test_question_id']?>][text][]" type="hidden" class="form-control" placeholder="Enter answer" value="<?=$answer['answer']?>" required="">
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-2 col-xs-2 check-answer-wrapper">
                                                                        <a href="javascript:;" class="badge badge-roundless badge-danger check-answer-badge"><label><input type="checkbox" data-checkbox="icheckbox_square-purple" <?=$answer['is_correct_answer'] ? 'checked' : '' ?> name="questions[answers][<?=$answer['lesson_test_question_id']?>][is_correct][]" value="1" class="icheck input-checkbox-show"> correct <input type="hidden" name="questions[answers][<?=$answer['lesson_test_question_id']?>][is_correct][]" value="0" <?=$answer['is_correct_answer'] ? 'disabled' : '' ?>></label></a>
                                                                    </div>
                                                                    <!--<div class="col-md-2 col-sm-2 col-xs-2 remove-answer-btn-wrapper right-align-text">
                                                                        <a href="javascript:;" class="remove-answer-input-btn"><i class="fa fa-times"></i></a>
                                                                    </div>-->
                                                                </div>

                                                            <?php endforeach; ?>

                                                        <?php endif; ?>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php $test_count++; endforeach; ?>

                                <?php if($lesson_test['questions'][0]['answers']): ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-5">
                                                    <p>Tutor feedback (optional)...</p>
                                                    <textarea class="form-control" id="tutor_comment" rows="5" placeholder="Add a feedback..." <?=$test_grade ? 'disabled' : '' ?> ><?=$test_grade['tutor_comment']?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-5">

                                                    <?php if( $test_grade ): ?>
                                                        <?php if( $test_grade['grade'] == 'pass' ): ?>
                                                            <p class="bold text-green"><i class="fa fa-check-circle"></i> Passed</p>
                                                        <?php else: ?>
                                                            <p class="bold text-red"><i class="fa fa-times"></i> Failed</p>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <a href="javascript:" class="btn btn-large-2 btn-primary uppercase grade-student-btn mr20" data-student-id="<?=$course_student['id']?>" data-grade="pass" data-organisation-id="<?=$course['organisation_id']?>" data-course-id="<?=$course['id']?>" data-lesson-id="<?=$lesson['id']?>"><i class="icon-like"></i> Pass</a>
                                                        <a href="javascript:" class="btn btn-large-2 btn-default uppercase grade-student-btn" data-student-id="<?=$course_student['id']?>" data-grade="fail" data-organisation-id="<?=$course['organisation_id']?>" data-course-id="<?=$course['id']?>" data-lesson-id="<?=$lesson['id']?>"><i class="icon-dislike"></i> Fail</a>
                                                        <i class="fa fa-spinner fa-spin"></i>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            <?php else: ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Hmmm... this student has not completed the test.</h4>
                                        <p>You can check again later, post a reminder in <a href="/org/discussions/<?=$course['organisation_id']?>/<?=$course['id']?>" class="underline">course discussions</a>, or <a href="/page/profile/<?=$course_student['id']?>" class="underline">send them a message</a>.</p>
                                        <p>Sorry about that.</p>
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php else: ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Hmmm... Something has gone wrong.</h4>
                                    <p>Try reloading page and see if that helps.</p>
                                    <p>Sorry about that.</p>
                                </div>
                            </div>

                        <?php endif; ?>


                        <hr>

                    </div>
                </form>

            </div>
        </div>


    </div>
</div>