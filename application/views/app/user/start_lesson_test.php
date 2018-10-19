<div class="portlet light portlet-no-bg" style="padding-bottom:0;">
    <div class="portlet-title">
        <?=$course_breadcrumb?>
    </div>
</div>

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

                <form class="update-details-form bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/account/add_student_test_answers">
                    <div class="form-body">

                        <input type="hidden" name="organisation_id" value="<?=$course['organisation_id']?>">
                        <input type="hidden" name="lesson_id" value="<?=$lesson['id']?>">

                        <?php if( $lesson_test ): ?>
                            <input type="hidden" name="lesson_test_id" value="<?=$lesson_test['id']?>">

                            <div class="row">
                                <div class="col-md-12 text-red">
                                    <p><b>Instructions:</b></p>
                                    <p><b>1</b>. This test can only be taken once.</p>
                                    <p><b>2</b>. You must answer all questions before saving, and once you save it cannot be undone.</p>
                                    <p><b>3</b>. Tick the boxes beside the correct answer (you can select multiple answers!).</p>
                                    <p><b>4</b>. Test must be completed before <b><?=date('jS M Y', strtotime($course['end_date']));?></b> (course end date).</p>
                                    <br>
                                    <p class="bold text-black">Good luck :)</p>
                                </div>
                            </div>

                            <hr>

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
                                                                        <p class="test-answer-p">* <?=$answer['answer']?></p>
                                                                        <input type="hidden" name="questions[answers][<?=$answer['lesson_test_question_id']?>][answer_id][]" value="<?=$answer['id']?>">
                                                                        <input name="questions[answers][<?=$answer['lesson_test_question_id']?>][text][]" type="hidden" class="form-control" placeholder="Enter answer" value="<?=$answer['answer']?>" required="">
                                                                    </div>
                                                                    <div class="col-md-2 col-sm-2 col-xs-2 check-answer-wrapper">
                                                                        <a href="javascript:;" class="badge badge-roundless badge-danger check-answer-badge"><label><input type="checkbox" data-checkbox="icheckbox_square-purple" name="questions[answers][<?=$answer['lesson_test_question_id']?>][is_correct][]" value="1" class="icheck input-checkbox-show"> correct <input type="hidden" name="questions[answers][<?=$answer['lesson_test_question_id']?>][is_correct][]" value="0"></label></a>
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
                                                <div class="col-md-8">
                                                    <div class="alert alert-danger form-error display-hide">
                                                        <a href="" class="close" data-close="alert"></a>
                                                        <span></span>
                                                    </div>
                                                    <div class="alert alert-success form-success display-hide">
                                                        <a href="" class="close" data-close="alert"></a>
                                                        <span></span>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-large">Save</button>
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            <?php else: ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Hmmm... Something has gone wrong.</h4>
                                        <p>Seems your tutor has not created questions for this test. Try again in a little bit.</p>
                                        <p>Sorry about that.</p>
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php else: ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Hmmm... Something has gone wrong.</h4>
                                    <p>Seems your tutor has not created a test for this lesson. Try again in a little bit.</p>
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