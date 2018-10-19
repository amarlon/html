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
                    <!--<span class="caption-helper"><i class="fa fa-angle-right"></i> add questions</span>-->
                </div>
                <!--<div class="actions">
                    <a href="javascript:;" class="btn btn-sm btn-danger uppercase" id="add-question-btn"><i class="fa fa-plus"></i> Add another question</a>
                </div>-->
            </div>

            <div class="portlet-body">
                <form class="update-details-form bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/org_tutor/add_test_questions">
                    <div class="form-wizard">
                        <div class="form-body">
                            <input type="hidden" name="organisation_id" value="<?=$course['organisation_id']?>">
                            <input type="hidden" name="lesson_id" value="<?=$lesson['id']?>">

                            <ul class="nav nav-pills nav-justified steps">

                                <li class="done">
                                    <a href="#tab1" data-toggle="tab" class="step">
                                        <span class="number">1 </span>
                                        <span class="desc"><i class="fa fa-check"></i> Create test </span>
                                    </a>
                                </li>

                                <li class="active">
                                    <a href="#tab2" data-toggle="tab" class="step">
                                        <span class="number">2 </span>
                                        <span class="desc"><i class="fa fa-check"></i> Add questions </span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#tab3" data-toggle="tab" class="step">
                                        <span class="number">3 </span>
                                        <span class="desc"><i class="fa fa-check"></i> Add answers </span>
                                    </a>
                                </li>

                            </ul>

                            <div id="bar" class="progress active progress-striped" role="progressbar">
                                <div class="progress-bar progress-bar-warning add-test-progress-bar" style="width: 60%;">
                                </div>
                            </div>

                            <div class="tab-content bs-edit-pages">

                                <div class="tab-pane active" id="tab1">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-9">
                                                    <h4>Add multiple questions by clicking the <b>+add another question</b> button.</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="questions-input-row-wrapper">
                                        <div class="row question-input-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-8">
                                                        <div class="col-md-10 col-sm-10 col-xs-10 padding-left-0">
                                                            <!--<input name="questions[]" type="text" class="form-control" placeholder="Enter question" required="">-->
                                                            <textarea name="questions[]" class="form-control" rows="3" placeholder="Enter a question" required=""></textarea>
                                                        </div>

                                                        <div class="col-md-2 col-sm-2 col-xs-2 remove-btn-wrapper">
                                                            <a href="javascript:;" class="remove-btn-badge remove-question-btn"><i class="fa fa-times"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <a href="javascript:;" class="btn btn-sm btn-warning uppercase" id="add-question-btn"><i class="fa fa-plus"></i> Add another question</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>



                            <div class="row submit-questions-btn-row">
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
                                            <button type="submit" class="btn btn-primary">Next <i class="fa fa-arrow-right"></i></button>
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>