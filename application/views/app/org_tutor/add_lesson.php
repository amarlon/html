<div class="portlet light portlet-no-bg" style="padding-bottom:0;">
    <div class="portlet-title">
        <?=$course_breadcrumb?>
    </div>
</div>

<div class="row min-height-600">
    <div class="col-md-8">

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>
                    <span class="caption-subject bold uppercase">Add lesson</span>
                </div>
                <div class="tools">

                </div>
            </div>
            <div class="portlet-body">

                <div class="tabbable-line">


                    <div class="tab-content bs-edit-pages">
                        <div class="tab-pane active" id="tab_15_1">

                            <form class="update-details-form bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/org_tutor/add_lesson">
                                <div class="form-body">

                                    <input type="hidden" name="organisation_id" value="<?=$course['organisation_id']?>">
                                    <input type="hidden" name="course_id" value="<?=$course['id']?>">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input name="title" type="text" class="form-control" placeholder="Lesson title" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <textarea name="description" class="form-control" rows="4" placeholder="Lesson description (optional)"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-12 document-upload-wrapper">
                                            <div class="col-md-9 upload-file-container upload-video-container">
                                                <input type="file" name="file">
                                                <p class="file-input-name">Attach help document (optional)</p>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>