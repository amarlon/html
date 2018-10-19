<div class="portlet light portlet-no-bg" style="padding-bottom:0;">
    <div class="portlet-title">
        <?=$course_breadcrumb?>
    </div>
</div>

<div class="row min-height-600">
    <div class="col-md-10">

        <div class="portlet light" id="form_wizard_1">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase"><?=$lesson['test_title']?></span>
                </div>
                <div class="tools">

                </div>
            </div>
            <div class="portlet-body">

                <div class="col-md-12 margin-bottom-10 padding-left-0 answers-input-wrapper-inner">
                    <div class="col-md-8 col-sm-10 col-xs-10 padding-left-0">
                        <input name="" type="text" class="form-control" placeholder="Enter answer" required="">
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 check-answer-wrapper">
                        <a href="javascript:;" class="badge badge-roundless badge-danger check-answer-badge"><label><input type="checkbox" data-checkbox="icheckbox_square-purple" name="" value="1" class="icheck"> correct <input type="hidden" name="" value="0"></label></a>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 remove-answer-btn-wrapper right-align-text">
                        <a href="javascript:;" class="remove-answer-input-btn"><i class="fa fa-times"></i></a>
                    </div>
                </div>

                <form class="update-details-form bs-update-pic-form form-ajax input-custom" enctype="multipart/form-data" action="/ajax/org_tutor/add_tutor_test_answers">
                    <div class="form-wizard">
                        <div class="form-body">

                            <input type="hidden" name="organisation_id" value="<?=$course['organisation_id']?>">
                            <input type="hidden" name="lesson_id" value="<?=$lesson['id']?>">
                            <input type="hidden" name="lesson_test_id" value="<?=$lesson_test['id']?>">

                            <ul class="nav nav-pills nav-justified steps">

                                <li class="done">
                                    <a href="#tab1" data-toggle="tab" class="step">
                                        <span class="number">1 </span>
                                        <span class="desc"><i class="fa fa-check"></i> Create test </span>
                                    </a>
                                </li>

                                <li class="done">
                                    <a href="#tab2" data-toggle="tab" class="step">
                                        <span class="number">2 </span>
                                        <span class="desc"><i class="fa fa-check"></i> Add questions </span>
                                    </a>
                                </li>

                                <li class="active">
                                    <a href="#tab3" data-toggle="tab" class="step">
                                        <span class="number">3 </span>
                                        <span class="desc"><i class="fa fa-check"></i> Add answers </span>
                                    </a>
                                </li>

                            </ul>

                            <div id="bar" class="progress active progress-striped" role="progressbar">
                                <div class="progress-bar progress-bar-warning add-test-progress-bar" style="width: 100%;">
                                </div>
                            </div>

                            <div class="tab-content bs-edit-pages">

                                <div class="tab-pane active" id="tab1">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-9">
                                                    <h4>Add multiple answers for each question by clicking the <b>+add answers</b> button.</h4>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <?php foreach($lesson_test['questions'] as $tq): ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-8">
                                                        <h3 class="padding-bottom-20 question-heading"><?=$tq['question']?></h3>
                                                        <input type="hidden" name="questions[qid][]" value="<?=$tq['id']?>">

                                                        <div class="answers-input-wrapper"></div>

                                                        <a href="javascript:;" id="<?=$tq['id']?>" class="btn btn-sm btn-warning margin-bottom-10 add-answers-btn"><i class="fa fa-plus"></i> add answers</a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    <?php endforeach; ?>

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

                            </div>

                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>