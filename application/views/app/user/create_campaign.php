<div class="portlet light portlet-no-bg" style="padding-bottom:0;">
    <div class="portlet-title">
        <div class="caption search-results-caption">
            <span class="caption-subject text">Create Email Campaign</span>
            <div class="margin-top-20"></div>
        </div>
    </div>
</div>

<div class="row min-height-600">
    <div class="col-md-8">

        <div class="portlet light">

            <div class="portlet-body">

                <div class="tabbable-line">


                    <div class="tab-content bs-edit-pages">
                        <div class="tab-pane active" id="tab_15_1">

                            <form class="update-details-form bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/account/create_campaign">
                                <div class="form-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <label class="control-label font-12px">Send to...</label>
                                                    <select class="form-control" name="send_to" required>
                                                        <option selected disabled></option>
                                                        <option>Students</option>
                                                        <option>Organisations</option>
                                                        <option>All users</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <label class="control-label font-12px">Email subject</label>
                                                    <input name="subject" type="text" class="form-control" placeholder="Email Subject" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <label class="control-label font-12px">Email content</label>
                                                    <textarea name="description" class="form-control" rows="20" placeholder="Email content" required=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <label class="control-label font-12px">CTA Link (optional)</label>
                                                    <input name="cta_link" type="text" class="form-control" placeholder="CTA Link">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!--<div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-10">
                                                    <p class="font-12px">Attach Image (optional):</p>
                                                    <input type="file" id="file" name="file" accept=".png, .jpg, .jpeg">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>-->

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