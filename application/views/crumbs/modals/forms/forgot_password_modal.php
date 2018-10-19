<!-- Modal -->
<div id="bs-forgot-password-modal" class="modal fade" role="dialog">
    <div class="modal-dialog small-width">
        <div class="modal-content">
            <form role="form" action="/ajax/auth/forgot_password" class="form-ajax" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="icon-lock"></i> Reset your Hotshi password</h4>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                <input name="email" type="email" class="form-control" placeholder="Enter your login email" required="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="alert alert-danger form-error display-hide">
                        <a href="" class="close" data-close="alert"></a>
                        <span></span>
                    </div>
                    <div class="alert alert-success form-success display-hide">
                        <a href="" class="close" data-close="alert"></a>
                        <i class="fa-lg fa fa-check"></i>
                        <span></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </form>
        </div>
    </div>
</div>