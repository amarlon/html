<?=$header?>

<?=$nav?>

<?php if( $is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
    <input type="hidden" value="<?=$this->router->method?>" id="js-current-route">
<?php endif; ?>

<?=$flash_data?>
<?=$page_view?>

<?php if( $is_logged_in ): ?>
    </div>
    </div>
    </div>
<?php endif; ?>

<?=$search_modal?>
<?=isset($signup_modal) ? $signup_modal : '' ?>
<?=isset($fb_user_modal) ? $fb_user_modal : '' ?>
<?=isset($forgot_password_modal) ? $forgot_password_modal : '' ?>

<?=$footer?>