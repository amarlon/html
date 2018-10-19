/////////////////////////////////////////

$(function(){


    $('#create-opportunity-form').parsley();

    $('#create-opportunity-form').on('submit', function(e){
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
                    'title' : $('#title').val(),
                    'description' : $('#description').val(),
                    'skills' : $('#tags_1').val(),
                    'qualifications' : $('#qualifications').val(),
                    'location' : $('#location').val()
                };

                $.ajax({
                    type : 'POST',
                    url  : '/ajax/account/create_opportunity',
                    data : message,
                    dataType    : "json",
                    success: function(data){

                        if( data.status == 'error' ) {
                            $spinner.hide();
                            alert(data.message);
                            return false;
                        } else {
                            $('#create-opportunity-form').append('<input type="hidden" name="opportunity_id" value="'+data.opportunity_id+'">');
                            var $formData = new FormData($('#create-opportunity-form')[0]);
                            $.ajax({
                                type : 'POST',
                                url  : '/ajax/account/upload_opportunity_image',
                                data : $formData,
                                dataType    : "json",
                                processData: false,
                                contentType: false,
                                success: function(d){
                                    alert(data.message);
                                    window.location = '/page/jobs/my';
                                },
                                error:function(xhr, status, error){
                                    alert(data.message);
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

            if( $('#title').val() && $('#description').val() && $('#tags_1').val() && $('#qualifications').val() && $('#location').val() ) {

                handler.open({
                    name: 'Hotshi',
                    description: 'My Jobs Opportunity',
                    zipCode: false,
                    currency : 'eur',
                    amount: (parseFloat($('#js_create_opportunity_cost').val()))*100 //in cents
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