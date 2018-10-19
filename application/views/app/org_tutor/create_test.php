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
                    <span class="caption-subject bold uppercase"><?=$lesson['title']?></span>
                    <!--<span class="caption-helper"><i class="fa fa-angle-right"></i> create test</span>-->
                </div>
                <div class="tools">

                </div>
            </div>

            <div class="portlet-body">
                <form class="update-details-form bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/org_tutor/create_test">
                    <div class="form-wizard">
                        <div class="form-body">
                            <input type="hidden" name="organisation_id" value="<?=$course['organisation_id']?>">
                            <input type="hidden" name="lesson_id" value="<?=$lesson['id']?>">

                            <ul class="nav nav-pills nav-justified steps">

                                <li>
                                    <a href="#tab1" data-toggle="tab" class="step">
                                        <span class="number">1 </span>
                                        <span class="desc"><i class="fa fa-check"></i> Create test </span>
                                    </a>
                                </li>

                                <li>
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
                                <div class="progress-bar progress-bar-warning add-test-progress-bar" style="width: 30%;">
                                </div>
                            </div>


                            <div class="tab-content bs-edit-pages">

                                <div class="tab-pane active" id="tab1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input name="title" type="text" class="form-control" placeholder="Test title" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <textarea name="description" class="form-control" rows="4" placeholder="Test description (optional)"></textarea>
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
                                                    <button type="submit" class="btn btn-lg btn-primary">Next <i class="fa fa-arrow-right"></i></button>
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