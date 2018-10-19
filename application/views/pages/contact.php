<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>


    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?>>
        <div class="portlet-title">
            <div class="caption search-results-caption">
                <span class="caption-subject text">Say Hello</span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12 blog-page">
                    <div class="row">
                        <div class="col-md-9 article-block">
                            <h4 class="padding-top-10 fw100">Contact Us</h4>
                            <p>To learn more about Hotshi, please contact us at: <a href="mailto:info@hotshi.com?Subject=Hello">info@hotshi.com</a>. </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 article-block">
                            <h4 class="padding-top-10 fw100">Location</h4>
                            <p>Dublin, Ireland.</p>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 article-block">
                            <h4 class="padding-top-10 fw100">Tel</h4>
                            <p>+353 899587446.</p>
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