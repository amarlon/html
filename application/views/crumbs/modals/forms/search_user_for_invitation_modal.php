<!-- Modal -->
<div id="search-user-for-invitation-modal" class="modal fade" role="dialog">
    <div class="modal-dialog small-width">
        <div class="modal-content">
            <form role="form" action="/ajax/org_admin/search_user_for_invitation" class="form-ajax" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add user</h4>
                </div>
                <div class="modal-body">
                    <div class="form-body">

                        <input type="hidden" name="organisation_id" value="<?=$organisation['id']?>">

                        <p>When you add a user to your organisation, you can set them as a course tutor.</p>

                        <br>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                <input name="email" type="email" class="form-control" placeholder="Enter user email" required="">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="alert alert-danger form-error display-hide">
                        <a href="" class="close" data-close="alert"></a>
                        <span></span>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </form>
            <div class="row centered-text admin-tutor-search-wrapper hide-elem" style="margin-top:-20px;">
                <div class="col-md-12">
                    <h5 class="found-fullname" style="padding:0 0 5px 0;"></h5>
                </div>

                <div class="col-md-12">
                    <img src="" class="found-image" style="width:150px;">
                </div>

                <div class="col-md-12" style="padding: 30px;">
                    <a href="javascript:;" class="btn btn-primary add-found-tutor-btn" data-organisation-id="<?=$organisation['id']?>"><i class="fa fa-plus"></i> Add user</a>
                    <a href="javascript:;" class="btn btn-primary send-tutor-invitation-btn" data-organisation-id="<?=$organisation['id']?>"><i class="fa fa-plus"></i> Send invitation</a>
                    <a href="javascript:;" class="btn btn-default cancel-found-tutor-btn">Cancel</a>
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </div>
        </div>
    </div>
</div>