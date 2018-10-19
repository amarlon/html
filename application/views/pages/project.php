<?php if( !$is_logged_in ): ?>
    <div class="page-container">
    <div class="page-content">
    <div class="container view-container">
<?php endif; ?>

<?php if( !$opportunity['is_active'] ): ?>
    <div class="alert alert-danger col-md-12">
        <button class="close" data-close="alert"></button>
        <i class="fa-lg fa fa-exclamation-triangle"></i>
        <span>Pending activation</span>
    </div>
<?php endif; ?>

    <input type="hidden" id="js-project-interest-popup-text" value="<?=$is_french_user ? 'Le créateur de ce projet sera informé que vous êtes intéressé(e) par son projet.<br><br> Continuer?':'The creator of this project will be notified that you are interested in thier project. <br><br>Continue?' ?>">
    <input type="hidden" id="js-project-interest-btn-yes" value="<?=$is_french_user ? 'Oui':'Yes' ?>">
    <input type="hidden" id="js-project-interest-btn-no" value="<?=$is_french_user ? 'Annuler':'Cancel' ?>">

    <div class="portlet light" <?=$is_logged_in ? 'style="background:none;"' : 'style="margin-top:110px;background:none;"'  ?>>
        <div class="portlet-title">
            <div class="caption search-results-caption">
                <span class="caption-subject text"><?=$opportunity_title?></span>
                <div class="margin-top-20"></div>
                <p class="font-12px" style="padding-left:5px;"><a href="/page/profile/<?=$opportunity['user_id']?>"><img src="<?=$opportunity['poster_image']?>" style="width:20px;"><span style="padding-left:10px;"><?=$opportunity['poster_name']?></span></a></p>
            </div>

            <?php if( $is_logged_in ): ?>
                <div class="actions">
                    <?php if($user['is_hotshi_admin']): ?>
                        <?php if( $opportunity['is_active'] ): ?>
                            <a class="btn btn-large btn-danger uppercase js-deactivate-project-btn" href="javascript:" data-opportunity-id="<?=$opportunity['id']?>"><i class="fa fa-times"></i> De-activate</a>
                        <?php else: ?>
                            <a class="btn btn-large btn-success uppercase js-activate-project-btn" href="javascript:" data-opportunity-id="<?=$opportunity['id']?>"><i class="fa fa-check"></i> Activate</a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if( $opportunity['user_id'] == $this->session->userdata('id') ): ?>
                        <a href="/account/edit_project/<?=$opportunity['id']?>" class="btn btn-primary btn-large uppercase"><i class="icon-pencil"></i> Edit</a>
                        <a href="javascript:" class="btn btn-default btn-large uppercase js-delete-project-btn" data-opportunity-id="<?=$opportunity['id']?>"><i class="icon-trash"></i> Delete</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12 blog-page">
                    <div class="row">
                        <div class="col-md-9 article-block">
                            <?php if( $opportunity['image'] ): ?>
                                <div class="blog-tag-data">
                                    <img src="<?=$opportunity['image']?>" class="img-responsive" alt="">
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <p style="padding-left:15px;" class="font-12px padding-bottom-20"><i class="fa fa-clock-o"></i> <i>Created <?=time_elapsed_string(strtotime($opportunity['date_created']))?> ago</i></p>
                            </div>

                            <div>
                                <p><?=$opportunity['description']?></p>
                                <br>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="bold"><?=$is_french_user ? 'Localisation:':'Location:' ?> <span style="font-weight:normal;font-size:14px;"><?=$opportunity['location']?></span></h5>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="bold"><?=$is_french_user ? 'Besoin de?':'Seeking:' ?> <span style="font-weight:normal;font-size:14px;"><?=$opportunity['qualifications']?></span></h5>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="bold"><?=$is_french_user ? 'Compétences:':'Skills:' ?></h5>
                                    <?php
                                    if( $opportunity['skills'] ) {
                                        $tags = explode(',', $opportunity['skills']);
                                        foreach( $tags as $tag ) {
                                            echo '<a href="javascript:" class="btn bs-btn-tags cursor-default">'.$tag.'</a>';
                                        }
                                    } else{
                                        echo '---';
                                    }
                                    ?>
                                </div>
                            </div>

                            <?php if( $is_logged_in ): ?>
                                <br>
                                <hr>
                                <?php if( $opportunity['is_active'] && $opportunity['user_id'] != $this->session->userdata('id') ): ?>
                                    <a class="btn btn-large-2 btn-success uppercase js-apply-for-project-btn" href="javascript:" data-opportunity-id="<?=$opportunity['id']?>"><i class="fa fa-check"></i> <?=$is_french_user ? 'JE SUIS INTÉRESSÉ(E)':'I AM INTERESTED' ?></a>
                                <?php endif; ?>
                            <?php else: ?>
                                <br>
                                <hr>
                                <a class="btn btn-large-2 btn-success uppercase" href="/page/login" data-opportunity-id="<?=$opportunity['id']?>"><i class="fa fa-check"></i> <?=$is_french_user ? 'JE SUIS INTÉRESSÉ(E)':'I AM INTERESTED' ?></a>
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