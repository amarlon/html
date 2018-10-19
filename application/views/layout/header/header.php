<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head prefix="og: http://ogp.me/ns#">
    <meta charset="utf-8">

    <title><?=$page_title?><?=$this->router->method == 'home' ? '':' | Hotshi' ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta content="<?=$is_french_user ? $GLOBALS['COMPANY_SEARCH_ENGINE_DESCRIPTION']:$GLOBALS['COMPANY_SEARCH_ENGINE_DESCRIPTION']?>" name="description">
    <meta content="Online, course, education" name="keywords">
    <meta content="Hotshi" name="author">

    <meta property="og:site_name" content="Hotshi">
    <meta property="og:title" content="<?=$page_title?><?=$this->router->method == 'home' ? '':' | Hotshi' ?>">
    <meta property="og:description" content="<?=$is_french_user ? $GLOBALS['COMPANY_SEARCH_ENGINE_DESCRIPTION']:$GLOBALS['COMPANY_SEARCH_ENGINE_DESCRIPTION']?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://hotshi.com/assets/frontend/onepage/img/silder/landing-img-3.jpg">
    <meta property="og:url" content="https://www.hotshi.com">
    <meta property="fb:app_id" content="<?php echo $GLOBALS['FB_APP_ID_PUB']; ?>" />

    <link rel="shortcut icon" href="/assets/global/img/favicon.png?v=<?=FILE_VERSION?>">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Pathway+Gothic+One|PT+Sans+Narrow:400+700|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all" rel="stylesheet" type="text/css">

    <!-- Global styles -->
    <link href="/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">

    <?php if( $is_logged_in ): ?>
        <link href="/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">

        <link rel="stylesheet" type="text/css" href="/assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
        <link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/select2.css"/>
        <link rel="stylesheet" type="text/css" href="/assets/global/plugins/jquery-multi-select/css/multi-select.css"/>

        <link href="/assets/global/css/components.css?v=<?=FILE_VERSION?>" id="style_components" rel="stylesheet" type="text/css">
        <link href="/assets/global/css/plugins.css?v=<?=FILE_VERSION?>" rel="stylesheet" type="text/css">
        <link href="/assets/admin/layout3/css/layout.css?v=<?=FILE_VERSION?>" rel="stylesheet" type="text/css">

        <link href="/assets/admin/layout3/css/themes/default.css?v=<?=FILE_VERSION?>" rel="stylesheet" type="text/css" id="style_color">
        <link href="/assets/global/css/bootstrap-tour.min.css" rel="stylesheet" type="text/css">
        <link href="/assets/global/plugins/icheck/skins/all.css?v=<?=FILE_VERSION?>" rel="stylesheet"/>

        <link href="/assets/admin/layout3/css/custom.css?v=<?=FILE_VERSION?>" rel="stylesheet" type="text/css">
    <?php endif; ?>


    <?=isset($page_css) ? $page_css : ''?>

    <link href="/assets/global/css/footer.css?v=<?=FILE_VERSION?>" rel="stylesheet" type="text/css">
    <link href="/assets/global/css/common.css?v=<?=FILE_VERSION?>" rel="stylesheet" type="text/css">

</head>

<?php if( $is_logged_in ): ?>
    <div id="auth_user_email" class="hide"><?=$user['email']?></div>
    <input type="hidden" id="js_stripe_pk" value="<?=$stripe_pk?>">
    <input type="hidden" id="js_ad_charge_per_day" value="<?=$ad_charge_per_day?>">
    <input type="hidden" id="js_create_opportunity_cost" value="<?=CREATE_OPPORTUNITY_COST?>">
    <input type="hidden" id="js_create_project_cost" value="<?=CREATE_PROJECT_COST?>">
    <?php if( is_mobile_device() ): ?>
        <body class="logged-in-body">
    <?php else: ?>
        <body class="page-header-top-fixed logged-in-body">
    <?php endif; ?>
<?php else: ?>
    <body class="menu-always-on-top">
    <style>
        .header .mobi-toggler{
            margin-top: 15px;;
        }
    </style>
<?php endif; ?>
<div id="sb-page-top"></div>

    <input type="hidden" id="fb-app-id" value="<?=$GLOBALS['FB_APP_ID_PUB']?>">

<?php if( $this->router->method != 'inbox' ): ?>

<?php endif; ?>

    <?php if( $is_french_user ): ?>
        <input type="hidden" id="is-french-user">
    <?php endif; ?>

    <?php if( $is_logged_in ): ?>
        <!-- used during stripe payment -->
        <div id="preloader">
            <div class="sk-cube-grid">
                <div class="sk-cube sk-cube1"></div>
                <div class="sk-cube sk-cube2"></div>
                <div class="sk-cube sk-cube3"></div>
                <div class="sk-cube sk-cube4"></div>
                <div class="sk-cube sk-cube5"></div>
                <div class="sk-cube sk-cube6"></div>
                <div class="sk-cube sk-cube7"></div>
                <div class="sk-cube sk-cube8"></div>
                <div class="sk-cube sk-cube9"></div>
            </div>
        </div>

    <input type="hidden" id="js-is-logged-in-input">
    <input type="hidden" id="js-user-android-device-id" value="<?=$user['android_device_id']?>">
    <?php endif; ?>

    <?php if( $is_android_web_view ): ?>
        <input type="hidden" id="is-android-web-view">
    <?php endif; ?>
