<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>

    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;min-height:500px;"' : 'style="margin-top:110px;background:none;min-height:500px;"'  ?> >
        <div class="portlet-title">
            <div class="caption search-results-caption">
                <i class="icon-lock"></i>
                <span class="caption-subject text">Reset your Hotshi password</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <!-- BEGIN CONTENT -->
                <div class="col-md-5 col-sm-12">
                    <div class="content-page">
                        <div class="row">

                            <?php if( isset($password_reset_token_expired) ): ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button>
                                    <i class="fa fa-warning"></i>
                                    <span>Link expired. <b><a href="#bs-forgot-password-modal" data-toggle="modal" style="text-decoration:underline;">Click here</a></b> to request a new link.</span>
                                </div>
                            <?php else: ?>
                                <form role="form" action="/ajax/auth/reset_password" class="form-ajax" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-body">

                                            <input type="hidden" name="reset_token" value="<?=$reset_token?>">

                                            <div class="form-group">
                                                <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-lock"></i>
                                                </span>
                                                    <input name="password" type="password" class="form-control" placeholder="Enter your new password" required="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-lock"></i>
                                                </span>
                                                    <input name="password_confirm" type="password" class="form-control" placeholder="Confirm new password" required="">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="alert alert-danger form-error display-hide">
                                            <a href="" class="close" data-close="alert"></a>
                                            <span></span>
                                        </div>
                                        <div class="alert alert-success form-success display-hide">
                                            <a href="" class="close" data-close="alert"></a>
                                            <span></span>
                                        </div>
                                        <button type="submit" class="btn btn-default">Reset</button>
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT -->
            </div>
        </div>
    </div>

<?php if( !$is_logged_in ): ?>
    </div>
    </div>
    </div>
<?php endif; ?>