<div class="modal fade" id="new-fb-user-details" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog small-width">
        <div class="modal-content">
            <form role="form" action="/ajax/auth/signup/fb" class="form-ajax" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close cancel-fb-final-step" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><i class="fa fa-user"></i> </h4>
                </div>
                <div class="modal-body">

                    <div class="portlet-body form">

                        <div class="form-body">

                            <p style="font-weight:bold;">Final step...</p>

                            <!--<input type="hidden" class="form-control" name="email" id="email" required>-->
                            <input type="hidden" class="form-control" name="fb_access_token" id="fb-access-token" required>
                            <input type="hidden" class="form-control" name="fb_user_id" id="fb-user-id" required>
                            <input type="hidden" class="form-control" name="fullname" id="full-name" required>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input name="email" id="email" type="email" class="form-control" placeholder="Confirm your Facebook email" required="">
                                </div>
                            </div>

                            <!--<div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <img src="/assets/global/img/ireland-flag.png" class="tooltips" data-placement="top" data-original-title="Ireland"> <i class="fa fa-refresh fa-spin" style="display: none;"></i>
                                    </span>
                                    <select class="form-control" name="city_county_id" id="cities-counties" required=""></select>
                                </div>
                            </div>-->

                            <!--<div class="form-group" id="city-area">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map-marker"></i> <i class="fa fa-refresh fa-spin" style="display: none;"></i>
                                    </span>
                                    <select class="form-control" name="area_id" required=""></select>
                                </div>
                            </div>-->

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!--<button type="button" class="btn btn-default cancel-fb-final-step" data-dismiss="modal" >Cancel</button>-->
                    <div class="alert alert-danger form-error display-hide">
                        <a href="" class="close" data-close="alert"></a>
                        <span></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Continue</button>
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
            </form>
        </div>
    </div>
</div>