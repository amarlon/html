<?php
/**
 * Created by PhpStorm.
 * User: Dev Hotshi
 * Date: 29/10/15
 * Time: 1:18 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//////////////////////////////////////////////////////////////
// MUST BE ADDED TO GITIGNORE                              //
////////////////////////////////////////////////////////////

define('IS_LIVE_SERVER', gethostbyname(gethostname()) == '172.31.20.68');

$GLOBALS['SERVER'] = 'dev'; // ** do not change **

/* EMAILS SERVER CONFIG */
$GLOBALS['SEND_EMAILS_LOCALLY'] = 0; //enable emails in local dev
$GLOBALS['DEV_EMAIL'] = 'admin@hotshi.com'; //all dev emails are sent here (change to your email)
$GLOBALS['SMTP_SERVER'] = 'lh58.dnsireland.com';
$GLOBALS['SMTP_USER'] = 'services@hotshi.com';
$GLOBALS['EMAIL_PASS'] = 'L*gichotshi';
$GLOBALS['FROM_ADDRESS'] = 'no-reply@hotshi.com'; //common for all
$GLOBALS['FROM_NAME'] = 'Hotshi'; //common for all
$GLOBALS['ADMIN_NAME'] = 'Admin'; //name in admin emails

//EMAIL SES CONFIG
define('DEV_EMAIL','benshittu2@gmail.com');
define('SE_U','AKIAJFWOJWE27S7ZVLXA'); //username
define('SE_P','Avkv2ltoIY6T0U3xij7UXxMBL1W8mLMnxftDqd2pqq7o'); //pass
define('SE_HO', 'email-smtp.eu-west-1.amazonaws.com'); //server name / host
define('SE_PO', '587'); //port
define('SE_EM', 'no-reply@hotshi.com');
$GLOBALS['ADMIN_E'] = array(
    'benshittu2@gmail.com'
);


define('FILE_VERSION', 1111115); //browser caching work-around
define('AD_CHARGE_PER_DAY', 0.50);

define('COMPANY_NAME', 'hotshi');
$GLOBALS['COMPANY_NAME'] = 'hotshi'; //do not change ***
$GLOBALS['COMPANY_URL'] = 'hotshi.com'; //do not change ***
$GLOBALS['COMPANY_SEARCH_ENGINE_DESCRIPTION'] = 'Hotshi is a professional networking website. We connect users and companies to career, employment and scholarship opportunities.';
$GLOBALS['COMPANY_SEARCH_ENGINE_DESCRIPTION_FR'] = 'Hotshi est un site de réseau social professionnel. Nous connectons les utilisateurs et les entreprises aux opportunités de carrière, d’emploi et de bourses.';

$GLOBALS['MASTER_P'] = 'j17p3BlMbuW3qJlCXIixByS7puus7gr9';

define('MAX_PROFILE_IMG_HEIGHT', 400);
define('MAX_POST_IMG_HEIGHT', 400);
define('MAX_GALLERY_IMG_HEIGHT', 600);
define('MAX_INBOX_IMG_HEIGHT', 400);

define('MIN_STR_LEN_SEARCH', 2);
define('CERT_COST_MIN', 5);
define('CERT_COST_MAX', 500);

define('CREATE_OPPORTUNITY_COST', 12);
define('CREATE_OPPORTUNITY_MAX_DAYS', 30);

define('CREATE_PROJECT_COST', 12);
define('CREATE_PROJECT_MAX_DAYS', 30);

define('TOOLTIP_CHAR_UPDATE', 'G');
define('TOOLTIP_CHAR_JOBS', 'J');
define('TOOLTIP_CHAR_ARTICLE', 'A');
define('TOOLTIP_CHAR_EVENT', 'E');
define('TOOLTIP_CHAR_FORUM', 'F');

define('TOOLTIP_COLOR_UPDATE', '#4b8df8');
define('TOOLTIP_COLOR_JOBS', '#f3565d');
define('TOOLTIP_COLOR_ARTICLE', '#8e44ad');
define('TOOLTIP_COLOR_EVENT', '#35aa47');
define('TOOLTIP_COLOR_FORUM', '#67809f');

define('TOOLTIP_UPDATE', 'General updates');
define('TOOLTIP_JOBS', 'Jobs post');
define('TOOLTIP_ARTICLE', 'Article');
define('TOOLTIP_EVENT', 'Event');
define('TOOLTIP_FORUM', 'Forum post');

define('SESSION_EXP_MSG', 'Oops! Seems you\'ve been logged out. Please refresh your browser and log back in.');
define('ACC_DISABLED_MSG', 'Your account has been deactivated. Please contact <a href="mailto:help@hotshi.com?Subject=Hello" target="_top">help@hotshi.com</a>.');
define('EMAIL_UNVERIFIED_MSG', 'Your haven\'t confirmed your email address. You can go to your account settings and click - Verify my email - to request a new verification email. ');
define('PERMISSION_ERR_MSG', 'Access denied. Please check with your page admin that you have proper permissions.');

define('GOOGLE_ANDROID_ACCESS_KEY','AAAA9HqyXm8:APA91bGRVOEDPPcNYB5AaZ7rV95FoREWjQ0EGCVcY7aJowRFWrMMrJ30yirIjOxYTUBnqi3lDwK8RwBJJW04SATCnX-KATebb8dnui_gwmGKnS58vm1Ae6Bgmy5Ep4WbfYh0Uf05324I');

$GLOBALS['FB_APP_ID_PUB'] = '187126385314480';
$GLOBALS['FB_APP_ID_SEC'] = '51d94b829336c03b8d7ebb12b1ca9028';

$GLOBALS['FACEBOOK_URL'] = '';
$GLOBALS['TWITTER_URL'] = '';
$GLOBALS['YOUTUBE_URL'] = '';
$GLOBALS['LINKEDIN_URL'] = '';

if( $_SERVER['HTTP_HOST'] == $GLOBALS['COMPANY_URL'] ) {
    $GLOBALS['SERVER'] = 'live'; //do not change
}

if( IS_LIVE_SERVER ) {
    define('STRIPE_PK', 'pk_live_bQADWM5VkRpESCbJkBO9L8sH');
    define('STRIPE_SK', 'sk_live_LDVnYifcJtUuAvZa7VqGjnw2');
    define('WECASHUP_UID', 'MrH0chKgffOcY03qKv1tsS2R4rF3');
    define('WECASHUP_PK', '');
    define('WECASHUP_SK', '');
    $GLOBALS['FB_APP_ID_PUB'] = '697994087256048';
    $GLOBALS['FB_APP_ID_SEC'] = 'd4442495cb0ee39991d8cfb73d236bd5';
} else {
    define('STRIPE_PK', 'pk_test_Ym2P3vos70v4Q2A5sIsMAXfi');
    define('STRIPE_SK', 'sk_test_9ltC7ye35g68ymCDaxJSIizp');
    define('WECASHUP_UID', 'MrH0chKgffOcY03qKv1tsS2R4rF3');
    define('WECASHUP_PK', 'SO6xrWHV5CbrmnG4XtIRFp8NCBdYaiEUaFmtMm1OSkGZ');
    define('WECASHUP_SK', 'BxsJc3pbd0LYKEZC');
    $GLOBALS['FB_APP_ID_PUB'] = '924627041033324';
    $GLOBALS['FB_APP_ID_SEC'] = '844085498939e1e953ef947211e34fa8';
}
