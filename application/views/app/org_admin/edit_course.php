<div class="portlet light col-md-8 padding-bottom-40">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject bold uppercase"><i class="icon-pencil"></i> Edit course</span><br>
            <div style="padding-top:10px;"></div>
        </div>
    </div>
    <div class="portlet-body">

        <div class="portlet-tabs">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#portlet_tab1" data-toggle="tab"><i class="icon-note"></i> Course</a>
                </li>
                <li class="">
                    <a href="#portlet_tab2" data-toggle="tab"><i class="fa fa-video-camera"></i> Intro video</a>
                </li>
            </ul>

            <style>label{font-size:12px;padding-left:3px;}</style>

            <div class="margin-top-30"></div>

            <div class="tab-content bs-edit-pages">

                <div class="tab-pane active" id="portlet_tab1">

                    <form class="update-details-form bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/org_admin/update_course">
                        <div class="form-body">

                            <input type="hidden" name="organisation_id" value="<?=$course['organisation_id']?>">
                            <input type="hidden" name="course_id" id="course-id" value="<?=$course['id']?>">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <label class="control-label">Title</label>
                                            <input name="title" type="text" class="form-control" placeholder="Course title" value="<?=$course['title']?>" required="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <label class="control-label">Description</label>
                                            <textarea name="description" class="form-control" rows="4" placeholder="Course description (optional)"><?=strip_tags($course['description'])?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <label class="control-label">Category</label>
                                            <select class="form-control" name="course_category_id" required="">
                                                <option selected="" disabled="">Category</option>
                                                <?php foreach( $course_categories as $cat ): ?>
                                                    <?php if( $cat['id'] == $course['course_category_id'] ): ?>
                                                        <option value="<?=$cat['id']?>" selected><?=$cat['name']?></option>
                                                    <?php else: ?>
                                                        <option value="<?=$cat['id']?>"><?=$cat['name']?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <label class="control-label">Level</label>
                                            <select class="form-control" name="course_level_id" required="">
                                                <option selected="" disabled="">Level</option>
                                                <?php foreach( $course_levels as $cl ): ?>
                                                    <?php if( $cl['id'] == $course['course_level_id'] ): ?>
                                                        <option value="<?=$cl['id']?>" selected><?=$cl['name']?></option>
                                                    <?php else: ?>
                                                        <option value="<?=$cl['id']?>"><?=$cl['name']?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <label class="control-label">Tutor</label>
                                            <select class="form-control" name="tutor_id" required="">
                                                <option selected="" disabled="">Tutor</option>
                                                <?php foreach( $tutors as $tutor ): ?>
                                                    <?php if( $tutor['user_id'] == $course['tutor_id'] ): ?>
                                                        <option value="<?=$tutor['user_id']?>" selected><?=$tutor['fullname']?></option>
                                                    <?php else: ?>
                                                        <option value="<?=$tutor['user_id']?>"><?=$tutor['fullname']?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <div class="input-icon">
                                                <label class="control-label">Start date</label>
                                                <?php
                                                $start_date = explode('-', $course['start_date']);
                                                ?>
                                                <i class="fa fa-calendar"></i>
                                                <input name="start_date" id="start-date" type="text" data-format="DD/MM/YYYY" class="form-control todo-taskbody-due" value="<?=$start_date[2].'/'.$start_date[1].'/'.$start_date[0]?>" placeholder="Start Date...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-8">
                                            <div class="input-icon">
                                                <label class="control-label">End date</label>
                                                <?php
                                                $end_date = explode('-', $course['end_date']);
                                                ?>
                                                <i class="fa fa-calendar"></i>
                                                <input name="end_date" id="end-date" type="text" class="form-control todo-taskbody-due" value="<?=$end_date[2].'/'.$end_date[1].'/'.$end_date[0]?>" placeholder="End Date...">
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

                <div class="tab-pane" id="portlet_tab2">

                    <form role="form" class="bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/org_admin/update_course_intro_video">

                        <input type="hidden" name="organisation_id" id="organisation-id" value="<?=$course['organisation_id']?>">
                        <input type="hidden" name="course_id" id="course-id" value="<?=$course['id']?>">

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
                                    <input type="file" name="file">
                                    <p class="file-input-name"><?=$course['intro_video'] ? 'Update intro video':'Attach intro video' ?></p>
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
                                        <?php if( $course['intro_video'] ): ?>
                                            <a href="" class="btn btn-warning delete-img-btn delete-course-intro-video"><i class="fa fa-trash"></i> Remove</a>
                                        <?php endif; ?>
                                        <button type="submit" class="btn btn-primary upload-btn-hidden <?=$course['intro_video'] ? 'hide-save-button':'hide-elem' ?>" data-dismiss="modal"><i class="icon-cloud-upload"></i> Upload</button>
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