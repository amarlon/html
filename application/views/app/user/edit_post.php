<div class="row margin-top-10">
    <div class="col-md-8">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-note"></i>
                    <span class="caption-subject bold uppercase">Edit post</span>
                </div>
                <div class="tools">

                </div>
            </div>
            <div class="portlet-body">

                <div class="portlet-tabs">

                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_15_1" data-toggle="tab"><i class="icon-note"></i> Post </a>
                        </li>
                        <li class="">
                            <a href="#tab_15_2" data-toggle="tab"><i class="icon-picture"></i> Photo </a>
                        </li>
                    </ul>

                    <div class="margin-top-30"></div>

                    <div class="tab-content bs-edit-pages">
                        <div class="tab-pane active" id="tab_15_1">

                            <form class="form-ajax" enctype="multipart/form-data" action="/ajax/account/update_post">
                                <div class="form-body">

                                    <input type="hidden" name="post_id" value="<?=$post['id']?>">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <textarea name="description" class="form-control" rows="4" placeholder="Description..." required=""><?=strip_tags($post['description'])?></textarea>
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

                        <div class="tab-pane" id="tab_15_2">

                            <form role="form" class="bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/account/update_post_img">

                                <input type="hidden" name="post_id" id="post-id" value="<?=$post['id']?>">

                                <div class="row">
                                    <div class="col-md-3 col-sm-3">
                                        <img src="<?=$post['image'] ? $post['image'] : get_default_post_img() ?>" alt="" class="img-responsive">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="upload-file-container col-md-9">
                                            <input type="file" name="file" accept="image/*" class="tooltips" data-container="body" data-placement="top" data-original-title="Update photo">
                                            <p class="file-input-name"><?=$post['image'] ? 'Update photo':'Add photo' ?></p>
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
                                                <a href="" class="btn btn-warning delete-img-btn delete-post-img <?=$post['image'] ? '':'hide-by-default' ?>"><i class="fa fa-trash"></i> Remove</a>
                                                <button type="submit" class="btn btn-primary <?=$post['image'] ? 'hide-save-button':'' ?>" data-dismiss="modal">Save</button>
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