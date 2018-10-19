/////////////////////////////////////////

$(function(){

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
                    'course_id' : $('#course-id').val(),
                    'payment_type' : 'card',
                    'discount_code' : $('#discount-code').val()
                };

                $.ajax({
                    type : 'POST',
                    url  : '/ajax/account/process_cert_payment',
                    data : message,
                    dataType    : "json",
                    success: function(data){

                        if( data.status == 'error' ) {
                            $spinner.hide();
                            alert(data.message);
                            return false;
                        } else {
                            location.reload();
                        }
                    },
                    error:function(xhr, status, error){
                        $spinner.hide();
                        alert('Oops! Problem processing your payment. Don\'t worry, we haven\'t deducted anything. Please try again.');
                    }
                });

            }
        });

        document.getElementById('customCheckoutButton').addEventListener('click', function(e) {

            handler.open({
                name: 'Hotshi',
                description: 'Course Payment',
                zipCode: false,
                currency : 'eur',
                amount: parseInt($('#cert-cost').val())*100 //in cents
            });
        });

        // Close Checkout on page navigation:
        window.addEventListener('popstate', function() {
            handler.close();
        });

    }
});


/////////////////////////////////////////