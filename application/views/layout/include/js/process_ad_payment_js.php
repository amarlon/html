<script type="text/javascript" src="https://checkout.stripe.com/checkout.js"></script>
<script type="text/javascript" src="/assets/global/scripts/parsley.min.js"></script>
<script type="text/javascript" src="/assets/global/scripts/moment.min.js"></script>


<script>
    //ignore invisible fields
    Parsley.on('field:validated', function(fieldInstance){
        if (fieldInstance.$element.is(":hidden")) {
            // hide the message wrapper
            fieldInstance._ui.$errorsWrapper.css('display', 'none');
            // set validation result to true
            fieldInstance.validationResult = true;
            return true;
        }
    });
</script>

<script src="/assets/admin/pages/scripts/hotshi/process_ad_payment.js?v=<?=FILE_VERSION?>"></script>