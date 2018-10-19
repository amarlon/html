<!-- Modal -->
<div id="create-ad-modal" class="modal fade bs-edit-pages" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="icon-note"></i> <span>Create New Ad</span></h4>
            </div>

                <form enctype="multipart/form-data" action="/ajax/account/create_ad" id="create-ad-form">
                    <div class="form-body">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <p>Charges: <span class="text-green bold">&euro;<?=decimal(2, $ad_charge_per_day)?> per day</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <label class="control-label font-12px">Description</label>
                                            <input type="text" name="description" id="description" class="form-control" placeholder="Briefly describe your Ad" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <label class="control-label font-12px">Start Date</label>
                                            <div class="input-icon">
                                                <i class="fa fa-calendar"></i>
                                                <input name="start_date" type="text" id="start-date" class="form-control todo-taskbody-due" placeholder="Select start Date..." required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <label class="control-label font-12px">End Date</label>
                                            <div class="input-icon">
                                                <i class="fa fa-calendar"></i>
                                                <input name="end_date" type="text" id="end-date" class="form-control todo-taskbody-due" placeholder="Select end Date..." required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <label class="control-label font-12px">Link to your website</label>
                                            <div class="input-icon">
                                                <i class="fa fa-external-link"></i>
                                                <input name="link" type="text" id="link" class="form-control" placeholder="E.g. http://www.mywebsite.com" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <p class="font-12px">Select Image: <span class="bold">400x400 - JPEG or PNG</span></p>
                                            <input type="file" id="file" name="file" accept=".png, .jpg, .jpeg" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <div class="alert alert-danger form-error display-hide">
                                    <a href="" class="close" data-close="alert"></a>
                                    <span></span>
                                </div>
                                <div class="alert alert-success form-success display-hide">
                                    <a href="" class="close" data-close="alert"></a>
                                    <span></span>
                                </div>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" id="customCheckoutButton">Create Ad</button>
                                <i class="fa fa-spinner fa-spin"></i>
                            </div>
                        </div>
                    </div>
                </form>


        </div>
    </div>
</div>