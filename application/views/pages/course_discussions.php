<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>


    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?>>
        <div class="portlet-title">
            <div class="caption search-results-caption">
                <span class="caption-subject text"><?=$course['title']?> discussions</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12 blog-page">
                    <div class="row">
                        <div class="col-md-9 article-block course-page-right-content">

                            <?php if( $is_logged_in ): ?>
                                <h3>Hmmm...</h3>
                                <p>This feature is currently unavailable.</p>
                                <p>Sorry about that.</p>
                            <?php else: ?>
                                <h4>You must be logged in to access this area.</h4>
                                <p>Sorry about that.</p>
                            <?php endif; ?>



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