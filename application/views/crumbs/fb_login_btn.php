<?php if( !is_mobile_device() ): ?>

    <div id="fb-root"></div>
    <div class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="true"></div>

    <p class="p-modal p-modal-or bold xxx"><?=$is_french_user ? '- ou -' : '- or -' ?></p>
<?php endif; ?>