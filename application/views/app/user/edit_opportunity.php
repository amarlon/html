<div class="portlet light portlet-no-bg" style="padding-bottom:0;">
    <div class="portlet-title">
        <div class="caption search-results-caption">
            <span class="caption-subject text">Edit Opportunity</span>
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

                            <form class="update-details-form bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/account/update_opportunity">
                                <div class="form-body">

                                    <input type="hidden" name="opportunity_id" value="<?=$opportunity['id']?>">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input name="title" type="text" class="form-control" placeholder="Title" value="<?=$opportunity['title']?>" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <textarea name="description" class="form-control" rows="10" placeholder="Description" required=""><?=strip_tags($opportunity['description'])?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <label class="control-label" style="font-size:11px;">Add required skill (press enter)</label>
                                                    <input name="skills" id="tags_1" value="<?=$opportunity['skills']?>" type="text" class="form-control tags" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input name="qualifications" type="text" class="form-control" value="<?=$opportunity['qualifications']?>" placeholder="Required qualification" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input name="location" type="text" class="form-control" value="<?=$opportunity['location']?>" placeholder="Location (e.g. Dublin, IE)" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <?php if( $opportunity['image'] ): ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-5 col-sm-5">
                                                        <img src="<?=$opportunity['image']?>" alt="" class="img-responsive">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-10">
                                                    <p class="font-12px">Select Image (optional)</p>
                                                    <input type="file" name="file" accept=".png, .jpg, .jpeg">
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>