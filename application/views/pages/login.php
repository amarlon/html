<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>

    <div class="portlet portlet-centered logged-out-portlet col-md-7 margin-bottom-20 margin-top-20">
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-3 portlet-centered">
                    <a href="/">
                        <!--<img src="/assets/global/img/logo-2-dark.png" class="img-responsive">-->
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="portlet light portlet-centered col-md-5 col-sm-7 padding-bottom-40">
        <div class="portlet-title">
            <div class="caption portlet-centered">
                <span class="text"><i class="icon-login"></i> <?=$is_french_user ? 'Connexion':'Login' ?></span><br>
                <div style="padding-top:10px;"></div>
            </div>
        </div>
        <div class="portlet-body">

            <div class="row">
                <div class="col-md-10 portlet-centered">
                    <form class="form-ajax" action="/ajax/auth/login" id="hotshi-login-form" enctype="multipart/form-data">

                        <div class="form-body">
                            <p class="p-modal p-modal-new-mem" style="<?=is_mobile_device() ? 'padding: 10px 0;' : 'padding-top:20px;padding-bottom:5px;' ?>" ><?=$is_french_user ? 'Nouveau membre' : 'New member?' ?> <a href="#bs-signup-modal" data-toggle="modal" class="bold"><?=$is_french_user ? 'Inscription':'Register' ?></a></p>

                            <?=$fb_login_btn?>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input name="email" type="email" class="form-control" placeholder="Email" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                    <input name="password" type="password" class="form-control" placeholder="<?=$is_french_user ? 'Mot de passe':'Password'?>" required="">
                                </div>
                            </div>

                        </div>

                        <div class="form-group login-signup-group-btn-wrapper">
                            <div class="alert alert-danger form-error display-hide">
                                <a href="" class="close" data-close="alert"></a>
                                <span></span>
                            </div>
                            <button type="submit" class="btn btn-primary col-md-12 col-sm-12 col-xs-12"><?=$is_french_user ? 'Connexion':'Login' ?></button>
                            <i class="fa fa-spinner fa-spin"></i>
                        </div>

                    </form>

                    <div class="row">
                        <div class="col-md-12">
                            <p class="tos-signup-text"><?=$is_french_user ? 'Mot de passe':'Forgot password?' ?><a href="#bs-forgot-password-modal" data-toggle="modal"> <?=$is_french_user ? 'oublié Cliquez ici':'Click here' ?></a></p>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

<?php if( !$is_logged_in ): ?>
    </div>
    </div>
    </div>
<?php endif; ?>