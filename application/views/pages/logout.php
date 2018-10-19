<?php if( !$is_logged_in ): ?>
<div class="page-container">
    <div class="page-content">
        <div class="container view-container">
<?php endif; ?>


            <div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?>>
                <div class="portlet-title">
                    <div class="caption search-results-caption">
                        <span class="caption-subject text">Signing Out...</span>
                    </div>
                </div>

                <div style="display:none !important;">
                    <div id="fb-root"></div>
                    <div class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="true"></div>
                </div>


                <script>

                    //window.location = '/';

                    var app_id = document.getElementById('fb-app-id').value;

                    (function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId='+app_id+'&autoLogAppEvents=1';
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));

                    window.fbAsyncInit = function() {
                        FB.init({
                            appId      : app_id, // Set YOUR APP ID
                            status     : true, // check login status
                            cookie     : true, // enable cookies to allow the server to access the session
                            xfbml      : true,  // parse XFBML
                            version    : 'v2.4',
                            oauth      : true
                        });

                        FB.getLoginStatus(function(response) {
                            if (response.status === 'connected') {
                                FB.logout(function(response) {
                                    // user is now logged out
                                    window.location = '/';
                                });
                            } else if (response.status === 'not_authorized') {
                                // the user is logged in to Facebook,
                                // but has not authenticated your app
                            } else {
                                // the user isn't logged in to Facebook.
                            }

                        });

                    };
                </script>


            </div>


<?php if( !$is_logged_in ): ?>
        </div>
    </div>
</div>
<?php endif; ?>