<?php
/**
 * Assets handler
 */

 defined( 'ABSPATH' ) || exit;

 add_action('wp_enqueue_scripts','fa_vendor_posts_scripts');


function fa_vendor_posts_scripts(){
    wp_enqueue_style( 'fa-vendor-post', plugins_url( '/assets/css/style.css', DPE_PLUGIN_VENDOR_POST ), [ 'dokan-style' ] );
    wp_enqueue_script('jquery');
    wp_enqueue_style('jquery-ui');
    wp_enqueue_style('fontawesome','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
     wp_enqueue_script('fa-vendor-post-custom-js', plugins_url( '/assets/js/custom.js', DPE_PLUGIN_VENDOR_POST ), array('jquery','jquery-ui-datepicker'), true  );
     wp_localize_script( 'fa-vendor-post-custom-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    // wp_enqueue_script('full-calender-scheduler-css',  'https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.css', [ 'dokan-style' ]  );
    // wp_enqueue_script('full-calender-css',  'https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.5.0/main.min.css', [ 'dokan-style' ]  );
    // wp_enqueue_script('full-calender',  'https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js', array(), true  );
    // wp_enqueue_script('full-calender-scheduler',  'https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.5.0/main.min.js', array(), true  );
    // wp_enqueue_script('fa-main-js', plugins_url( '/assets/js/custom.js', DPE_PLUGIN ), array( 'jquery' ), true  );
}
