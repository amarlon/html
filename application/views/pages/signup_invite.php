<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>

    <div class="portlet portlet-centered logged-out-portlet col-md-7 margin-bottom-20 margin-top-20">
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-3 portlet-centered">
                </div>
            </div>
        </div>
    </div>

    <div class="portlet light portlet-centered col-md-5 col-sm-7 padding-bottom-40">
        <div class="portlet-title">
            <div class="caption portlet-centered">
                <?php if( $valid_token ): ?>
                    <span class="text"><i class="icon-users"></i> Join <b><?=$organisation['name']?></b> on Hotshi</span><br>
                <?php endif; ?>

                <div style="padding-top:10px;"></div>
            </div>
        </div>
        <div class="portlet-body">

            <?php if( $valid_token ): ?>
                <div class="row">
                    <div class="col-md-10 portlet-centered">
                        <form class="form-ajax" id="signup-form" action="/ajax/auth/signup" enctype="multipart/form-data">

                            <div class="form-body">

                                <input type="hidden" name="is_organisation_user" value="0">

                                <div class="form-group">
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                        <input name="fullname" type="text" class="form-control" placeholder="Full name" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-envelope"></i>
                                                </span>

                                        <input name="email" type="email" class="form-control" placeholder="Email" required="" value="<?=$invited_user['email']?>">
                                        <input name="invitation_token" type="hidden" class="form-control" required="" value="<?=$invited_user['invitation_token']?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-lock"></i>
                                                </span>
                                        <input name="password" type="password" class="form-control" placeholder="Pick a strong password" required="">
                                    </div>
                                </div>

                            </div>

                            <div class="form-group login-signup-group-btn-wrapper">
                                <div class="alert alert-danger form-error display-hide">
                                    <a href="" class="close" data-close="alert"></a>
                                    <span></span>
                                </div>
                                <button type="submit" class="btn btn-primary col-md-12 col-sm-12 col-xs-12">Continue</button>
                                <i class="fa fa-spinner fa-spin"></i>
                            </div>

                        </form>

                        <div class="row">
                            <div class="col-md-12">
                                <p class="tos-signup-text">By signing up, you hereby agree to our <a href="/page/privacy" target="_blank">terms of service</a></p>
                            </div>
                        </div>

                    </div>

                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger col-md-10">
                            <button class="close" data-close="alert"></button>
                            <i class="fa-lg fa fa-alert"></i>
                            <span class="font-12px">Oops! This invitation link has expired. <br><br>You can either request a new invitation link from your organisation, or <a href="/page/signup">signup</a> as a regular user and ask your organisation to add you as one of their tutors.</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

<?php if( !$is_logged_in ): ?>
    </div>
    </div>
    </div>
<?php endif; ?>