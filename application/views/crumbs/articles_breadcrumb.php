<div class="caption search-results-caption">
    <span class="caption-subject text"><?=$crumb_title?></span>
    <div class="margin-top-20"></div>
    <?php if(isset($article)): ?>
        <p class="font-12px" style="padding-left:5px;"><a href="/page/profile/<?=$article['user_id']?>"><img src="<?=$article['poster_image']?>" style="width:20px;"><span style="padding-left:10px;"><?=$article['poster_name']?></span></a></p>
    <?php endif; ?>
</div>

<div class="actions <?=isset($hide_buttons) ? $hide_buttons : '' ?>">
    <?php if( $is_logged_in ): ?>
        <a href="/account/create_article" class="btn btn-sm btn-primary btn-large uppercase"><i class="fa fa-plus"></i> <?=$is_french_user ? 'CRÉER UN NOUVEL ARTICLE':'Create new article' ?></a>
    <?php endif; ?>
    <?php if( isset($article) && $article['user_id'] == $this->session->userdata('id') ): ?>
        <a href="/account/edit_article/<?=$article['id']?>" class="btn btn-sm btn-default btn-large uppercase"><i class="icon-pencil"></i> Edit</a>
        <a href="javascript:" class="btn btn-sm btn-default btn-large uppercase js-delete-article-button" data-article-id="<?=$article['id']?>"><i class="icon-trash"></i> Delete</a>
    <?php endif; ?>
</div>