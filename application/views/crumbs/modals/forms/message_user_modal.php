<!-- Modal -->
<div id="bs-msg-user-modal" class="modal fade" role="dialog">
    <div class="modal-dialog small-width">
        <div class="modal-content">
            <form role="form" action="/ajax/account/create_message_thread" class="form-ajax" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <?php if($is_contact): ?>
                            <i class="fa fa-envelope"></i> Send <?=isset($organisation) ? $organisation['name'] : $user['firstname']?> a message
                        <?php else: ?>
                            <i class="icon-user-follow"></i> Add <?=$user['firstname']?> as contact
                        <?php endif; ?>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="form-group">
                            <?php if( $is_logged_in ): ?>
                                <?php if($is_contact): ?>
                                    <textarea name="message" class="form-control" rows="4" placeholder="Enter a message" required=""></textarea>
                                <?php else: ?>
                                    <textarea name="message" class="form-control" rows="4" placeholder="Enter a message" required="">Hi <?=$user['firstname']?>, I'd like to add you as a contact.</textarea>
                                <?php endif; ?>
                            <?php else: ?>
                                <p>Please <a href="/" class="bold">register</a> or <a href="/page/login" class="bold">login</a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <input type="hidden" name="receiver_id" value="<?=isset($org_admin_id) ? $org_admin_id : $user['id']?>">
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
                    <?php if( $is_logged_in ): ?>
                        <button type="submit" class="btn btn-primary">Send</button>
                    <?php else: ?>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    <?php endif; ?>
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </form>
        </div>
    </div>
</div>