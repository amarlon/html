<div class="portlet light portlet-no-bg" style="padding-bottom:0;">
    <div class="portlet-title">
        <?=$articles_breadcrumb?>
    </div>
</div>

<div class="row min-height-600">
    <div class="col-md-8">
        <div class="portlet light">
            <div class="portlet-body">
                <div class="portlet-tabs">

                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#portlet_tab1" data-toggle="tab"><i class="icon-note"></i> Article</a>
                        </li>
                        <li class="">
                            <a href="#portlet_tab2" data-toggle="tab"><i class="icon-picture"></i> Image</a>
                        </li>
                    </ul>

                    <div class="margin-top-30"></div>

                    <div class="tab-content bs-edit-pages">
                        <div class="tab-pane active" id="portlet_tab1">

                            <form class="update-details-form bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/account/update_article">
                                <div class="form-body">

                                    <input type="hidden" name="article_id" value="<?=$article['id']?>">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <input name="title" type="text" class="form-control" placeholder="Article title" required="" value="<?=$article['title']?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <textarea name="description" class="form-control" rows="10" placeholder="Article content" required=""><?=strip_tags($article['description'])?></textarea>
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

                        <div class="tab-pane bs-edit-pages" id="portlet_tab2">

                            <form role="form" class="bs-update-pic-form form-ajax" enctype="multipart/form-data" action="/ajax/account/update_article_img">

                                <input type="hidden" name="article_id" id="article-id" value="<?=$article['id']?>">

                                <div class="row">
                                    <div class="col-md-3 col-sm-3">
                                        <img src="<?=$article['image'] ? $article['image'] : get_default_post_img() ?>" alt="" class="img-responsive">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="upload-file-container col-md-9">
                                            <input type="file" name="file" accept="image/*">
                                            <p class="file-input-name"><?=$article['image'] ? 'Update photo':'Add photo' ?></p>
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
                                                <?php if( $article['image'] ): ?>
                                                    <a href="" class="btn btn-warning delete-img-btn delete-article-img"><i class="fa fa-trash"></i> Remove</a>
                                                <?php endif; ?>
                                                <button type="submit" class="btn btn-primary <?=$article['image'] ? 'hide-save-button':'' ?>" data-dismiss="modal">Save</button>
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