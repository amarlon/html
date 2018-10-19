<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>


    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?>>
        <div class="portlet-title">

            <div class="caption search-results-caption">
                <span class="caption-subject text"><?=$is_my ? 'My Posted Jobs':'Jobs on Hotshi'?></span>
                <div class="margin-top-20"></div>
            </div>

            <?php if( $is_logged_in ): ?>
                <div class="actions">
                    <a href="/account/create_opportunity" class="btn btn-sm btn-primary btn-large uppercase"><i class="fa fa-plus"></i> <?=$is_french_user ? 'CRÉER UN NOUVEL EMPLOI':'Create new Job opportunity' ?>, <span class="bold" style="font-size:17px;">&euro;<?=CREATE_OPPORTUNITY_COST?></span></a>
                </div>
            <?php endif; ?>

        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12 blog-page">
                    <div class="row">
                        <div class="col-md-9 col-sm-8 article-block">
                            <?php foreach( $opportunities as $opportunity ): ?>
                                <?php if( strtotime($opportunity['date_created']) < strtotime('-'.CREATE_OPPORTUNITY_MAX_DAYS.' days') ): ?>

                                <?php else: ?>
                                    <div class="row">
                                        <?php if($opportunity['image']): ?>
                                            <div class="col-md-4 blog-img blog-tag-data">
                                                <?php if( $is_logged_in ): ?>
                                                    <a href="/page/opportunity/<?=$opportunity['id']?>"><img src="<?=$opportunity['image']?>" alt="" class="img-responsive"></a>
                                                <?php else: ?>
                                                    <a href="/page/login"><img src="<?=$opportunity['image']?>" alt="" class="img-responsive"></a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="col-md-8 blog-article">
                                            <h3>
                                                <a href="/page/opportunity/<?=$opportunity['id']?>"><?=$opportunity['title']?></a>
                                            </h3>
                                            <p><?=limit_str($opportunity['description'], 300, 30)?></p>
                                            <br>
                                            <?php if( $is_logged_in ): ?>
                                                <a class="btn btn-default" href="/page/opportunity/<?=$opportunity['id']?>">More... <?=$opportunity['user_id'] == $this->session->userdata('id') ? '<i class="icon-user"></i>':'' ?></a>
                                            <?php else: ?>
                                                <a class="btn btn-default" href="/page/login">More...</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                <?php endif; ?>

                            <?php endforeach; ?>

                            <?php if( !$opportunities ): ?>
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