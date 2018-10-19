<div class="portlet light portlet-no-bg" style="padding-bottom:0;">
    <div class="portlet-title">
        <div class="caption search-results-caption">
            <span class="caption-subject text">Create Job Opportunity</span>
            <div class="margin-top-20"></div>
            <i style="font-size:15px;"><i class="bold">&euro;<?=CREATE_OPPORTUNITY_COST?></i> for <?=CREATE_OPPORTUNITY_MAX_DAYS?> days</i>
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

                            <form id="create-opportunity-form" class="update-details-form bs-update-pic-form" enctype="multipart/form-data" action="/ajax/account/create_opportunity">
                                <div class="form-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input id="title" name="title" type="text" class="form-control" placeholder="<?=$is_french_user ? 'Titre':'Title' ?>" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <textarea id="description" name="description" class="form-control" rows="20" placeholder="<?=$is_french_user ? 'Description':'Description' ?>" required=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <label class="control-label" style="font-size:11px;"><?=$is_french_user ? 'Ajouter la compétence requise (appuyez sur Entrée)':'Add required skill (press enter)' ?></label>
                                                    <input name="skills" id="tags_1" type="text" class="form-control tags" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input id="qualifications" name="qualifications" type="text" class="form-control" placeholder="<?=$is_french_user ? 'Required qualification':'Qualification requise' ?>" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input id="location" name="location" type="text" class="form-control" placeholder="<?=$is_french_user ? 'Localisation (ex. Togo, TG)':'Location (e.g. Dublin, IE)' ?>" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-10">
                                                    <p class="font-12px"><?=$is_french_user ? 'Sélectionner une image':'Select Image (optional)' ?></p>
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
                                                    <button type="submit" id="customCheckoutButton" class="btn btn-primary"><?=$is_french_user ? 'CONTINUER':'CONTINUE' ?></button>
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