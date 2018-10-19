<?php if( isset($_GET['clicktab']) ): ?>

    <?php if( $_GET['clicktab'] ): ?>
        <input type="hidden" id="bs-click-tab" value="<?=$_GET['clicktab']?>" />
    <?php endif; ?>

<?php endif; ?>

    <div class="row margin-top-10">
        <div class="col-md-8">

            <div class="portlet light min-height-400">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>
                        <span class="caption-subject bold uppercase">Account settings</span>
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body">

                    <div class="portlet-tabs">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_15_1" data-toggle="tab">Settings </a></li>
                        </ul>

                        <div class="margin-top-30"></div>

                        <div class="tab-content bs-edit-pages">
                            <div class="tab-pane active" id="tab_15_1">

                                <?php if( $user['is_verified'] ): ?>

                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-8">
                                                        <div class="alert alert-success alert-dismissable">
                                                            <p class="alert-link">Email verified <i class="fa fa-check-circle"></i><br><span style="font-weight:normal;font-size:11px;"><?=$user['email']?></span> </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <form>
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <button class="btn btn-primary resend-email-verification-btn" style="padding:12px 20px;"><i class="fa fa-envelope"></i> Verify my email</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php endif; ?>



                                <?php if( !$user['is_fb_user'] ): ?>

                                    <hr>

                                    <form role="form" action="/ajax/account/update_password" class="form-ajax" enctype="multipart/form-data">
                                        <div class="form-body">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <h4>Change password</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                                <input name="curr_password" type="password" class="form-control" placeholder="Enter your current password" required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                                <input name="new_password" type="password" class="form-control" placeholder="Enter new password" required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <div class="input-group">
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
                                            </div>

                                        </div>
                                    </form>


                                    <hr>

                                    <form role="form" action="/ajax/account/update_email" class="form-ajax" enctype="multipart/form-data">
                                        <div class="form-body">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <h4>Change email</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                                <input name="new_email" type="email" class="form-control" placeholder="Enter new email address" required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                                <input name="curr_password" type="password" class="form-control" placeholder="Enter your current password" required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <div class="input-group">
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
                                            </div>

                                        </div>
                                    </form>
                                <?php endif; ?>

                                <hr>

                                <form role="form" class="deactivate-account-form">
                                    <div class="form-body">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-8">
                                                        <h4>De-activate account</h4>
                                                        <p>Please contact us at: <a href="mailto:help@hotshi.com?Subject=Deactivate" target="_top">help@hotshi.com</a> if you'd like to deactivate your account.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-8">
                                                        <!--<div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                            <input name="curr_password" id="curr_password_deactivate" type="password" class="form-control" placeholder="Enter your current password" required="">
                                                        </div>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-8">
                                                        <!--<div class="input-group">
                                                            <button type="submit" class="btn btn-primary">De-activate my account</button>
                                                            <i class="fa fa-spinner fa-spin"></i>
                                                        </div>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </form>

                                <?php if($user['is_hotshi_admin']): ?>

                                    <hr>

                                    <form role="form" action="/ajax/org_admin/delete_account" class="form-ajax" enctype="multipart/form-data">
                                        <div class="form-body">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <h4>Delete Account (Admin)</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <p style="color:red;">THIS ACTION CANNOT BE UNDONE!!!</p>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                                                <input name="user_email" type="text" class="form-control" placeholder="Enter email" required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <div class="input-group">
                                                                <div class="alert alert-danger form-error display-hide">
                                                                    <a href="" class="close" data-close="alert"></a>
                                                                    <span></span>
                                                                </div>
                                                                <div class="alert alert-success form-success display-hide">
                                                                    <a href="" class="close" data-close="alert"></a>
                                                                    <span></span>
                                                                </div>
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                                <i class="fa fa-spinner fa-spin"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </form>


                                <?php endif; ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>