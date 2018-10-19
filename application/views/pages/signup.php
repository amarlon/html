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
                <span class="text"><i class="icon-note"></i> <?=$is_french_user ? 'Inscription':'Register' ?></span><br>
                <div style="padding-top:10px;"></div>
            </div>
        </div>
        <div class="portlet-body">

            <div class="portlet-tabs">
                <ul class="nav nav-tabs">
                    <li class="<?=$active_learner?>">
                        <a href="#portlet_tab1" data-toggle="tab"><i class="icon-user"></i> <?=$is_french_user ? 'Utilisateur':'User' ?></a>
                    </li>
                    <li class="<?=$active_tutor?>">
                        <a href="#portlet_tab2" data-toggle="tab"><i class="fa fa-institution"></i> <?=$is_french_user ? 'Institution / Entreprise':'Institution/Company' ?></a>
                    </li>

                </ul>

                <div class="tab-content">

                    <div class="tab-pane <?=$active_learner?>" id="portlet_tab1">
                        <div class="row">
                            <div class="col-md-10 portlet-centered">
                                <form class="form-ajax" id="signup-form" action="/ajax/auth/signup" enctype="multipart/form-data">

                                    <div class="form-body">

                                        <input type="hidden" name="is_organisation_user" value="0">

                                        <p class="p-modal p-modal-new-mem" style="<?=is_mobile_device() ? 'padding: 10px 0;' : 'padding-top:20px;padding-bottom:5px;' ?>" ><?=$is_french_user ? 'Déjà membre?':'Already a member?'?> <a href="/page/login" class="bold"><?=$is_french_user ? 'Connexion':'Login' ?></a></p>

                                        <?=$fb_login_btn?>

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
                                                <input name="email" type="email" class="form-control" placeholder="Email" required="" value="<?=isset($_GET['email']) ? $_GET['email']:'' ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-lock"></i>
                                                </span>
                                                <input name="password" type="password" class="form-control" placeholder="<?=$is_french_user ? 'Choisissez un mot de passe fort (fiable)':'Pick a strong password'?>" required="">
                                            </div>
                                        </div>

                                        <!--<div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-globe"></i> <i class="fa fa-refresh fa-spin" style="display: none;"></i>
                                                </span>
                                                <select class="form-control" name="country_id" required="">
                                                    <option selected="" disabled="">Location</option>
                                                    <?php /*foreach( $countries as $country ): */?>
                                                        <option value="<?/*=$country['id']*/?>"><?/*=$country['name']*/?></option>
                                                    <?php /*endforeach; */?>
                                                </select>
                                            </div>
                                        </div>-->

                                    </div>

                                    <div class="form-group login-signup-group-btn-wrapper">
                                        <div class="alert alert-danger form-error display-hide">
                                            <a href="" class="close" data-close="alert"></a>
                                            <span></span>
                                        </div>
                                        <button type="submit" class="btn btn-primary col-md-12 col-sm-12 col-xs-12"><?=$is_french_user ? 'Continuez':'Continue' ?></button>
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </div>

                                </form>

                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if( $is_french_user ): ?>
                                            <p class="tos-signup-text">En vous inscrivant, vous acceptez par la présente de nos <a href="/page/privacy" target="_blank">conditions de service</a></p>
                                        <?php else: ?>
                                            <p class="tos-signup-text">By signing up, you hereby agree to our <a href="/page/privacy" target="_blank">terms of service</a></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="tab-pane <?=$active_tutor?>" id="portlet_tab2">
                        <div class="row">
                            <div class="col-md-10 portlet-centered">
                                <form class="form-ajax" id="signup-form" action="/ajax/auth/signup" enctype="multipart/form-data">

                                    <div class="form-body">

                                        <input type="hidden" name="is_organisation_user" value="1">

                                        <p class="p-modal p-modal-new-mem" style="<?=is_mobile_device() ? 'padding: 10px 0;' : 'padding-top:20px;padding-bottom:15px;' ?>" ><?=$is_french_user ? 'Déjà membre?':'Already a member?'?> <a href="/page/login" class="bold"><?=$is_french_user ? 'Connexion':'Login' ?></a></p>



                                        <!--<div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                                <input name="fullname" type="text" class="form-control" placeholder="Full name" required="">
                                            </div>
                                        </div>-->

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-bank"></i>
                                                </span>
                                                <input name="username" type="text" class="form-control" placeholder="<?=$is_french_user ? 'Nom de l’organisation':'Name of organisation' ?>" required="">
                                            </div>
                                        </div>

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
                                                <input name="password" type="password" class="form-control" placeholder="<?=$is_french_user ? 'Choisissez un mot de passe fort (fiable)':'Pick a strong password'?>" required="">
                                            </div>
                                        </div>

                                        <!--<div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-globe"></i> <i class="fa fa-refresh fa-spin" style="display: none;"></i>
                                                </span>
                                                <select class="form-control" name="country_id" required="">
                                                    <option selected="" disabled="">Location</option>
                                                    <?php /*foreach( $countries as $country ): */?>
                                                        <option value="<?/*=$country['id']*/?>"><?/*=$country['name']*/?></option>
                                                    <?php /*endforeach; */?>
                                                </select>
                                            </div>
                                        </div>-->


                                    </div>

                                    <div class="form-group login-signup-group-btn-wrapper">
                                        <div class="alert alert-danger form-error display-hide">
                                            <a href="" class="close" data-close="alert"></a>
                                            <span></span>
                                        </div>
                                        <button type="submit" class="btn btn-primary col-md-12 col-sm-12 col-xs-12"><?=$is_french_user ? 'Continuez':'Continue' ?></button>
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </div>

                                </form>

                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if( $is_french_user ): ?>
                                            <p class="tos-signup-text">En vous inscrivant, vous acceptez par la présente de nos <a href="/page/privacy" target="_blank">conditions de service</a></p>
                                        <?php else: ?>
                                            <p class="tos-signup-text">By signing up, you hereby agree to our <a href="/page/privacy" target="_blank">terms of service</a></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
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