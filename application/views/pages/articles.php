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
                        <div class="col-md-9 col-sm-8 article-block">

                            <?php foreach( $articles as $article ): ?>
                                <div class="row">
                                    <?php if($article['image']): ?>
                                        <div class="col-md-4 blog-img blog-tag-data">
                                            <?php if( $is_logged_in ): ?>
                                                <a href="/page/article/<?=$article['id']?>"><img src="<?=$article['image']?>" alt="" class="img-responsive"></a>
                                            <?php else: ?>
                                                <a href="/page/login"><img src="<?=$article['image']?>" alt="" class="img-responsive"></a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="col-md-8 blog-article">
                                        <h3>
                                            <a href="/page/article/<?=$article['id']?>"><?=$article['title']?></a>
                                        </h3>
                                        <p><?=limit_str($article['description'], 300, 30)?></p>
                                        <?php if( $is_logged_in ): ?>
                                            <a class="btn btn-default" href="/page/article/<?=$article['id']?>">Read more</a>
                                        <?php else: ?>
                                            <a class="btn btn-default" href="/page/login">Read more</a>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <br>
                                <hr>
                            <?php endforeach; ?>

                            <?php if( !$articles ): ?>
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