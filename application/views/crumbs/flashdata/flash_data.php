<?php if( $this->session->flashdata('user_created') ): ?>
    <div class="alert alert-success col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa-lg fa fa-check"></i>
        <span><?=$this->session->flashdata('user_created')?></span>
    </div>
<?php endif; ?>

<?php if( $this->session->flashdata('user_logged_in') ): ?>
    <div class="alert alert-success col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa-lg fa fa-check"></i>
        <span><?=$this->session->flashdata('user_logged_in')?></span>
    </div>
<?php endif; ?>

<?php if( $this->session->flashdata('lesson_added') ): ?>
    <div class="alert alert-success col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa-lg fa fa-check"></i>
        <span><?=$this->session->flashdata('lesson_added')?></span>
    </div>
<?php endif; ?>

<?php if( $this->session->flashdata('answers_added') ): ?>
    <div class="alert alert-success col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa-lg fa fa-check"></i>
        <span><?=$this->session->flashdata('answers_added')?></span>
    </div>
<?php endif; ?>

<?php if( $this->session->flashdata('lectures_added') ): ?>
    <div class="alert alert-success col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa-lg fa fa-check"></i>
        <span><?=$this->session->flashdata('lectures_added')?></span>
    </div>
<?php endif; ?>

<?php if( $this->session->flashdata('user_added_to_organisation') ): ?>
    <div class="alert alert-success col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa-lg fa fa-check"></i>
        <span><?=$this->session->flashdata('user_added_to_organisation')?></span>
    </div>
<?php endif; ?>

<?php if( $this->session->flashdata('tutor_invited') ): ?>
    <div class="alert alert-success col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa-lg fa fa-check"></i>
        <span><?=$this->session->flashdata('tutor_invited')?></span>
    </div>
<?php endif; ?>

<?php if( $this->session->flashdata('article_deleted') ): ?>
    <div class="alert alert-success col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa-lg fa fa-check"></i>
        <span><?=$this->session->flashdata('article_deleted')?></span>
    </div>
<?php endif; ?>

<?php if( $this->session->flashdata('cv_uploaded') ): ?>
    <div class="alert alert-success col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa-lg fa fa-check"></i>
        <span><?=$this->session->flashdata('cv_uploaded')?></span>
    </div>
<?php endif; ?>

<?php if( $this->session->flashdata('cv_deleted') ): ?>
    <div class="alert alert-success col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa-lg fa fa-check"></i>
        <span><?=$this->session->flashdata('cv_deleted')?></span>
    </div>
<?php endif; ?>

<?php if( $this->session->flashdata('cert_payment_made') ): ?>
    <div class="alert alert-success col-md-10">
        <button class="close" data-close="alert"></button>
        <i class="fa-lg fa fa-check"></i>
        <span><?=$this->session->flashdata('cert_payment_made')?></span>
    </div>
<?php endif; ?>
