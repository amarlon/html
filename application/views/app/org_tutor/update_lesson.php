<div class="portlet light portlet-no-bg" style="padding-bottom:0;">
    <div class="portlet-title">
        <?=$course_breadcrumb?>
    </div>
</div>

<div class="portlet light col-md-10 padding-bottom-40">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase">Update Lesson</span><br>
            <div style="padding-top:10px;"></div>
        </div>
    </div>
    <div class="portlet-body">

        <div class="portlet-tabs">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#portlet_tab1" data-toggle="tab"><i class="icon-note"></i> Lesson</a>
                </li>
                <li class="">
                    <a href="#portlet_tab2" data-toggle="tab"><i class="icon-doc"></i> Doc</a>
                </li>
                <li class="">
                    <a href="#portlet_tab3" data-toggle="tab"><i class="fa fa-video-camera"></i> Lectures</a>
                </li>

                <li class="">
                    <a href="#portlet_tab4" data-toggle="tab"><i class="fa fa-edit"></i> Test</a>
                </li>

            </ul>

            <div class="margin-top-30"></div>

            <div class="tab-content bs-edit-pages">

                <div class="tab-pane active" id="portlet_tab1">

                    <form class="update-details-form bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/org_tutor/update_lesson">
                        <div class="form-body">

                            <input type="hidden" name="organisation_id" value="<?=$course['organisation_id']?>">
                            <input type="hidden" name="lesson_id" value="<?=$lesson['id']?>">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <input name="title" type="text" class="form-control" placeholder="Lesson title" value="<?=$lesson['title']?>" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <textarea name="description" class="form-control" rows="4" placeholder="Lesson description (optional)"><?=strip_tags($lesson['description'])?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

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
                                            <button type="submit" class="btn btn-primary">Save</button>
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                        </div>
                    </form>

                </div>

                <div class="tab-pane" id="portlet_tab2">

                    <form role="form" class="bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/org_tutor/update_lesson_doc">

                        <input type="hidden" name="organisation_id" id="organisation-id" value="<?=$course['organisation_id']?>">
                        <input type="hidden" name="lesson_id" id="lesson-id" value="<?=$lesson['id']?>">

                        <!--<div class="row">
                            <div class="col-md-3 col-sm-3">
                                <img src="<?/*=$article['image'] ? $article['image'] : get_default_post_img() */?>" alt="" class="img-responsive">
                            </div>
                        </div>-->

                        <div style="padding-top:30px;"></div>

                        <div class="row">
                            <div class="col-md-12 document-upload-wrapper">
                                <div class="col-md-9 upload-file-container">
                                    <input type="file" name="file">
                                    <p class="file-input-name"><?=$lesson['doc'] ? 'Update help document':'Attach help document (optional)' ?></p>
                                </div>
                            </div>
                        </div>

                        <hr>

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
                                        <?php if( $lesson['doc'] ): ?>
                                            <a href="" class="btn btn-warning delete-img-btn delete-lesson-doc"><i class="fa fa-trash"></i> Remove</a>
                                        <?php endif; ?>
                                        <button type="submit" class="btn btn-primary <?=$lesson['doc'] ? 'hide-save-button':'' ?>" data-dismiss="modal">Save</button>
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>


                <div class="tab-pane" id="portlet_tab3">

                    <div class="margin-top-30"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <p>You can upload multiple video lectures for this lesson.</p>
                            <div class="margin-top-20"></div>
                            <a href="/org_tutor/add_lectures/<?=$lesson['id']?>" class="btn btn-warning"><i class="fa fa-plus"></i> Add video lectures</a>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">

                            <?php foreach( $lesson['lesson_lectures'] as $lecture ): ?>
                                <div class="col-md-4 videos-grid">
                                    <div class="">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle video-options-btn" type="button" data-toggle="dropdown">.<br>.<br>.</button>
                                            <ul class="dropdown-menu">
                                                <li><a href="javascript:" class="delete-img-btn delete-lecture-vid" data-organisation-id="<?=$course['organisation_id']?>" data-lesson-id="<?=$lesson['id']?>" data-video-id="<?=$lecture['id']?>" data-vid-public-id="<?=$lecture['video_public_id']?>">Delete video</a></li>
                                            </ul>
                                        </div>
                                        <video class="img-responsive"  >
                                            <source src="<?=$lecture['video']?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                    <p class="font-12px padding-top-10"><?=$lecture['video_title']?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="portlet_tab4">

                    <div class="margin-top-20"></div>

                    <form class="update-details-form bs-update-pic-form form-ajax input-custom" enctype="multipart/form-data" action="/ajax/org_tutor/update_tutor_test_answers">
                        <div class="form-body">

                            <input type="hidden" name="organisation_id" value="<?=$course['organisation_id']?>">
                            <input type="hidden" name="lesson_id" value="<?=$lesson['id']?>">

                            <?php if( $lesson_test ): ?>
                                <input type="hidden" name="lesson_test_id" value="<?=$lesson_test['id']?>">

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4><i class="icon-pencil"></i> <?=$lesson_test['title']?></h4>
                                    </div>
                                </div>

                                <hr>

                                <?php if( $lesson_test['questions'] ): ?>
                                    <?php $test_count=1; foreach($lesson_test['questions'] as $tq): ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-8">
                                                        <h3 class="padding-bottom-20"><?=$test_count?>. <?=strip_tags($tq['question'])?></h3>

                                                        <?php if($tq['answers']): ?>
                                                            <input type="hidden" name="questions[qid][]" value="<?=$tq['id']?>">
                                                            <!--<a href="javascript:;" id="<?/*=$tq['id']*/?>" class="btn btn-sm btn-warning margin-bottom-10 add-answers-btn"><i class="fa fa-plus"></i> add an answer</a>-->
                                                        <?php endif; ?>


                                                        <div class="answers-input-wrapper">

                                                            <?php if($tq['answers']): ?>
                                                                <?php foreach($tq['answers'] as $answer): ?>
                                                                    <div class="col-md-12 margin-bottom-10 padding-left-0 update-answers-input-wrapper-inner">
                                                                        <div class="col-md-8 col-sm-10 col-xs-10 padding-left-0">
                                                                            <input type="hidden" name="questions[answers][<?=$answer['lesson_test_question_id']?>][answer_id][]" value="<?=$answer['id']?>">
                                                                            <input name="questions[answers][<?=$answer['lesson_test_question_id']?>][text][]" type="text" class="form-control" placeholder="Enter answer" value="<?=$answer['answer']?>" required="">
                                                                        </div>
                                                                        <div class="col-md-2 col-sm-2 col-xs-2 check-answer-wrapper">
                                                                            <a href="javascript:;" class="badge badge-roundless badge-danger check-answer-badge"><label><input type="checkbox" data-checkbox="icheckbox_square-purple" <?=$answer['is_correct_answer'] ? 'checked' : '' ?> name="questions[answers][<?=$answer['lesson_test_question_id']?>][is_correct][]" value="1" class="icheck input-checkbox-show"> correct <input type="hidden" name="questions[answers][<?=$answer['lesson_test_question_id']?>][is_correct][]" value="0" <?=$answer['is_correct_answer'] ? 'disabled' : '' ?>></label></a>
                                                                        </div>
                                                                        <!--<div class="col-md-2 col-sm-2 col-xs-2 remove-answer-btn-wrapper right-align-text">
                                                                            <a href="javascript:;" class="remove-answer-input-btn"><i class="fa fa-times"></i></a>
                                                                        </div>-->
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <a href="/org_tutor/add_test_question_answers/<?=$lesson['id']?>" class="btn btn-warning"><i class="fa fa-plus"></i> Create answers</a>
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
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        <i class="fa fa-spinner fa-spin"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="/org_tutor/add_test_questions/<?=$lesson['id']?>" class="btn btn-warning"><i class="fa fa-plus"></i> Add questions</a>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            <?php else: ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Enrolled students will be graded based on this test.</p>
                                        <div class="margin-top-20"></div>
                                        <a href="/org_tutor/create_test/<?=$lesson['id']?>" class="btn btn-warning"><i class="fa fa-plus"></i> Create a test</a>
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
</div>