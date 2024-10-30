<?php
/**
* Plugin Name: Extra Custom Product Tabs for WooCommerce
* Description: Extra product tabs manager for WooCommerce to add and manage custom product tabs. Create multiple product tabs as needed per product.
*  Author: Codevyne Creatives
*  Author URI: https://www.codevyne.com/contact-us/
* Donate link: https://www.paypal.com/paypalme/pradeepku041/
* Contributors: Pradeep Maurya
* Tested up to: 5.8
* Stable tag: 1.2
* Version: 1.2
* Text Domain: custom-product-tabs-for-woocommerce
* Copyright: (c) 2021-2022 Codevyne Creatives PVT LTD.
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
  die('-1');
}

if (!defined('WPCCPT_PLUGIN_NAME')) {
  define('WPCCPT_PLUGIN_NAME', 'Extra Custom Product Tabs for WooCommerce');
}
if (!defined('WPCCPT_PLUGIN_VERSION')) {
  define('WPCCPT_PLUGIN_VERSION', '1.2');
}
if (!defined('WPCCPT_PLUGIN_FILE')) {
  define('WPCCPT_PLUGIN_FILE', __FILE__);
}
if (!defined('WPCCPT_PLUGIN_DIR')) {
  define('WPCCPT_PLUGIN_DIR',plugins_url('', __FILE__));
}
if (!defined('WPCCPT_BASE_NAME')) {
    define('WPCCPT_BASE_NAME', plugin_basename(WPCCPT_PLUGIN_FILE));
}
if (!defined('WPCCPT_DOMAIN')) {
  define('WPCCPT_DOMAIN', 'WPCCPT');
}


if (!class_exists('WPCCPT')) {

    class WPCCPT {

        protected static $WPCCPT_instance;
        function __construct() {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            add_action('admin_init', array($this, 'WPCCPT_check_plugin_state'));
        }


        function WPCCPT_check_plugin_state(){
            if ( ! ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) ) {
                set_transient( get_current_user_id() . 'wqrerror', 'message' );
            }
        }


        function init() {
           add_action( 'admin_notices', array($this, 'WPCCPT_show_notice'));
           add_action( 'admin_enqueue_scripts', array($this, 'WPCCPT_load_admin'));
           add_action( 'wp_enqueue_scripts',  array($this, 'WPCCPT_load_front'));
           add_filter( 'plugin_row_meta', array( $this, 'WPCCPT_plugin_row_meta' ), 10, 2 );
        }


        function WPCCPT_show_notice() {
            if ( get_transient( get_current_user_id() . 'wqrerror' ) ) {

                deactivate_plugins( plugin_basename( __FILE__ ) );
                delete_transient( get_current_user_id() . 'wqrerror' );
                echo '<div class="error"><p> This plugin is deactivated because it require <a href="plugin-install.php?tab=search&s=woocommerce">WooCommerce</a> plugin installed and activated.</p></div>';
            }
        }


       	
        function WPCCPT_plugin_row_meta( $links, $file ) {
            if ( WPCCPT_BASE_NAME === $file ) {
                $row_meta = array(
                    'rating'    =>  ' <a href="https://www.codevyne.com/contact-us/?utm_source=aj_plugin&utm_medium=plugin_support&utm_campaign=aj_support&utm_content=aj_wordpress" target="_blank">Support</a>',
                );
                return array_merge( $links, $row_meta );
            }
            return (array) $links;
        }


        function WPCCPT_load_admin() {
            wp_enqueue_style( 'WPCCPT_admin_style', WPCCPT_PLUGIN_DIR . '/assests/css/wpcc_back_style.css', false, '1.0.0' );
          wp_enqueue_script( 'WPCCPT_admin_script', WPCCPT_PLUGIN_DIR . '/assests/js/wpcc_back_script.js', array( 'jquery' ), '1.0.0', false);
        }


        function WPCCPT_load_front() {
          
         $translation_array = array('plugin_url'=>WPCCPT_PLUGIN_DIR);
         wp_localize_script( 'WPCCPT_front_script', 'wpcc_plugin_url', $translation_array );
           
        }

        function includes() {
     include_once('include/admin_hook.php');
  include_once('public/wpcc_front_display.php');
        }


        public static function WPCCPT_instance() {
            if (!isset(self::$WPCCPT_instance)) {
                self::$WPCCPT_instance = new self();
                self::$WPCCPT_instance->init();
                self::$WPCCPT_instance->includes();
            }
            return self::$WPCCPT_instance;
        }

    }

    add_action('plugins_loaded', array('WPCCPT', 'WPCCPT_instance'));
}