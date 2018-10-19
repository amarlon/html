<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>

    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;min-height:500px;"' : 'style="margin-top:110px;background:none;min-height:500px;"'  ?> >
        <div class="portlet-title">
            <div class="caption search-results-caption">
                <i class="icon-envelope-open"></i>
                <span class="caption-subject text">Verification</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <!-- BEGIN CONTENT -->
                <div class="col-md-5 col-sm-12">
                    <div class="content-page">
                        <div class="row">

                            <?php if( isset($email_verified) ): ?>
                                <div class="alert alert-success">
                                    <button class="close" data-close="alert"></button>
                                    <i class="fa-lg fa fa-check"></i>
                                    <span><b>Email verified!</b> Thank you.</span>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-danger">
                                    <button class="close" data-close="alert"></button>
                                    <i class="fa fa-warning"></i>
                                    <span>The email confirmation link you visited has expired. Go to your <a href="/account/settings?login=settings">account settings</a> to request a new email activation link.</span>
                                </div>
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