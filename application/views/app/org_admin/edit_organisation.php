<div class="row margin-top-10">
    <div class="col-md-8">

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase">Manage organisation</span>
                </div>

            </div>
            <div class="portlet-body">

                <style>label{font-size:12px;padding-left:3px;}</style>

                <div class="portlet-tabs">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_15_1" data-toggle="tab"><i class="icon-info"></i> Details </a></li>
                        <li class=""><a href="#tab_15_2" class="bs-edit-avatar" data-toggle="tab"><i class="icon-picture"></i> Profile photo </a></li>
                        <li class=""><a href="#tab_15_3" class="bs-edit-avatar" data-toggle="tab"><i class="icon-camcorder"></i> Intro video </a></li>
                        <li class=""><a href="#tab_15_4" data-toggle="tab"><i class="icon-users"></i> Users </a></li>
                    </ul>

                    <div class="margin-top-30"></div>

                    <div class="tab-content bs-edit-pages">
                        <div class="tab-pane active" id="tab_15_1">

                            <form class="update-details-form form-ajax" enctype="multipart/form-data" action="/ajax/org_admin/update_organisation">

                                <input type="hidden" name="organisation_id" id="organisation-id" value="<?=$organisation['id']?>">

                                <div class="form-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <label class="control-label">Username</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                                                        <input name="username" value="<?=$organisation['name']?>" type="text" class="form-control" placeholder="Public name, (e.g. Language Guru, Code Uni, etc.)" required="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--<div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <label class="control-label">Name of Institution (optional)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                                                        <input name="institution_name" value="<?/*=$organisation['institution_name']*/?>" type="text" class="form-control" placeholder="University/school/company/organisation" required="">
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
                                                        <input name="website" value="<?=$organisation['website']?>" type="text" class="form-control" placeholder="Your website URL (optional)">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <label class="control-label">About</label>
                                                    <textarea name="about" class="form-control" rows="7" placeholder="About (optional)..."><?=strip_tags($organisation['about'])?></textarea>
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
                                                            <option selected="" disabled="">Location</option>
                                                            <?php foreach( $countries as $country ): ?>
                                                                <?php if( $organisation['country_id'] == $country['id'] ): ?>
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
                                                    <button type="submit" class="btn btn-primary" data-dismiss="modal">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane bs-edit-pages" id="tab_15_2">
                            <form role="form" class="bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/org_admin/update_avatar">

                                <input type="hidden" name="organisation_id" id="organisation-id" value="<?=$organisation['id']?>">

                                <div class="row">
                                    <div class="col-md-3 col-sm-3">
                                        <img src="<?=$organisation['profile_image'] ? $organisation['profile_image'] : get_default_org_avatar() ?>" alt="" class="img-responsive">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-9 upload-file-container">
                                            <input type="file" name="file" accept="image/*">
                                            <p class="file-input-name"><?=$organisation['profile_image'] && $organisation['profile_image'] != '/assets/global/img/default-org-avatar.jpg' ? 'Update photo':'Attach photo' ?></p>
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
                                                <?php if( $organisation['profile_image'] && $organisation['profile_image'] != '/assets/global/img/default-org-avatar.jpg' ): ?>
                                                    <a href="" class="btn btn-warning delete-img-btn delete-org-avatar"><i class="fa fa-trash"></i> Remove</a>
                                                <?php endif; ?>
                                                <button type="submit" class="btn btn-primary upload-btn-hidden <?=$organisation['profile_image'] && $organisation['profile_image'] != '/assets/global/img/default-org-avatar.jpg' ? 'hide-save-button':'hide-elem' ?>">Save</button>
                                                <i class="fa fa-spinner fa-spin"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane bs-edit-pages" id="tab_15_3">

                            <form role="form" class="bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/org_admin/update_profile_intro_video">

                                <input type="hidden" name="organisation_id" class="organisation-id" value="<?=$organisation['id']?>">

                                <div style="padding-top:20px;"></div>

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
                                            <p class="file-input-name"><?=$organisation['intro_video'] ? 'Update intro video (Max. 8MB)':'Attach intro video (Max. 8MB)' ?></p>
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
                                                <?php if( $organisation['intro_video'] ): ?>
                                                    <a href="" class="btn btn-warning delete-img-btn delete-profile-intro-video"><i class="fa fa-trash"></i> Remove</a>
                                                <?php endif; ?>
                                                <button type="submit" class="btn btn-primary upload-btn-hidden <?=$organisation['intro_video'] ? 'hide-save-button':'hide-elem' ?>" data-dismiss="modal"><i class="icon-cloud-upload"></i> Upload</button>
                                                <i class="fa fa-spinner fa-spin"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>

                        <div class="tab-pane bs-edit-pages" id="tab_15_4">

                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="#search-user-for-invitation-modal" data-toggle="modal" class="btn btn-large btn-primary"><i class="fa fa-plus"></i><i class="icon-user"></i> Add user</a>
                                </div>
                            </div>

                            <div class="table-scrollable table-scrollable-borderless">

                                <table class="table table-hover table-light">

                                    <thead>
                                    <tr class="uppercase">
                                        <th colspan="2">USER</th>
                                        <th>ROLE</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php foreach( $tutors as $tutor ): ?>
                                        <tr>
                                            <td class="fit">
                                                <a href="/page/profile/<?=$tutor['user_id']?>">
                                                    <img class="user-pic" src="<?=$tutor['image']?>">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="/page/profile/<?=$tutor['user_id']?>"><?=$tutor['fullname']?></a>
                                            </td>
                                            <td>
                                                <?php if( $tutor['is_organisation_admin'] ): ?>
                                                    Admin
                                                <?php else: ?>
                                                    Tutor
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if( !$tutor['is_organisation_admin'] ): ?>
                                                    <a href="javascript:;" class="btn btn-warning btn-sm remove-organisation-user" data-tutor-id="<?=$tutor['user_id']?>" data-organisation-id="<?=$organisation['id']?>"><i class="fa fa-trash-o"></i> Remove</a>
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?=$search_user_modal?>