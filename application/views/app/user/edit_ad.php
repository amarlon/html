<?php if( isset($_GET['clicktab']) && $_GET['clicktab'] ): ?>
    <input type="hidden" id="bs-click-tab" value="<?=$_GET['clicktab']?>" />
<?php endif; ?>

    <div class="row margin-top-10">
        <div class="col-md-8">

            <div class="portlet light min-height-400">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold uppercase"><?=$is_french_user ? 'EDITER LE Ad':'Edit Your Ad' ?></span>
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body">

                    <div class="portlet-tabs">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_15_1" data-toggle="tab"><i class="icon-note"></i> <?=$is_french_user ? 'Your Ad':'Your Ad' ?> </a></li>
                        </ul>

                        <div class="margin-top-30"></div>

                        <div class="tab-content bs-edit-pages">
                            <div class="tab-pane active" id="tab_15_1">

                                <form class="update-details-form form-ajax" enctype="multipart/form-data" action="/ajax/account/update_ad">
                                    <div class="form-body">

                                        <input type="hidden" name="ad_id" value="<?=$ad['id']?>">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-10">
                                                        <p class="font-12px margin-zero"><span class="text-grey">Runs</span>: <span class="bold"><?=date('jS M Y', strtotime($ad['start_date']))?></span> to <span class="bold"><?=date('jS M Y', strtotime($ad['end_date']))?></span></p>
                                                        <?php if( $ad['end_date'] < date('Y-m-d') ): ?>
                                                            <p class="font-12px"><span class="text-grey">Status</span>: <span class="text-red bold">EXPIRED</span></p>
                                                        <?php elseif( $ad['is_active'] ): ?>
                                                            <p class="font-12px"><span class="text-grey">Status</span>: <span class="text-green bold">ACTIVE</span></p>
                                                        <?php else: ?>
                                                            <p class="font-12px"><span class="text-grey">Status</span>: <span class="text-orange bold">PENDING REVIEW</span></p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-10">
                                                        <label class="control-label font-12px">Description</label>
                                                        <input type="text" name="description" id="description" class="form-control" placeholder="Briefly describe your Ad" value="<?=strip_tags($ad['description'])?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-10">
                                                        <label class="control-label font-12px">Link to your website</label>
                                                        <div class="input-icon">
                                                            <i class="fa fa-external-link"></i>
                                                            <input value="<?=$ad['link']?>" name="link" type="text" id="link" class="form-control" placeholder="Link (e.g. http://www.mywebsite.com)" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <img src="<?=$ad['image']?>" class="img-responsive">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-10">
                                                        <p class="font-12px">Update Image: <span class="bold">400x400 - JPEG or PNG</span></p>
                                                        <input type="file" id="file" name="file" accept=".png, .jpg, .jpeg">
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
                                                        <button type="submit" class="btn btn-primary" data-dismiss="modal"><?=$is_french_user ? 'Sauvegarder':'Save' ?></button>
                                                        <i class="fa fa-spinner fa-spin"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>