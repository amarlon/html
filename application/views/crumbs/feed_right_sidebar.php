<div class="col-md-3 bs-feed-s-right" style="padding:0;">

    <div class="portlet light feed-sticky-right-portlet">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject bs-feed-title bold"><i class="icon-users"></i> <?=$is_french_user ? 'Nouveaux membres':'New members' ?></span>
            </div>
            <div class="tools">
                <a href="javascript:;" class="reload" data-original-title="" title="">
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <?php foreach( $new_users as $new_user ): ?>
                <?php if( $new_user['id'] != $this->session->userdata('id') ): ?>
                    <a href="/page/profile/<?=$new_user['id']?>"><img src="<?=$new_user['image']?>" class="bs-new-users-img tooltips" data-placement="top" data-original-title="<?=$new_user['fullname']?>"></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if(true): ?>
        <div class="portlet light ad feed-sticky-right-portlet">
            <div class="portlet-body">
                <a href="/account/ads"><img src="/assets/global/img/add-img-default.jpg" class="img-responsive"></a>
            </div>
        </div>
    <?php endif; ?>

    <?php foreach( $ads as $ad ): ?>
        <div class="portlet light ad feed-sticky-right-portlet">
            <div class="portlet-body">
               <a href="<?=$ad['link']?>" target="_blank" title="<?=strip_tags($ad['description'])?>"><img src="<?=$ad['image']?>" class="img-responsive" alt="<?=strip_tags($ad['description'])?>"></a>
            </div>
        </div>
    <?php endforeach; ?>





</div>