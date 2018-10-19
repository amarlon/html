<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>

    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?> >
        <div class="portlet-title">
            <div class="caption search-results-caption">
                <span class="caption-subject text">Courses on Hotshi</span>
                <span class="caption-helper"> <?=$course_category ? '<i class="fa fa-angle-right"></i> '.$course_category['name'].'' : ''?> <?=$course_level ? '<i class="fa fa-angle-right"></i> '.$course_level['name'].'' : ''?></span>
                <div class="margin-top-20"></div>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <!-- BEGIN CONTENT -->
                <div class="col-md-12 col-sm-12">
                    <div class="content-page">
                        <div class="row">
                            <div class="col-md-2 col-sm-3">
                                <p class="bold"><i class="fa  fa-arrow-down"></i> Level</p>
                                <hr>
                                <?php foreach( $course_levels as $cl ): ?>
                                    <p class="course-level-list">- <a href="/org/courses/<?=$course_category_id?>/<?=$cl['id']?>"><?=$cl['name']?></a></p>
                                    <hr>
                                <?php endforeach; ?>
                                <p class="course-level-list"><a href="/org/courses">- <?=$is_french_user ? 'Tous les cours':'All courses' ?></a></p>
                            </div>
                            <div class="col-md-10 col-sm-9">
                                <?php foreach( $courses as $course): ?>
                                    <?php if( $course['can_enrol'] ): ?>
                                        <a href="/org/course/<?=$course['organisation_id']?>/<?=$course['id']?>">
                                            <div class="col-md-4 videos-grid">
                                                <div class="videos-grid-inner">
                                                    <?php if( $course['intro_video'] ): ?>
                                                        <video class="img-responsive"  >
                                                            <source src="<?=$course['intro_video']?>" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    <?php else: ?>
                                                        <img src="/assets/global/img/default_intro_video.jpg" class="img-responsive">
                                                    <?php endif; ?>

                                                </div>

                                                <p class="font-12px padding-top-10"><?=$course['title']?></p>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <?php if( !$courses ): ?>
                                    <p>No results.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT -->
            </div>
        </div>
    </div>

<?php if( !$is_logged_in ): ?>
    </div>
    </div>
    </div>
<?php endif; ?>