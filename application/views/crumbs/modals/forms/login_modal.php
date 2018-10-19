<!-- Modal -->
<div id="bs-login-modal" class="modal fade" role="dialog">
    <div class="modal-dialog small-width">
        <div class="modal-content">
            <form role="form" action="/ajax/auth/login" class="form-ajax" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="icon-login"></i> <?=$is_french_user ? 'Connexion':'Login' ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <p class="p-modal p-modal-new-mem" style="<?=is_mobile_device() ? 'padding: 20px 0;' : '' ?>"><?=$is_french_user ? 'Nouveau membre' : 'New member?' ?> <a href="" id="bs-new-member-link-login-form" class="bold">Click here</a></p>

                        <?=$fb_login_btn?>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                <input name="email" type="email" class="form-control" placeholder="Enter your login email" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>
                                </span>
                                <input name="password" type="password" class="form-control" placeholder="Enter your login password" required="">
                            </div>
                        </div>

                        <p style="font-size:11px;text-align:center;padding-top:10px;"><?=$is_french_user ? 'Mot de passe':'Forgot password?' ?> <a href="#bs-forgot-password-modal" data-toggle="modal"><?=$is_french_user ? 'oublié Cliquez ici':'Click here' ?></a> </p>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="alert alert-danger form-error display-hide">
                        <a href="" class="close" data-close="alert"></a>
                        <span></span>
                    </div>
                    <button type="submit" class="btn btn-primary"><?=$is_french_user ? 'Connexion':'Login' ?></button>
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </form>
        </div>
    </div>
</div>