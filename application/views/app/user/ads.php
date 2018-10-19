<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>

    <?=$create_ad_modal?>
    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?>>
        <div class="portlet-title">
            <div class="caption search-results-caption">
                <span class="caption-subject text"><?=$is_french_user ? 'Mes publicités':'My Ads' ?></span>
                <?php if( $user['is_hotshi_admin'] ): ?>
                    <h5 class="text-green bold"><i class="fa fa-eye"></i> ADMINISTRATOR VIEW | MANAGE ADS</h5>
                <?php endif; ?>
                <div class="margin-top-20"></div>
            </div>

            <div class="actions">
                <a href="" data-toggle="modal" data-target="#create-ad-modal" class="btn btn-sm btn-primary btn-large uppercase"><i class="fa fa-plus"></i> <?=$is_french_user ? 'Créer de nouvelles publicités':'Create new ad' ?></a>
            </div>
        </div>
        <style>
            .btn-primary, .btn-primary:focus, .btn-primary:hover{
                border: none;
            }
        </style>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12 blog-page">
                    <div class="row">
                        <div class="col-md-9 col-sm-8 article-block">
                            <div class="col-md-9 col-sm-8 article-block">
                                <?php foreach( $ads as $ad ): ?>
                                    <div class="row">
                                        <div class="col-md-6 blog-img blog-tag-data">
                                            <a href="javascript:" class="cursor-default"><img src="<?=$ad['image']?>" alt="" class="img-responsive"></a>
                                        </div>

                                        <div class="col-md-6 blog-article">
                                            <p class="font-12px"><span class="text-grey">Description</span>: <?=limit_str($ad['description'], 300, 30)?></p>
                                            <br>
                                            <p class="font-12px margin-zero"><span class="text-grey">User</span>: <a href="/page/profile/<?=$ad['user_id']?>" class="underline"><?=$ad['user_fullname']?></a> </p>
                                            <p class="font-12px margin-zero"><span class="text-grey">Runs</span>: <span class="bold"><?=date('jS M Y', strtotime($ad['start_date']))?></span> to <span class="bold"><?=date('jS M Y', strtotime($ad['end_date']))?></span></p>
                                            <?php if( $ad['end_date'] == date('Y-m-d') ): ?>
                                                <p class="font-12px"><span class="text-grey">Status</span>: <span class="text-red bold">EXPIRED</span></p>
                                            <?php elseif( $ad['is_active'] ): ?>
                                                <p class="font-12px"><span class="text-grey">Status</span>: <span class="text-green bold">ACTIVE</span></p>
                                            <?php else: ?>
                                                <p class="font-12px"><span class="text-grey">Status</span>: <span class="text-orange bold">PENDING REVIEW</span></p>
                                            <?php endif; ?>

                                            <?php if( $ad['user_id'] == $this->session->userdata['id'] ): ?>
                                                <?php if( $ad['end_date'] < date('Y-m-d') ): ?>
                                                    <a class="btn btn-default js-delete-ad-btn" href="javascript:" data-ad-id="<?=$ad['id']?>"><i class="icon-trash"></i> Delete</a>
                                                <?php else: ?>
                                                    <a class="btn btn-primary text-white" href="/account/edit_ad/<?=$ad['id']?>"><i class="icon-note"></i> Edit</a>
                                                    <a class="btn btn-default js-delete-ad-btn" href="javascript:" data-ad-id="<?=$ad['id']?>"><i class="icon-trash"></i> Delete</a>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if( $user['is_hotshi_admin'] && $ad['end_date'] > date('Y-m-d') ): ?>
                                                <?php if( $ad['is_active'] ): ?>
                                                    <a class="btn btn-danger js-disapprove-ad-btn" href="javascript:" data-ad-id="<?=$ad['id']?>"><i class="fa fa-times"></i> Dis-approve</a>
                                                <?php else: ?>
                                                    <a class="btn btn-success js-approve-ad-btn" href="javascript:" data-ad-id="<?=$ad['id']?>"><i class="fa fa-check"></i> Approve</a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                <?php endforeach; ?>

                                <?php if( !$ads ): ?>
                                    <p>You haven't created any Ads.</p>
                                <?php endif; ?>
                            </div>

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