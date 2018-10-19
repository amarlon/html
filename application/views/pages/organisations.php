<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>


    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?>>
        <div class="portlet-title">
            <h1 class="padding-bottom-30"><?=$is_french_user ? 'Organisations sur Hotshi':'Organisations on Hotshi' ?></h1>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12 blog-page">

                    <div class="row">
                        <div class="col-md-9 col-sm-8 article-block">

                            <?php foreach( $organisations as $organisation ): ?>
                                <div class="row">
                                    <?php if($organisation['profile_image']): ?>
                                        <div class="col-md-4 blog-img blog-tag-data">
                                            <?php if( $is_logged_in ): ?>
                                                <a href="/org/org_profile/<?=$organisation['id']?>"><img src="<?=$organisation['profile_image']?>" alt="" class="img-responsive"></a>
                                            <?php else: ?>
                                                <a href="/page/login"><img src="<?=$organisation['profile_image']?>" alt="" class="img-responsive"></a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="col-md-8 blog-article">
                                        <h4>
                                            <a href="/org/org_profile/<?=$organisation['id']?>"><?=$organisation['name']?></a>
                                        </h4>
                                        <p><?=limit_str($organisation['about'], 300, 30)?></p>
                                        <?php if( $is_logged_in ): ?>
                                            <a class="btn btn-default" href="/org/org_profile/<?=$organisation['id']?>">View profile</a>
                                        <?php else: ?>
                                            <a class="btn btn-default" href="/page/login">View profile</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <br>
                                <hr>
                            <?php endforeach; ?>
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