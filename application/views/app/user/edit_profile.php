<?php if( isset($_GET['clicktab']) && $_GET['clicktab'] ): ?>
    <input type="hidden" id="bs-click-tab" value="<?=$_GET['clicktab']?>" />
<?php endif; ?>

<div class="row margin-top-10">
    <div class="col-md-8">

        <div class="portlet light min-height-400">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase"><?=$is_french_user ? 'EDITER LE PROFIL':'Edit Profile' ?></span>
                </div>
                <div class="tools">

                </div>
            </div>
            <div class="portlet-body">

                <div class="portlet-tabs">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_15_1" data-toggle="tab"><i class="icon-user"></i> <?=$is_french_user ? 'Détails':'Details' ?> </a></li>
                        <li class=""><a href="#tab_15_2" class="bs-edit-avatar" data-toggle="tab"><i class="icon-picture"></i> <?=$is_french_user ? 'Photo de profil':'Profile photo' ?> </a></li>
                        <li class=""><a href="#tab_15_3" class="bs-edit-cv" data-toggle="tab"><i class="icon-note"></i>CV </a></li>
                        <li class=""><a href="#tab_15_4" class="bs-edit-gallery" data-toggle="tab"><i class="icon-picture"></i> <?=$is_french_user ? 'Galerie':'Gallery' ?> </a></li>
                    </ul>

                    <div class="margin-top-30"></div>

                    <div class="tab-content bs-edit-pages">
                        <div class="tab-pane active" id="tab_15_1">

                            <form class="update-details-form form-ajax" enctype="multipart/form-data" action="/ajax/account/update_details">
                                <div class="form-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                        <input <?=$user['is_fb_user'] ? 'disabled':'required' ?> name="fullname" value="<?=$user['fullname']?>" type="text" class="form-control" placeholder="<?=$is_french_user ? 'Entrez votre nom complet':'Enter your full name' ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                                        <input name="profession" value="<?=$user['profession']?>" type="text" class="form-control" placeholder="<?=$is_french_user ? 'Entrez votre profession (facultatif)':'Enter your profession (optional)' ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                        <input name="phone" value="<?=$user['phone']?>" type="tel" class="form-control" placeholder="<?=$is_french_user ? 'Entrez votre numéro de téléphone (facultatif)':'Enter your phone number (optional)' ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--<div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                                                        <input name="business_address" value="<?/*=$user['business_address']*/?>" type="text" class="form-control" placeholder="Enter your business address (optional)">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-link"></i></span>
                                                        <input name="website" value="<?=$user['website']?>" type="text" class="form-control" placeholder="<?=$is_french_user ? 'L\'URL de votre site (facultatif)':'Your website URL (optional)' ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-globe"></i></span>

                                                        <select class="form-control" name="country_id">
                                                            <option selected="" disabled=""><?=$is_french_user ? 'Localisation (facultative)':'Location (optional)' ?></option>
                                                            <?php foreach( $countries as $country ): ?>
                                                                <?php if( $user['country_id'] == $country['id'] ): ?>
                                                                    <option value="<?=$country['id']?>" selected=""><?=$country['name']?></option>
                                                                <?php else: ?>
                                                                    <option value="<?=$country['id']?>"><?=$country['name']?></option>
                                                                <?php endif ?>
                                                            <?php endforeach; ?>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-globe"></i></span>

                                                        <select class="form-control" name="country_origin_id">
                                                            <option selected="" disabled="">Country of Origin (optional)</option>
                                                            <?php foreach( $countries as $country ): ?>
                                                                <?php if( $user['country_origin_id'] == $country['id'] ): ?>
                                                                    <option value="<?=$country['id']?>" selected=""><?=$country['name']?></option>
                                                                <?php else: ?>
                                                                    <option value="<?=$country['id']?>"><?=$country['name']?></option>
                                                                <?php endif ?>
                                                            <?php endforeach; ?>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--<div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <img src="/assets/global/img/ireland-flag.png" class="tooltips" data-placement="top" data-original-title="Ireland"> <i class="fa fa-refresh fa-spin" style="display: none;"></i>
                                                        </span>
                                                        <select class="form-control" name="city_county_id" id="cities-counties" required="">
                                                            <?php /*foreach( $counties as $city ): */?>
                                                                <?php /*if($city['id'] == $user['city_id']): */?>
                                                                    <option value="<?/*=$city['id']*/?>" selected=""><?/*=$city['name']*/?></option>
                                                                <?php /*else: */?>
                                                                    <option value="<?/*=$city['id']*/?>"><?/*=$city['name']*/?></option>
                                                                <?php /*endif; */?>
                                                            <?php /*endforeach; */?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->

                                    <!--<div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group" id="city-area">
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-map-marker"></i> <i class="fa fa-refresh fa-spin" style="display: none;"></i>
                                                        </span>
                                                        <select class="form-control" name="area_id" required="">
                                                            <?php /*foreach( $areas as $area ): */?>
                                                                <?php /*if($area['id'] == $user['area_id']): */?>
                                                                    <option value="<?/*=$area['id']*/?>" selected=""><?/*=$area['name']*/?></option>
                                                                <?php /*else: */?>
                                                                    <option value="<?/*=$area['id']*/?>"><?/*=$area['name']*/?></option>
                                                                <?php /*endif; */?>
                                                            <?php /*endforeach; */?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                        <input <?=$user['is_fb_user'] ? 'disabled':'required' ?> name="email" value="<?=$user['email']?>" type="email" class="form-control" placeholder="<?=$is_french_user ? 'Entrez votre email de connexion':'Enter your login email' ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <label class="control-label" style="font-size:11px;"><?=$is_french_user ? 'Ajoutez vos compétences (appuyez sur Entrée)':'Add your skills (press enter)' ?></label>
                                                    <input name="tags" value="<?=$user['tags']?>" id="tags_1" type="text" class="form-control tags" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <textarea name="about" class="form-control" rows="7" placeholder="<?=$is_french_user ? 'À Propos (facultatif)...':'About (optional)...' ?>"><?=strip_tags($user['about'])?></textarea>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane bs-edit-pages" id="tab_15_2">

                            <form role="form" class="bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/account/update_avatar">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3">
                                        <img src="<?=$user['image'] ? $user['image'] : get_default_avatar() ?>" alt="" class="img-responsive">
                                    </div>
                                </div>

                                <?php if($user['is_fb_user']): ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p><?=$is_french_user ? 'Votre photo de profil facebook':'Your Facebook profile photo' ?></p>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="upload-file-container col-md-9">
                                                <input type="file" name="file" accept="image/*">
                                                <?php if( $is_french_user ): ?>
                                                    <p class="file-input-name"><?=$user['image'] ? 'Update photo':'Attacher photo' ?></p>
                                                <?php else: ?>
                                                    <p class="file-input-name"><?=$user['image'] ? 'Update photo':'Attach photo' ?></p>
                                                <?php endif; ?>
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
                                                    <?php if( $user['image'] && $user['image'] != '/assets/global/img/default-avatar.jpg' ): ?>
                                                        <a href="" class="btn btn-warning delete-img-btn delete-avatar"><i class="fa fa-trash"></i> <?=$is_french_user ? 'Retirer':'Remove' ?></a>
                                                    <?php endif; ?>
                                                    <button type="submit" class="btn btn-primary upload-btn-hidden <?=$user['image'] && $user['image'] != '/assets/global/img/default-avatar.jpg' ? 'hide-save-button':'hide-elem' ?>"><?=$is_french_user ? 'Sauvegarder':'Save' ?></button>
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </form>

                        </div>

                        <div class="tab-pane" id="tab_15_3">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-12">

                                            <p><i class="fa fa-lock"></i> Your CV is private and only accessible to you &amp; Hotshi administrators.<br></p>
                                            <p>Acceptable files: <b>pdf, doc, docx, xls, xlsx, txt, pages</b>.<br><br><br></p>

                                            <?php if($user['cv']): ?>
                                                <div class="col-lg-12">
                                                    <a href="<?=$user['cv']?>" target="_blank"> <i class="fa fa-file-text" style="font-size:80px; margin-top:40px;"></i> </a>
                                                </div>

                                                <div class="col-lg-12">
                                                    <br><br>
                                                    <a href="javascript:" class="btn btn-danger js-delete-cv-btn">Delete CV</a>
                                                </div>

                                            <?php else: ?>
                                                <form role="form" class="form-ajax" enctype="multipart/form-data" action="/ajax/account/upload_cv">
                                                    <div class="alert alert-danger form-error display-hide">
                                                        <a href="" class="close" data-close="alert"></a>
                                                        <span></span>
                                                    </div>
                                                    <div class="alert alert-success form-success display-hide">
                                                        <a href="" class="close" data-close="alert"></a>
                                                        <span></span>
                                                    </div>
                                                    <input type="file" name="file" accept=".pdf, .xls, .xlsx, .pages, .doc, .docx, .txt">
                                                    <button type="submit" name="submit" class="btn btn-primary" style="margin-top:40px;"><i class="fa fa-upload"></i> Upload</button>
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </form>
                                            <?php endif; ?>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="tab-pane bs-edit-pages" id="tab_15_4">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <a href="" class="btn btn-warning" data-toggle="modal" data-target="#bs-gallery-modal"><i class="fa fa-picture-o"></i> <?=$is_french_user ? 'Actualiser la galerie':'Update Gallery' ?></a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                </div>
                            </div>

                            <form role="form" id="gallery-info-form" class="form-ajax" enctype="multipart/form-data" action="/ajax/account/update_gallery_info">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <textarea name="gallery_desc" class="form-control" rows="3" placeholder="Add a description (optional)..." required=""><?=isset($user['gallery_desc']) ? $user['gallery_desc'] : '' ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                                                <button type="submit" class="btn btn-primary" data-dismiss="modal">Update description</button>
                                                <i class="fa fa-spinner fa-spin"></i>
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

<?=$gallery_modal?>