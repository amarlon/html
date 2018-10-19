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
                    <span class="caption-subject bold uppercase"><?=$lesson['title']?></span>
                    <span class="caption-helper"> <i class="fa fa-angle-right"></i> upload lecture videos</span>
                </div>
            </div>
            <div class="portlet-body">

                <div class="tabbable-line">

                    <div class="tab-content bs-edit-pages">
                        <div class="tab-pane active add-lecture-form-wrapper" id="tab_15_1">

                            <form class="update-details-form bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/org_tutor/add_lecture">
                                <div class="form-body">

                                    <input type="hidden" name="organisation_id" value="<?=$course['organisation_id']?>">
                                    <input type="hidden" name="lesson_id" value="<?=$lesson['id']?>">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input name="title" type="text" class="form-control" placeholder="Video title" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row video-process-message hide-elem">
                                        <div class="col-lg-12">
                                            <h4>Please do not refresh web page while we process your video. </h4>
                                            <p class="text-red">Click <b>Upload</b> to begin.</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 video-upload-wrapper">
                                            <div class="col-md-9 upload-file-container upload-video-container">
                                                <input type="file" name="file" accept="video/*">
                                                <p class="file-input-name">Select video</p>
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
                                                    <button type="submit" class="btn btn-primary upload-btn-hidden hide-elem"><i class="icon-cloud-upload"></i> Upload</button>
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