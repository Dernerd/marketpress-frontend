<?php
/*
Plugin Name: Marketpress frontend
Plugin URI: http://corlax.com
Description: get your Marketpress site to frontend support.
Version: 2.5
Author: corlax
Author URI: http://www.corlax.com
License: GPL2
*/

###################################################
####### plugin Code ###############
###################################################


include('lib/ajax-upload.php');

global $custom_field_db_version;
$custom_field_db_version = '1.1'; // version changed from 1.0 to 1.1

function wpmpf_custom_field_install()
{
    global $wpdb;
    global $custom_field_db_version;
    
    $table_name = $wpdb->prefix . 'store_frontend'; // do not forget about tables prefix
    
    // sql to create your table
    // NOTICE that:
    // 1. each field MUST be in separate line
    // 2. There must be two spaces between PRIMARY KEY and its name
    //    Like this: PRIMARY KEY[space][space](id)
    // otherwise dbDelta will not work
    $sql = "CREATE TABLE " . $table_name . " (
      id int(11) NOT NULL AUTO_INCREMENT,
      customfield VARCHAR(200) NOT NULL,
      customlabel VARCHAR(200) NOT NULL,
      customhelp VARCHAR(200) NOT NULL,
	  customrequire VARCHAR(200) NOT NULL,
	  customposition VARCHAR(200) NOT NULL,
	  type VARCHAR(200) NOT NULL,
	  customvalue VARCHAR(200) NOT NULL,
      PRIMARY KEY  (id)
    );";
    
    // we do not execute sql directly
    // we are calling dbDelta which cant migrate database
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
    // save current database version for later use (on upgrade)
    add_option('custom_field_db_version', $custom_field_db_version);
    
    /**
     * [OPTIONAL] Example of updating to 1.1 version
     *
     * If you develop new version of plugin
     * just increment $custom_field_db_version variable
     * and add following block of code
     *
     * must be repeated for each new version
     * in version 1.1 we change email field
     * to contain 200 chars rather 100 in version 1.0
     * and again we are not executing sql
     * we are using dbDelta to migrate table changes
     */
    $installed_ver = get_option('custom_field_db_version');
    if ($installed_ver != $custom_field_db_version) {
        $sql = "CREATE TABLE " . $table_name . " (
          id int(11) NOT NULL AUTO_INCREMENT,
      customfield VARCHAR(200) NOT NULL,
      customlabel VARCHAR(200) NOT NULL,
      customhelp VARCHAR(200) NOT NULL,
	  customrequire VARCHAR(200) NOT NULL,
	  customposition VARCHAR(200) NOT NULL,
	  type VARCHAR(200) NOT NULL,
          PRIMARY KEY  (id)
        );";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        // notice that we are updating option, rather than adding it
        update_option('custom_field_db_version', $custom_field_db_version);
    }
}

register_activation_hook(__FILE__, 'wpmpf_custom_field_install');


/**
 * register_activation_hook implementation
 *
 * [OPTIONAL]
 * additional implementation of register_activation_hook
 * to insert some dummy data
 */


/**
 * Trick to update plugin database, see docs
 */
function wpmpf_custom_field_update_db_check()
{
    global $custom_field_db_version;
    if (get_site_option('custom_field_db_version') != $custom_field_db_version) {
        wpmpf_custom_field_install();
    }
}

add_action('plugins_loaded', 'wpmpf_custom_field_update_db_check');



add_action('admin_menu', 'wpmpf_create_menu');

function wpmpf_create_menu()
{
    // Check that the user is allowed to update options
    
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    
    //create new top-level menu
    
    add_menu_page('WP Store Plugin Settings', 'Store Frontend', 'administrator', 'wp-mp-frontend-post', 'wpmpf_settings_page', plugins_url('/images/icon.png', __FILE__));
    
    //call register settings function
    
    add_action('admin_init', 'register_wpmpf_settings');
    add_action('admin_init', 'register_wpmpf_woosettings');
    add_action('admin_init', 'register_wpmpf_paymentsetting');
    add_action('admin_init', 'register_wpmpf_other_setting');
    add_action('admin_enqueue_scripts', 'wpmpf_custom_admin_css');
}


function register_wpmpf_settings()
{
    //register our settings
    
    register_setting('wpmpf-settings-group', 'posttitle');
    register_setting('wpmpf-settings-group', 'postdiscription');
    register_setting('wpmpf-settings-group', 'postauthor');
    register_setting('wpmpf-settings-group', 'postcategory');
    register_setting('wpmpf-settings-group', 'uploadimage');
    register_setting('wpmpf-settings-group', 'galleryimage');
    register_setting('wpmpf-settings-group', 'posttitleenabledisables');
    register_setting('wpmpf-settings-group', 'postdiscriptionenabledisable');
    register_setting('wpmpf-settings-group', 'postauthorenabledisable');
    register_setting('wpmpf-settings-group', 'postcategoryenabledisable');
    register_setting('wpmpf-settings-group', 'uploadimageenabledisable');
    register_setting('wpmpf-settings-group', 'guestpost');
    register_setting('wpmpf-settings-group', 'successmessage');
    register_setting('wpmpf-settings-group', 'productprice');
    register_setting('wpmpf-settings-group', 'productsaleprice');
    register_setting('wpmpf-settings-group', 'downloadfile');
    register_setting('wpmpf-settings-group', 'productshortdiscription');
    register_setting('wpmpf-settings-group', 'producttags');
    register_setting('wpmpf-settings-group', 'taghelp');
    register_setting('wpmpf-settings-group', 'addnew');
    register_setting('wpmpf-settings-group', 'mypost');
	register_setting('wpmpf-settings-group', 'updatesuccessmessage');
	register_setting('wpmpf-settings-group', 'submitbutton');
	register_setting('wpmpf-settings-group', 'updatebutton');
	register_setting('wpmpf-settings-group', 'uploadfeaturebutton');
	register_setting('wpmpf-settings-group', 'uploadgallerybutton');
	register_setting('wpmpf-settings-group', 'uploaddownloadbutton');
	
    
}

function register_wpmpf_woosettings()
{
    //register our settings
    register_setting('wpmpf-woosettings-group', 'ecommerce');
    register_setting('wpmpf-woosettings-group', 'posttype');
    register_setting('wpmpf-woosettings-group', 'posttaxonomies');
    register_setting('wpmpf-woosettings-group', 'posttags');
    register_setting('wpmpf-woosettings-group', 'autopublish');
    register_setting('wpmpf-woosettings-group', 'posttitleenabledisables');
    register_setting('wpmpf-woosettings-group', 'postdiscriptionenabledisable');
    register_setting('wpmpf-woosettings-group', 'postauthorenabledisable');
    register_setting('wpmpf-woosettings-group', 'postcategoryenabledisable');
    register_setting('wpmpf-woosettings-group', 'uploadimageenabledisable');
    register_setting('wpmpf-woosettings-group', 'uploadgalleyenabledisable');
    register_setting('wpmpf-woosettings-group', 'tagsenabledisable');
    register_setting('wpmpf-woosettings-group', 'expertsenabledisable');
    register_setting('wpmpf-woosettings-group', 'downloadableenabledisable');
    register_setting('wpmpf-woosettings-group', 'titlerequire');
    register_setting('wpmpf-woosettings-group', 'discriptionrequire');
    register_setting('wpmpf-woosettings-group', 'categoryrequire');
    register_setting('wpmpf-woosettings-group', 'featurerequire');
    register_setting('wpmpf-woosettings-group', 'galleryrequire');
    register_setting('wpmpf-woosettings-group', 'tagsrequire');
    register_setting('wpmpf-woosettings-group', 'expertrequire');
    register_setting('wpmpf-woosettings-group', 'downloadablerequire');
    
}

function register_wpmpf_paymentsetting()
{
    register_setting('wpmpf-paymentsetting-group', 'accesslevels');
	register_setting('wpmpf-paymentsetting-group', 'accesslevelserror');
}

function register_wpmpf_other_setting()
{
    register_setting('wpmpf-other-group', 'enablecaptcha');
    register_setting('wpmpf-other-group', 'captchapublickey');
    register_setting('wpmpf-other-group', 'captchaprivatekey');
    register_setting('wpmpf-other-group', 'imagesize');
    register_setting('wpmpf-other-group', 'wpeditordisable');
    register_setting('wpmpf-other-group', 'wpeditorenable');
    register_setting('wpmpf-other-group', 'enablepostlimit');
    register_setting('wpmpf-other-group', 'numberofpost');
    register_setting('wpmpf-other-group', 'errornoofpost');
}



//admin plugin pages

include('lib/custom-filed-functions.php');

function wpmpf_settings_page()
{
    $wpmpf_frontend_post     = isset($_GET['tab']) ? $_GET['tab'] : 'wp-mp-frontend-post';
    $wpmpf_presentation_post = isset($_GET['tab']) ? $_GET['tab'] : 'wpmpf-presentation-setting';
    $wpmpf_payment_post      = isset($_GET['tab']) ? $_GET['tab'] : 'wpmpf-payment-setting';
    $wpmpf_other_post        = isset($_GET['tab']) ? $_GET['tab'] : 'wpmpf-other-setting';
    $wpmpf_custom_post       = isset($_GET['tab']) ? $_GET['tab'] : 'wpmpf-custom-field-setting';
    $wpmpf_help_post         = isset($_GET['tab']) ? $_GET['tab'] : 'wpmpf-help';
    
    if ($wpmpf_frontend_post == 'wp-mp-frontend-post') {
        include('lib/setting.php');
    } elseif ($wpmpf_presentation_post == 'wpmpf-presentation-setting') {
        include('lib/woo-setting.php');
    } elseif ($wpmpf_payment_post == 'wpmpf-payment-setting') {
        include('lib/payment-setting.php');
    } elseif ($wpmpf_other_post == 'wpmpf-other-setting') {
        include('lib/other.php');
    } elseif ($wpmpf_custom_post == 'wpmpf-custom-field-setting') {
        include('lib/custom-field.php');
    } elseif ($wpmpf_help_post == 'wpmpf-help') {
        include('lib/help.php');
    } else {
        include('lib/setting.php');
    }
}



include('lib/wpmpf-functions.php');
 
function wpmpf_script_head()
{

     wp_enqueue_style( 'wp-store-css', plugins_url( 'css/wp-store.css', __FILE__ ));

     wp_enqueue_script('jquery-table-edit-js',  plugins_url( 'js/jquery.dataTables.min.js', __FILE__ ), array(), '1.0.0', false);
    
    wp_enqueue_script('wp-mp-frontend-js',  plugins_url( 'js/wp-mp-frontend.js', __FILE__ ), array(), '1.0.0', false);

}

add_action('wp_enqueue_scripts', 'wpmpf_script_head');

// add styles to admin Edit page

function wpmpf_custom_admin_css()
{
    global $pagenow;
    
    wp_enqueue_style('asp_style_admin',  plugins_url( 'css/admin.css', __FILE__ ), false, 1.0, 'all');
}

// ajax login page code 

function wpmpf_ajax_login_init() {
    global $post;
    if ( is_user_logged_in() ) { } else {
        wp_register_script('ajax-login-script',  plugins_url( 'js/ajax-login-script.js', __FILE__ ), array(
            'jquery'
        ));
        wp_enqueue_script('ajax-login-script');
        wp_localize_script('ajax-login-script', 'ajax_login_object', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'redirecturl' => get_permalink($post->ID), // Replace post_permalink() with get_permalink()
            'loadingmessage' => __('Sending user info, please wait...')
        ));
        
        // Enable the user with no privileges to run ajax_login() in AJAX
        add_action('wp_ajax_nopriv_ajaxlogin', 'wpmpf_ajax_login');
    }
}

// Execute the action only if the user isn't logged in
add_action('init', 'wpmpf_ajax_login_init');

function wpmpf_ajax_login()
{
    
    // First check the nonce, if it fails the function will break
    check_ajax_referer('ajax-login-nonce', 'security');
    
    // Nonce is checked, get the POST data and sign user on
    $info                  = array();
    $info['user_login']    = sanitize_user($_POST['username'], true);
    $info['user_password'] = $_POST['password'];
    $info['remember']      = true;
    
    $user_signon = wp_signon($info, false);
    if (is_wp_error($user_signon)) {
        echo json_encode(array(
            'loggedin' => false,
            'message' => __('Wrong username or password.')
        ));
    } else {
        echo json_encode(array(
            'loggedin' => true,
            'message' => __('Login successful, redirecting...')
        ));
    }
    
    die();
}
?>