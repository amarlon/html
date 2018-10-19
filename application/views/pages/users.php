<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>

    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?>>
        <div class="portlet-title">
            <h1 class="padding-bottom-30">Users on Hotshi</h1>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12 blog-page">

                    <div class="row">
                        <div class="col-md-9 col-sm-8 article-block">

                            <?php foreach( $users as $user ): ?>
                                <div class="row">
                                    <div class="col-md-4 blog-img blog-tag-data">
                                        <a href="/page/login"><img src="<?=$user['image']?>" alt="" class="img-responsive"></a>
                                    </div>

                                    <div class="col-md-8 blog-article">
                                        <h4>
                                            <a href="/page/login"><?=$user['fullname']?></a>
                                        </h4>
                                        <p><?=limit_str($user['about'], 100, 30)?></p>
                                        <a class="btn btn-default" href="/page/login">View profile</a>
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