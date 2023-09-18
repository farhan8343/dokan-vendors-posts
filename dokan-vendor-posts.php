<?php
/**
  Plugin Name: Dokan Vendor Posts
  Plugin URI:
  Description: An extension to customize Dokan Pro Plugin
  Version: 1.0.0
  Author: Faisal Akram
  Author URI:
 */

/**
 * Dependancies check
 */
$deps           = array( 'woocommerce/woocommerce.php', 'dokan-lite/dokan.php' );
$active_plugins = get_option( 'active_plugins', array() );

// bail if dependancies not found
if( count( array_diff( $deps, $active_plugins ) ) > 0 ) {
    return;
}

/**
 * Plugin file constant
 */
define( 'DPE_PLUGIN_VENDOR_POST', __FILE__ );


// asset includes
include_once dirname( __FILE__ ) . "/includes/assets.php";
add_filter( 'dokan_query_var_filter', 'dokan_load_vendor_posts_menu',100 );
add_filter( 'dokan_get_dashboard_nav', 'dokan_add_vendor_posts_menu',100 );
add_filter( 'dokan_store_tabs', 'dokan_store_vendor_posts_tab',2,100 );
add_action( 'dokan_load_custom_template', 'dokan_vendor_posts_template',100 );
add_action( 'wp_ajax_vendor_save_new_post', 'vendor_save_new_post' );
add_action( 'wp_ajax_nopriv_vendor_save_new_post', 'vendor_save_new_post' );
add_action( 'wp_ajax_vendor_update_post', 'vendor_update_post' );
add_action( 'wp_ajax_nopriv_vendor_update_post', 'vendor_update_post' );
add_action( 'wp_ajax_vendor_delete_post', 'vendor_delete_post' );
add_action( 'wp_ajax_nopriv_vendor_delete_post', 'vendor_delete_post' );

/**
 * Sub admin menu page for Vendor Shipping Query Var
 */
function dokan_load_vendor_posts_menu( $query_vars ) { 
    $query_vars['vendor-posts'] = 'vendor-posts'; 
    $query_vars['new-post'] = 'new-post';
	$query_vars['edit-post'] = 'edit-post';
    return $query_vars;
}


/**
 * Sub admin menu page in Vendor Dashboard for Shipping Settings.
 */
function dokan_add_vendor_posts_menu( $urls ) {
    $urls['vendor-posts'] = array(
        'title' => __( 'Press Release', 'dokan'),
        'icon'  => '<i class="fa fa-file-alt"></i>',
        'url'   => dokan_get_navigation_url( 'vendor-posts' ),
        'pos'   => 1000,
		'permission' => 'dokan_view_product_menu'
    );

    return $urls;
}

/**
 * Loading content of the shipping tab.
 */
function dokan_vendor_posts_template( $query_vars ) { 
    if ( isset( $query_vars['vendor-posts'] ) ) {	
		include('includes/vendor-posts.php');
	}
    if ( isset( $query_vars['new-post'] ) ) {	
		include('includes/new-post.php');
	}
	if ( isset( $query_vars['edit-post'] ) ) {	
		include('includes/edit-post.php');
	}
}


/*
* Saving New Post
*/
function vendor_save_new_post(){
   $args = array(
    'post_type'         =>  'post',
    'post_status'       =>  'publish',
    'post_title'        =>  $_POST['data']['title'],
    'post_content'      =>  $_POST['data']['description'],
    'post_excerpt'      =>  $_POST['data']['short_description'],
    'post_author'       =>  get_current_user_id(  )
   );
   $post_id = wp_insert_post($args);
   wp_set_post_terms($post_id, $_POST['data']['tags'], 'post_tag');
   wp_set_post_terms($post_id, $_POST['data']['categories'], 'category');
   set_post_thumbnail( $post_id, $_POST['data']['thumbnail'] );
   wp_send_json_success( array('message' => 'Post Added Successfully') );
}


/*
* Updating New Post
*/
function vendor_update_post(){
   $args = array(
    'ID'         		=>  $_POST['data']['id'],
    'post_title'        =>  $_POST['data']['title'],
    'post_content'      =>  $_POST['data']['description'],
    'post_excerpt'      =>  $_POST['data']['short_description']
   );
	wp_update_post($args);
   $post_id = $_POST['data']['id'];
   wp_set_post_terms($post_id, $_POST['data']['tags'], 'post_tag');
   wp_set_post_terms($post_id, $_POST['data']['categories'], 'category');
   set_post_thumbnail( $post_id, $_POST['data']['thumbnail'] );
   wp_send_json_success( array('message' => 'Post Added Successfully') );
}

/*
 * Deleting Post
 */
function vendor_delete_post(){ 
	wp_delete_post( $_POST['id'],true);
	wp_send_json_success( array('message' => 'Post Deleted Successfully') );
}


/*
 * Vendor Posts Store Tab
 */
function dokan_store_vendor_posts_tab($tabs, $store_id){ 
	$tabs['press-release']= array(
		'title' => __( 'Press Release', 'dokan-lite' ),
        'url'   => dokan_get_store_url( $store_id ).'press-release',
	);
	return $tabs;
}


// Query Vars
 add_filter( 'query_vars', function($vars){
	 $vars[] = 'press-release';
	 return $vars;
 },1,200 );

add_action( 'dokan_rewrite_rules_loaded', function($custom_store_url){
	
	add_rewrite_rule( $custom_store_url . '/([^/]+)/press-release?$', 'index.php?' . $custom_store_url . '=$matches[1]&press-release=true', 'top' );
},100 );


add_filter( 'template_include', 'store_press_release_template', 99 );
function store_press_release_template( $template ) {
       
	if ( get_query_var( 'press-release' ) ) {

			include('includes/press-release.php');

	}

	return $template;
}