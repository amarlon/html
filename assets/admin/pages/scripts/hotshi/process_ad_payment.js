/////////////////////////////////////////

$(function(){


    $('#create-ad-form').parsley();

    $('#create-ad-form').on('submit', function(e){
        e.preventDefault();
    });

    //stripe checkout
    if( $('#customCheckoutButton').length ) {

        var auth_user_email = $('#auth_user_email').text();

        var handler = StripeCheckout.configure({
            key: $('#js_stripe_pk').val(),
            image: 'https://res.cloudinary.com/hotshi/image/upload/v1502219509/hotshi_small_checkout_beasdt.png',
            locale: 'auto',
            email: auth_user_email,
            token: function(token) {
                // You can access the token ID with `token.id`.
                // Get the token ID to your server-side code for use.
                var $spinner = $('#preloader');
                $spinner.show();
                var message = {
                    'stripeToken' : token.id,
                    'payment_type' : 'card',
                    'description' : $('#description').val(),
                    'start_date' : $('#start-date').val(),
                    'end_date' : $('#end-date').val(),
                    'link' : $('#link').val(),
                    'file' : $('#file').val()
                };

                $.ajax({
                    type : 'POST',
                    url  : '/ajax/account/create_ad',
                    data : message,
                    dataType    : "json",
                    success: function(data){

                        if( data.status == 'error' ) {
                            $spinner.hide();
                            alert(data.message);
                            return false;
                        } else {
                            $('#create-ad-form').append('<input type="hidden" name="ad_id" value="'+data.ad_id+'">');
                            var $formData = new FormData($('#create-ad-form')[0]);
                            $.ajax({
                                type : 'POST',
                                url  : '/ajax/account/upload_ad_image',
                                data : $formData,
                                dataType    : "json",
                                processData: false,
                                contentType: false,
                                success: function(d){
                                    alert(data.message);
                                    location.reload();
                                },
                                error:function(xhr, status, error){
                                    alert(data.message);
                                    location.reload();
                                }
                            });

                        }
                    },
                    error:function(xhr, status, error){
                        $spinner.hide();
                        alert('Oops! Problem processing your order. Don\'t worry, we haven\'t deducted anything. Please try again.');
                    }
                });

            }
        });

        document.getElementById('customCheckoutButton').addEventListener('click', function(e) {

            if( $('#description').val() && $('#start-date').val() && $('#end-date').val() && $('#file').val() ) {

                var s_date = $('#start-date').val().split("/");
                var e_date = $('#end-date').val().split("/");

                s_date = s_date[2]+'-'+s_date[1]+'-'+s_date[0];
                e_date = e_date[2]+'-'+e_date[1]+'-'+e_date[0];

                var from = moment(s_date, 'YYYY-MM-DD'); // format in which you have the date
                var to = moment(e_date, 'YYYY-MM-DD');     // format in which you have the date

                duration = to.diff(from, 'days');

                if( duration == 0 ) {
                    alert('Please select minimum 1 day');
                    return false;
                }

                handler.open({
                    name: 'Hotshi',
                    description: duration+' days Ad run',
                    zipCode: false,
                    currency : 'eur',
                    amount: (duration*parseFloat($('#js_ad_charge_per_day').val()))*100 //in cents
                });

            }
            //e.preventDefault();
        });

        // Close Checkout on page navigation:
        window.addEventListener('popstate', function() {
            handler.close();
        });

    }
});


/////////////////////////////////////////