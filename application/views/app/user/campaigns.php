<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>


    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?>>
        <div class="portlet-title">

            <div class="caption search-results-caption">
                <span class="caption-subject text">Email Campaigns</span>
                <div class="margin-top-20"></div>
            </div>

            <?php if( $is_logged_in && $user['is_hotshi_admin'] ): ?>
                <div class="actions">
                    <a href="/account/create_campaign" class="btn btn-sm btn-primary btn-large uppercase"><i class="fa fa-plus"></i> Create New Email campaign</a>
                </div>
            <?php endif; ?>

        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12 blog-page">
                    <div class="row">
                        <div class="col-md-10 col-sm-8 article-block">

                            <?php foreach( $campaigns as $campaign ): ?>
                                <?php
                                if( $campaign['send_to'] == 'Students' ) {
                                    $send_to_icon = 'Students';
                                } else if( $campaign['send_to'] == 'Organisations' ){
                                    $send_to_icon = 'Organisations';
                                } else {
                                    $send_to_icon = 'All';
                                }
                                ?>
                                <div class="row">
                                    <div class="col-md-9 blog-article">
                                        <iframe src="<?=base_url()?>/emails/campaign/<?=$campaign['id']?>" frameBorder="0" style="width:100%;height:600px;"></iframe>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <br>
                                        <a href="javascript:" class="btn btn-success btn-large-2 js-send-campaign-btn uppercase" data-campaign-id="<?=$campaign['id']?>">Send to <?=$send_to_icon?> <i class="fa fa-send"></i></a>
                                        <a href="javascript:" class="btn btn-danger btn-large-2 js-delete-campaign-btn uppercase" data-campaign-id="<?=$campaign['id']?>">Delete</a>
                                    </div>

                                </div>
                                <br>
                                <br>
                                <hr>
                                <br>
                                <br>
                            <?php endforeach; ?>

                            <?php if( !$campaigns ): ?>
                                <p>No results.</p>
                            <?php endif; ?>
                        </div>
                        <!--end col-md-9-->

                    </div>

                </div>
            </div>
        </div>
    </div>


<?php if( !$is_logged_in ): ?>
    </div>
    </div>
    </div>
<?php endif; ?>