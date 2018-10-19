var app_id = $('#fb-app-id').val();

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

    FB.Event.subscribe('auth.statusChange', hotshi_fb_login);

};

function hotshi_fb_login() {
    //this definitely requests user email
    FB.login(function(response) {
        if (response.authResponse) {
            //user just authorized your app
            console.log(response)
            var accessToken = response.authResponse.accessToken;
            var message = {
                'fb_access_token' : accessToken
            };
            $.ajax({
                type    : 'post',
                data    : message,
                dataType : 'json',
                url     : '/ajax/auth/signup/fb',
                success : function(data){

                    if( data.status == 'success' ) {
                        window.location = '/account/feed';
                        return false;
                    } else {
                        alert(data.message);
                    }

                },
                error   :   function(xhr, status, error) {
                    alert('Oops! Technical problems. Please try again shortly.');
                }
            });

        }
    }, {scope: 'email,public_profile'});
}