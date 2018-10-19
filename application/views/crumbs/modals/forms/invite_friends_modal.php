<!-- Modal -->
<style>
    #bs-invite-friends-modal .form-group{
        /*padding-bottom: 20px;*/
    }
</style>
<div id="bs-invite-friends-modal" class="modal fade" role="dialog">
    <div class="modal-dialog small-width">
        <div class="modal-content">
            <form role="form" action="/ajax/account/invite_friends" class="form-ajax" id="invite-friends-form" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-users"></i> <?=$is_french_user ? 'Inviter des amis sur Hotshi':'Invite friends' ?></h4>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="modal-body">
                            <div class="form-body">

                                <div class="form-group" style="margin-bottom:0;">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>Please only enter the email address of people you know.<br><br></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group invite-friends-input-wrapper fade-in" id="first-email-input-wrapper">
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <input name="emails[]" type="email" class="form-control" placeholder="Enter your friend's email" required="">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-2"><a href="javascript:" class="js-remove-friend-email hide-elem">X</a></div>
                                    </div>
                                </div>

                                <br>

                                <div class="form-group" style="margin-bottom:0;">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p style="font-size:12px;"><a href="javascript:" id="js-add-another-email">Add another email <i class="fa fa-plus-circle"></i></a> </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="modal-footer">
                            <div class="alert alert-danger form-error display-hide">
                                <a href="" class="close" data-close="alert"></a>
                                <span></span>
                            </div>
                            <div class="alert alert-success form-success display-hide">
                                <a href="" class="close" data-close="alert"></a>
                                <span></span>
                            </div>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send <i class="fa fa-send"></i></button>
                            <i class="fa fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>