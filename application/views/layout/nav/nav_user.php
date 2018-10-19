<div class="page-header">
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top">
        <div class="container">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a class="scroll site-logo" href="/">
                    <img src="/assets/global/img/logo-landing-2.png" alt="Hotshi logo">
                </a>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu" id="tour-user-settings">
                <ul class="nav navbar-nav pull-right">

                    <li class="dropdown dropdown-extended dropdown-dark dropdown-notification">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="modal" data-target="#bs-search-modal">
                            <i class="icon-magnifier"></i>
                            <!--<span class="badge badge-default" style="margin-top:8px;font-weight:normal;">search</span>-->
                        </a>
                    </li>

                    <li class="droddown dropdown-separator hide-on-mobile"><span class="separator"></span></li>

                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <li class="dropdown dropdown-extended dropdown-dark dropdown-notification" id="header_notification_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-bell"></i>
                            <?php if( count($unread_comments) > 0 ): ?>
                                <span class="badge badge-danger" style="right:0;"><?=count($unread_comments)?></span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <h3><?=count($unread_comments) == 0 ? 'No notifications' : count($unread_comments).'+ unread comments' ?></h3>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                    <?php foreach( $unread_comments as $uc ): ?>
                                        <li>
                                            <?php
                                            $post_link = $uc['course_id'] ? '/org/discussions/'.$uc['organisation_id'].'/'.$uc['course_id'].'/'.$uc['id'].'?showcomments=true ' : '/account/feed/'.$uc['id'].'?showcomments=true ';
                                            ?>
                                            <a href="<?=$post_link?>">
                                                <span class="details">
                                                    <span><i class="fa fa-comments"></i></span> <?=limit_str($uc['description'], 30, 30)?>
                                                </span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- END NOTIFICATION DROPDOWN -->


                    <!-- BEGIN INBOX DROPDOWN -->
                    <li class="dropdown dropdown-extended dropdown-dark dropdown-inbox" id="header_inbox_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-envelope"></i>
                            <?php if( $notifications[0]['total_notifications_count'] > 0 ): ?>
                                <span class="badge badge-danger"><?=$notifications[0]['total_notifications_count']?></span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <?php
                                if( $notifications[0]['total_conversations'] == 0 ) {
                                    $conversation_text = '';
                                } else if( $notifications[0]['total_conversations'] == 1 ) {
                                    $conversation_text = ', <b>1 conversation</b>';
                                } else {
                                    $conversation_text = ', <b>'.$notifications[0]['total_conversations'] . ' conversations</b>';
                                }
                                ?>
                                <h3><strong><?=$notifications[0]['total_notifications_count']?></strong> unread<?=$conversation_text?></h3>
                                <a href="/account/inbox">Go to Inbox</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                    <?php foreach( $notifications as $contact ): ?>
                                        <?php if( isset($contact['latest_contact_msg']) ): ?>

                                            <li>
                                                <a href="/account/inbox?contactid=<?=$contact['id']?>">
                                                <span class="photo">
                                                    <img src="<?=$contact['image']?>" alt="">
                                                </span>
                                                <span class="subject">
                                                    <span class="from"><?=$contact['fullname']?> </span>
                                                    <span class="time"><?=$contact['latest_contact_msg']['date_created']?> </span>
                                                </span>
                                                    <span class="message"><?=strip_tags(limit_str($contact['latest_contact_msg']['description'], 30, 30))?> </span>
                                                </a>
                                            </li>

                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="droddown dropdown-separator hide-on-mobile"><span class="separator"></span></li>

                    <!-- END INBOX DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" src="<?=$thisuser['image'] ? $thisuser['image'] : get_default_avatar() ?>">
                            <span class="username username-hide-mobile font-12px" style="font-size:12px;"><?=$thisuser['firstname']?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="javascript:" class="tooltips" data-placement="left" data-original-title="<?=$is_french_user ? 'en':'fr'?>" style="background:none;padding-top:13px;" id="toggle-lang-btn"><?=$is_french_user ? '<b class="lang-text" title="en" data-lang="en">EN</b>' : '<b class="lang-text" title="fr" data-lang="fr">FR</b>' ?></a>
                            </li>
                            <li>
                                <a href="/page/profile/<?=$this->session->userdata('id')?>">
                                    <i class="icon-user"></i> <?=$is_french_user ? 'Mon profil':'My profile' ?></a>
                            </li>
                            <li>
                                <a href="/account/inbox">
                                    <i class="icon-envelope-open"></i> Messages <?=$notifications[0]['total_notifications_count'] > 0 ? '<span class="badge badge-danger">'.$notifications[0]['total_notifications_count'].'</span>':'' ?>
                                </a>
                            </li>
                            <?php if( $thisuser['is_hotshi_admin'] ): ?>
                                <li>
                                    <a href="/account/campaigns">
                                        <i class="fa fa-send"></i> Campaigns</a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a href="/account/ads">
                                    <i class="icon-note"></i> <?=$is_french_user ? 'Mes publicités':'My Ads' ?> </a>
                            </li>
                            <li>
                                <a href="/account/settings">
                                    <i class="icon-settings"></i> <?=$is_french_user ? 'Paramètres':'Settings' ?> </a>
                            </li>

                            <li>
                                <a href="/page/logout">
                                    <i class="icon-key"></i> <?=$is_french_user ? 'Déconnecter ':'Log Out' ?> </a>
                            </li>

                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>


    </div>
    <!-- END HEADER TOP -->

    <!-- BEGIN HEADER MENU -->
    <div class="page-header-menu">
        <div class="container">
            <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
            <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
            <div class="hor-menu" id="tour-main-nav" style="background:#391C4A;">
                <ul class="nav navbar-nav">

                    <?php if( $is_organisation_member && !is_mobile_device() ): ?>
                        <li class="start-tour-btn" data-page="<?=$this->router->method?>"><a href="javascript:" id="tour-end-feed"><i class="icon-screen-desktop"></i> <?=$is_french_user ? 'Visite':'Tour' ?> </a></li>
                    <?php endif; ?>

                    <!--<li class="<?/*=$active_search*/?> hide-on-desktop show-on-mobile"><a href="javascript:;" data-toggle="modal" data-target="#bs-search-modal"><i class="icon-magnifier"></i> Search</a></li>-->
                    <?php if( $is_organisation_member ): ?>
                        <li class="menu-dropdown classic-menu-dropdown <?=$active_org_profile?>">
                            <a id="tour-my-organisation" data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;"><i class="icon-home"></i> <?=$is_french_user ? 'Mes organisations':'My organisations' ?> <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu pull-left" style="max-height:400px;overflow-y:auto;">
                                <?php foreach( $user_organisations as $user_org ): ?>
                                    <li><a href="/org/org_profile/<?=$user_org['organisation_id']?>"><?=$user_org['is_organisation_admin'] ? '<i class="fa fa-home"></i>':'<i class="fa fa-lock"></i>' ?> <?=$user_org['organisations_name']?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <li class="menu-dropdown classic-menu-dropdown <?=$active_course?>">
                        <a id="tour-my-courses" data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;"><?=$is_french_user ? 'Mes cours':'My courses' ?> <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu pull-left">
                            <li class=" dropdown-submenu">
                                <a href="javascript:;"><?=$is_french_user ? 'Inscrit':'Enrolled' ?></a>
                                <ul class="dropdown-menu">
                                    <?php if( $enrolled_courses ): ?>
                                        <?php foreach( $enrolled_courses as $ec ): ?>
                                            <li><a href="/org/course/<?=$ec['organisation_id']?>/<?=$ec['course_id']?>"><?=$ec['course_title']?></a></li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li><a href="javascript:;">You haven't enrolled in any courses.</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                            <li class=" dropdown-submenu">
                                <a href="javascript:;"><?=$is_french_user ? 'Mes certificats':'My certificates' ?></a>
                                <ul class="dropdown-menu">
                                    <?php if( $enrolled_courses ): ?>
                                        <?php foreach( $enrolled_courses as $ec ): ?>
                                            <li><a href="/account/certificate/<?=$ec['course_id']?>"><?=$ec['course_title']?></a></li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li><a href="javascript:;">You haven't enrolled in any courses.</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                            <?php if( $is_organisation_member ): ?>
                                <li class=" dropdown-submenu">
                                    <a href="javascript:;"><?=$is_french_user ? 'Tutorat':'Tutoring' ?></a>
                                    <ul class="dropdown-menu">
                                        <?php foreach( $tutor_courses as $tc ): ?>
                                            <li><a href="/org/course/<?=$tc['organisation_id']?>/<?=$tc['id']?>"><?=$tc['title']?></a> </li>
                                        <?php endforeach ?>
                                        <?php if(!$tutor_courses): ?>
                                            <li><a href="javascript:;">You're not yet a tutor of any course.</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <li class="menu-dropdown classic-menu-dropdown course-cat-mobile-menu <?=$active_courses?>">
                        <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;"><?=$is_french_user ? 'Trouver un cours':'Find a course' ?> <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu pull-left" style="max-height:400px;overflow-y:auto;">
                            <li><a href="/org/courses">* <?=$is_french_user ? 'Tous les cours':'All courses' ?></a></li>
                            <?php foreach( $course_categories as $cat ): ?>
                                <li><a href="/org/courses/<?=$cat['id']?>"><?=$cat['name']?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                    <li class="dropdown dropdown-megamenu course-cat-desktop-menu <?=$active_courses?>">
                        <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#"><?=$is_french_user ? 'Trouver un cours':'Find a course' ?> <i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu categories-menu">
                            <li>
                                <div class="header-navigation-content">
                                    <div class="row">
                                        <div class="col-md-3 header-navigation-col">
                                            <ul>
                                                <li><a href="/org/courses">* <?=$is_french_user ? 'Tous les cours':'All courses' ?></a></li>
                                            </ul>
                                        </div>
                                        <?php foreach( $course_categories as $cat ): ?>
                                            <div class="col-md-3 header-navigation-col">
                                                <ul>
                                                    <li><a href="/org/courses/<?=$cat['id']?>"><?=$cat['name']?></a></li>
                                                </ul>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="<?=$active_home?>" id="news-feed"><a href="/" id="tour-news-feed">News feed</a></li>

                    <?php if( !$organisation_admin_user ): ?>
                        <li class="<?=$active_profile?>"><a href="/page/profile/<?=$this->session->userdata('id')?>">Profile</a></li>
                    <?php endif; ?>

                    <li class="<?=$active_inbox?>"><a href="/account/inbox">Connections</a></li>

                    <li class="menu-dropdown classic-menu-dropdown <?=$active_articles?>">
                        <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
                            Pages <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-left">
                            <li><a href="/page/articles"><i class="fa fa-pencil"></i> Articles</a></li>
                            <li><a href="/page/organisations"><i class="fa fa-bank"></i> Organisations</a></li>
                        </ul>
                    </li>

                    <li class="menu-dropdown classic-menu-dropdown <?=$active_opportunities?>">
                        <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="javascript:;">
                            <?=$is_french_user ? 'Opportunités':'Opportunities' ?> <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-left">
                            <li aria-haspopup="true" class="dropdown-submenu ">
                                <a href="javascript:;" class="nav-link nav-toggle ">
                                    <i class="icon-list"></i> <?=$is_french_user ? 'Projets':'Projects' ?>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li aria-haspopup="true" class=" ">
                                        <a href="/page/projects/my" class="nav-link"><i class="icon-user"></i> <?=$is_french_user ? 'Mes Projets':'My Projects' ?> </a>
                                    </li>
                                    <li aria-haspopup="true" class=" ">
                                        <a href="/page/projects" class="nav-link ">
                                            <i class="fa fa-dot-circle-o"></i> <?=$is_french_user ? 'Tous les Projets':'All Projects' ?> </a>
                                    </li>
                                </ul>
                            </li>
                            <li aria-haspopup="true" class="dropdown-submenu ">
                                <a href="javascript:;" class="nav-link nav-toggle ">
                                    <i class="icon-list"></i> <?=$is_french_user ? 'Emplois':'Jobs' ?>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li aria-haspopup="true" class=" ">
                                        <a href="/page/jobs/my" class="nav-link "><i class="icon-user"></i> <?=$is_french_user ? 'Mes Emplois':'My Jobs' ?></a>
                                    </li>
                                    <li aria-haspopup="true" class=" ">
                                        <a href="/page/jobs" class="nav-link "><i class="fa fa-dot-circle-o"></i><?=$is_french_user ? 'Tous les Emplois':'All Jobs' ?> </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- END HEADER MENU -->


</div>
<!-- END HEADER -->