<div id="" class="modal fade" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog small-width">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Comments (<span class="comments-modal-num-of-comments">0</span>)</h4>
                <p class="comments-post-title" style="padding-top:5px;"></p>
            </div>
            <div class="modal-body" style="max-height:400px;overflow-y:auto;">

                <form role="form" action="/ajax/account/add_comment" class="form-ajax post-comment-form" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="form-group">
                            <textarea name="comment" id="bs-comment-textarea" class="form-control" rows="3" placeholder="Add a comment..." required=""></textarea>
                        </div>
                        <input type="hidden" name="post_id" id="hidden-input-post-id" value="">
                    </div>

                    <div class="row" id="bs-post-comment-btn-wrapper">
                        <div class="col-md-12">
                            <div class="alert alert-danger form-error display-hide" style="text-align:left;">
                                <a href="" class="close" data-close="alert"></a>
                                <span></span>
                            </div>
                            <!--<div class="alert alert-success form-success display-hide" style="text-align:left;">
                                <a href="" class="close" data-close="alert"></a>
                                <span></span>
                            </div>-->
                            <button type="button" class="btn btn-warning bs-cancel-comment-btn">Cancel</button>
                            <button type="submit" class="btn btn-primary">Post</button>
                            <i class="fa fa-spinner fa-spin"></i>
                        </div>
                    </div>

                </form>

                <hr>

                <div class="row">
                    <div class="col-md-12 bs-comments-section">

                        <p style="text-align:center;">
                            <i class="fa fa-refresh fa-spin"></i>
                        </p>

                        <div class="comment-section-inner">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>