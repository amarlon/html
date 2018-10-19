<div class="portlet light portlet-no-bg" style="padding-bottom:0;">
    <div class="portlet-title">
        <?=$articles_breadcrumb?>
    </div>
</div>

<div class="row min-height-600">
    <div class="col-md-8">

        <div class="portlet light">

            <div class="portlet-body">

                <div class="tabbable-line">


                    <div class="tab-content bs-edit-pages">
                        <div class="tab-pane active" id="tab_15_1">

                            <form class="update-details-form bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/account/create_article">
                                <div class="form-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input name="title" type="text" class="form-control" placeholder="Article title" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <textarea name="description" class="form-control" rows="10" placeholder="Article content" required=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-12 document-upload-wrapper">
                                            <div class="col-md-9 upload-file-container upload-video-container">
                                                <input type="file" name="file">
                                                <p class="file-input-name">Attach heading image (optional)</p>
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