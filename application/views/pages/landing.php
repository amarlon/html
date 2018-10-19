<!-- Banner block BEGIN -->
<div class="promo-block full-bg-img" id="banner">

    <div class="tp-banner-container">

        <div class="centered-banner-content">
            
            <img src="/assets/global/img/logo-landing-2.png" class="logo-landing">

            <?php if( $is_french_user ): ?>
                <h1>Connectez-vous avec les intellectuels, professionnels et entrepreneurs africains.</h1>
            <?php else: ?>
                <h1>Connect with African Intellectuals, Professionals and Entrepreneurs.</h1>
            <?php endif; ?>

            <div class="col-lg-12 cta-banner-landing-wrapper">
                <a href="#bs-signup-modal" data-toggle="modal" class="btn btn-landing register"><i class="icon-note"></i> <?=$is_french_user ? 'Inscription':'Register'?></a>
                <a href="/page/login" class="btn btn-landing"><i class="icon-user"></i> <?=$is_french_user ? 'Connexion':'Login'?></a>
            </div>

        </div>

        <div class="tp-banner">
            <ul>
                <li data-transition="fade">
                    <img src="/assets/frontend/onepage/img/silder/landing-img-3.jpg" alt="" data-bgfit="cover" style="opacity:0.4 !important;" data-bgposition="center center" data-bgrepeat="no-repeat">
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Banner block END -->

<div class="services-block content content-center" id="services">
    <div class="container">
        <h2><?=$is_french_user ? 'Pourquoi joindre Hotshi ?':'Why join Hotshi?' ?></h2>

        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12 item">
                <i class="fa icon-refresh"></i>
                <?php if( $is_french_user ): ?>
                    <h3>Connectez</h3>
                    <p>Hotshi contient toutes les fonctionalités requises pour un site de réseau social. Nous connectons les gens avec la meilleure chose : l’éducation ! REJOIGNEZ-NOUS !</p>
                <?php else: ?>
                    <h3>Connect</h3>
                    <p>Hotshi contains all the things you'd expect in a social networking site. We connect people with the best thing-education! JOIN US!</p>
                <?php endif; ?>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 item">
                <i class="fa icon-bubble"></i>
                <?php if( $is_french_user ): ?>
                    <h3>Collaborez</h3>
                    <p>Collaborez avec d'autres intellectuels, professionnels, entrepreneurs et établissements d'enseignement pour obtenir des opportunités et de nouvelles compétences.</p>
                <?php else: ?>
                    <h3>Collaborate</h3>
                    <p>Collaborate with other intellectuals, professionals, entrepreneurs, and educational institutions to get opportunities and new skills.</p>
                <?php endif; ?>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 item">
                <i class="fa icon-graph"></i>
                <?php if( $is_french_user ): ?>
                    <h3>Elargissez</h3>
                    <p>Elargissez votre réseau de professionnels et profitez de nouvelles opportunités et améliorez vos compétences.</p>
                <?php else: ?>
                    <h3>Grow</h3>
                    <p>Grow your network of professionals and get new opportunities and improve your skills.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="choose-us-block content text-center margin-bottom-40" id="benefits">
    <div class="container">
        <h2><?=$is_french_user ? 'Fonctionnalités de Hotshi':'Hotshi features' ?></h2>
        <?php if( $is_french_user ): ?>
            <h4>Voici quelques-uns des avantages de rejoindre Hotshi.</h4>
        <?php else: ?>
            <h4>Below are some of the benefits of joining Hotshi.</h4>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 text-left">
                <img src="/assets/global/img/hotshi-features-2.png" alt="Why to choose us" class="img-responsive">
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 text-left">
                <div class="panel-group" id="accordion1">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_1_1"><?=$is_french_user ? 'Opportunités':'Opportunities' ?></a>
                            </h5>
                        </div>
                        <div id="accordion1_1_1" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <?php if( $is_french_user ): ?>
                                    <p>Obtenez des offres d'emploi, de carrière, d'affaire et des bourses d'études provenant des entreprises et des institutions.</p>
                                <?php else: ?>
                                    <p>Get employment, career, business and scholarship opportunities from companies and institutions.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_1"><?=$is_french_user ? 'Profil':'Profile' ?></a>
                            </h5>
                        </div>
                        <div id="accordion1_1" class="panel-collapse collapse">
                            <div class="panel-body">
                                <?php if( $is_french_user ): ?>
                                    <p>Construisez un excellent profil en ajoutant vos compétences, vos expériences professionnelles, vos articles, photo et plus pour obtenir un emploi, un recrutement et d'autres opportunités.</p>
                                <?php else: ?>
                                    <p>Edit a great profile by adding your skills, professional experiences, pictures articles and more to get employment, recruitment, and other opportunities.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_2"><?=$is_french_user ? 'Nouvelles en temps réel':'Real-Time feed' ?></a>
                            </h5>
                        </div>
                        <div id="accordion1_2" class="panel-collapse collapse">
                            <div class="panel-body">
                                <?php if( $is_french_user ): ?>
                                    <p>Créez, commentez et consultez les publications des nouvelles des autres utilisateurs.</p>
                                <?php else: ?>
                                    <p>Create and see post of news from other users and comment them.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_3"><?=$is_french_user ? 'Messagerie':'Messaging' ?></a>
                            </h5>
                        </div>
                        <div id="accordion1_3" class="panel-collapse collapse">
                            <div class="panel-body">
                                <?php if( $is_french_user ): ?>
                                    <p>Envoyez des messages privés à vos connexions, aux tuteurs et aux employeurs.</p>
                                <?php else: ?>
                                    <p>Send private messages to your connexions, tutors and employers.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_4"><?=$is_french_user ? 'Inscrire':'Enrol' ?></a>
                            </h5>
                        </div>
                        <div id="accordion1_4" class="panel-collapse collapse">
                            <div class="panel-body">
                                <?php if( $is_french_user ): ?>
                                    <p>Inscrivez-vous pour les cours de votre choix.</p>
                                <?php else: ?>
                                    <p>Enrol for courses of your choice.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_5"><?=$is_french_user ? 'Certificat':'Certificate' ?></a>
                            </h5>
                        </div>
                        <div id="accordion1_5" class="panel-collapse collapse">
                            <div class="panel-body">
                                <?php if( $is_french_user ): ?>
                                    <p>Obtenez un certificat des cours que vous prenez.</p>
                                <?php else: ?>
                                    <p>Get certified from the courses you take.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_6"><?=$is_french_user ? 'Discussions':'Discussions' ?></a>
                            </h5>
                        </div>
                        <div id="accordion1_6" class="panel-collapse collapse">
                            <div class="panel-body">
                                <?php if( $is_french_user ): ?>
                                    <p>Commencez et participez à des discussions avec d'autres utilisateurs et enseignants pour donner votre contribution pour mieux appréhender de grands sujets.</p>
                                <?php else: ?>
                                    <p>Start and get involved in discussions with other learners and teachers to give your contributions and learn about great topics.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_7"><?=$is_french_user ? 'Créer un contenu':'Create content' ?></a>
                            </h5>
                        </div>
                        <div id="accordion1_7" class="panel-collapse collapse">
                            <div class="panel-body">
                                <?php if( $is_french_user ): ?>
                                    <p>Ecrire des articles, des publications, des commentaires, etc.</p>
                                <?php else: ?>
                                    <p>Write articles, posts, comment etc.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="team-block content content-center margin-bottom-40" id="team" style="background:#f6f6f6;margin-bottom:0 !important;">
    <div class="container">
        <h2><?=$is_french_user ? 'Nos partenaires':'Our partners' ?></h2>
        <h4><?=$is_french_user ? 'Nous nous associons avec':'We collaborate with…' ?></h4>
        <div class="row hotshi-partners">
            <?php foreach($hotshi_partners as $hp):  ?>
                <div class="col-md-4 col-sm-4 col-xs-6 item">
                    <a href="/org/org_profile/<?=$hp['id']?>">
                        <img src="<?=$hp['profile_image']?>" alt="<?=$hp['name']?>" class="img-responsive">
                        <h3><?=$hp['name']?></h3>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<div class="message-block content content-center valign-center" id="message-block">
    <div class="valign-center-elem">
        <h2><?=$is_french_user ? 'Créez votre compte':'Create Your account' ?></h2>
        <p style="font-size:13px;color:#fff;padding-bottom:20px;"><?=$is_french_user ? 'C\'est gratuit de rejoindre':'It\'s free to join' ?></p>
        <a href="#bs-signup-modal" data-toggle="modal" class="btn btn-landing register"><i class="icon-note"></i> <?=$is_french_user ? 'Inscription':'Register' ?></a>
    </div>
</div>

<div class="footer">
    <div class="container">
        <div class="row">
            <!-- BEGIN COPYRIGHT -->
            <div class="col-md-6 col-sm-6">
                <div class="copyright"><?=date('Y')?> &copy; Hotshi. ALL Rights Reserved | <a href="/page/privacy" style="text-decoration:underline;color:#fff !important;"><?=$is_french_user ? 'Confidentialité':'Privacy' ?></a></div>
            </div>
            <!-- END COPYRIGHT -->
            <!-- BEGIN SOCIAL ICONS -->
            <div class="col-md-6 col-sm-6 pull-right">
                <ul class="social-icons">
                    <li><a class="facebook" target="_blank" data-original-title="facebook" href="https://www.facebook.com/Hotshi-1071796086195671/"></a></li>
                    <li><a class="twitter" target="_blank" data-original-title="twitter" href="https://twitter.com/HotshiDAC"></a></li>
                    <li><a class="googleplus" target="_blank" data-original-title="googleplus" href="https://plus.google.com/u/0/108066069539470645831"></a></li>
                    <li><a class="linkedin" target="_blank" data-original-title="linkedin" href="https://www.linkedin.com/company/hotshi-dac?trk=nav_account_sub_nav_company_admin"></a></li>
                    <li><a class="youtube" target="_blank" data-original-title="youtube" href="https://www.youtube.com/channel/UC5SCEuRuN9t3nnt1_WqWzsQ"></a></li>
                </ul>
            </div>
            <!-- END SOCIAL ICONS -->
        </div>
    </div>
</div>