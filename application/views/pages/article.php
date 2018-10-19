<?php if( !$is_logged_in ): ?>
    <div class="page-container">
        <div class="page-content">
            <div class="container view-container">
<?php endif; ?>


    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?>>
        <div class="portlet-title">
            <?=$articles_breadcrumb?>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12 blog-page">
                    <div class="row">
                        <div class="col-md-9 article-block">
                            <?php if( $article['image'] ): ?>
                                <div class="blog-tag-data">
                                    <img src="<?=$article['image']?>" class="img-responsive" alt="">
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <p style="padding-left:15px;" class="font-12px padding-bottom-20"><i class="fa fa-clock-o"></i> <i>Created <?=time_elapsed_string(strtotime($article['date_created']))?> ago</i></p>
                            </div>

                            <div>
                                <p><?=$article['description']?></p>
                            </div>
                            <hr>

                        </div>

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