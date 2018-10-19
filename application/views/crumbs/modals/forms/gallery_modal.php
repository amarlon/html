<input type="hidden" id="user-id" value="<?=$user['id']?>">

<div class="modal fade bs-modal-lg in" id="bs-gallery-modal" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title uppercase"><i class="icon-picture"></i> <?=$this->session->userdata('firstname')?>'s photos</h4>
            </div>

            <div class="modal-body">
                <div class="alert alert-danger form-error display-hide">
                    <button class="close" data-close="alert"></button>
                    <i class="fa fa-warning"></i>
                    <span></span>
                </div>
                <div class="portlet-body form">

                    <div class="form-body">

                        <div class="portlet light">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-12 gallery-form-wrapper">
                                        <form action="/ajax/account/add_gallery_images" class="dropzone" id="my-dropzone">

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary done-uploading-btn" data-dismiss="modal">Done</button>
                <i class="fa fa-spinner fa-spin"></i>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>