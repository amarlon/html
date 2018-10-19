<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>


    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?>>
        <div class="portlet-title">
            <div class="caption search-results-caption">
                <span class="caption-subject text"><?=$is_french_user ? 'A propos de Hotshi':'About Hotshi' ?></span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12 blog-page">
                    <div class="row">
                        <div class="col-md-10 article-block">

                            <?php if( $is_french_user ): ?>
                                <p>Nous sommes plus qu’un réseau social. Avec Hotshi, les Professionnels peuvent trouver des emplois, <br>les Entrepreneurs peuvent trouver des investisseurs et collaborateurs dont ils ont besoins et <br>les Intellectuels peuvent faire connaitre leur idées et inventions.</p>
                            <?php else: ?>
                                <p>We are more than just a social network. With Hotshi, Professionals can find jobs, <br>Entrepreneurs can find investors and collaborators they are looking for and <br>Intellectuals can share their ideas and inventions.</p>
                            <?php endif; ?>

                            <h4 class="padding-top-20 fw100"><?=$is_french_user ? 'Contactez nous':'Contact Us' ?></h4>
                            <p><?=$is_french_user ? 'Pour en savoir plus sur Hotshi, contactez-nous à:':'To learn more about Hotshi, please contact us at:' ?> <a href="mailto:info@hotshi.com?Subject=Hello">info@hotshi.com</a>. </p>

                            <h4 class="padding-top-10 fw100"><?=$is_french_user ? 'Localisation':'Location' ?></h4>
                            <p><?=$is_french_user ? 'Dublin, Irlande':'Dublin, Ireland' ?>.</p>

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