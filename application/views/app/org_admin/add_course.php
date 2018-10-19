<div class="row margin-top-10 min-height-600">
        <div class="col-md-8">

            <div class="portlet light min-height-400">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-plus"></i>
                        <span class="caption-subject bold uppercase">Create new course</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <div class="tabbable-line">
                        <div class="tab-content bs-edit-pages">
                            <div class="tab-pane active" id="tab_15_1">
                                <?php if( $organisation['can_create_course'] ): ?>
                                    <form class="update-details-form bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/org_admin/create_course">
                                        <div class="form-body">

                                            <input type="hidden" name="organisation_id" value="<?=$organisation['id']?>">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <select class="form-control" name="course_type" id="course-type-select" required="">
                                                                <option selected="" disabled="">Course Type</option>
                                                                <option value="FREE">FREE</option>
                                                                <option value="FEE PAYING">FEE PAYING</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row hide-elem" id="cert-cost-row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <label class="control-label font-12px">How much will you charge users to obtain certificates?</label>
                                                            <div class="input-icon">
                                                                <i class="fa fa-euro"></i>
                                                                <input name="cert_cost" type="text" class="form-control" placeholder="Enter a number. E.g. 15" required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <select class="form-control" name="course_category_id" required="">
                                                                <option selected="" disabled="">Category</option>
                                                                <?php foreach( $course_categories as $cat ): ?>
                                                                    <option value="<?=$cat['id']?>"><?=$cat['name']?></option>
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
                                                            <select class="form-control" name="course_level_id" required="">
                                                                <option selected="" disabled="">Level</option>
                                                                <?php foreach( $course_levels as $cl ): ?>
                                                                    <option value="<?=$cl['id']?>"><?=$cl['name']?></option>
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
                                                            <input name="title" type="text" class="form-control" placeholder="Course title" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <textarea name="description" class="form-control" rows="4" placeholder="Course description (optional)"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <select class="form-control" name="tutor_id" required="">
                                                                <option selected="" disabled="">Tutor</option>
                                                                <?php foreach( $tutors as $tutor ): ?>
                                                                    <option value="<?=$tutor['user_id']?>"><?=$tutor['fullname']?></option>
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
                                                                <i class="fa fa-calendar"></i>
                                                                <input name="start_date" type="text" id="start-date" class="form-control todo-taskbody-due" placeholder="Start Date...">
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
                                                                <i class="fa fa-calendar"></i>
                                                                <input name="end_date" type="text" id="end-date" class="form-control todo-taskbody-due" placeholder="End Date...">
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
                                                            <h3>Add a short intro video</h3>
                                                            <p>Appears on course overview page</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="margin-top-30"></div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-md-12 video-upload-wrapper">
                                                    <div class="col-md-9 upload-file-container upload-video-container">
                                                        <input type="file" name="file" accept="video/*">
                                                        <p class="file-input-name">Select intro video</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>


                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-10">
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
                                <?php else: ?>
                                    <div class="request-course-creation-wrapper">
                                        <h2>Hey, just one more step</h2>
                                        <p>To begin creating courses on Hotshi, please click the button bellow and one of our admins will be in touch.</p>
                                        <hr>
                                        <button type="button" class="btn btn-primary btn-large js-request-course-creation-btn" data-org-id="<?=$organisation['id']?>">NOTIFY HOTSHI</button>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>