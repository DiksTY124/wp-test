<?php
/**
 * Plugin Name: Doctors CPT
 * Description: Register "Doctors" custom post type (doctors).
 * Version: 1.0
 * Author: Your Name
 * Text Domain: doctors
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Doctors_Plugin {

    const POST_TYPE = 'doctors';
    const TEXT_DOMAIN = 'doctors';

    public function __construct() {
        // i18n
        add_action( 'init', [ $this, 'load_textdomain' ] );
        // register CPT on init
        add_action( 'init', [ $this, 'register_post_type' ] );
    }

    public function load_textdomain() {
        load_plugin_textdomain( self::TEXT_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    public function register_post_type() {
        $labels = [
            'name'                  => __( 'Doctors', self::TEXT_DOMAIN ),
            'singular_name'         => __( 'Doctor', self::TEXT_DOMAIN ),
            'menu_name'             => __( 'Doctors', self::TEXT_DOMAIN ),
            'name_admin_bar'        => __( 'Doctor', self::TEXT_DOMAIN ),
            'add_new'               => __( 'Add New', self::TEXT_DOMAIN ),
            'add_new_item'          => __( 'Add New Doctor', self::TEXT_DOMAIN ),
            'new_item'              => __( 'New Doctor', self::TEXT_DOMAIN ),
            'edit_item'             => __( 'Edit Doctor', self::TEXT_DOMAIN ),
            'view_item'             => __( 'View Doctor', self::TEXT_DOMAIN ),
            'all_items'             => __( 'All Doctors', self::TEXT_DOMAIN ),
            'search_items'          => __( 'Search Doctors', self::TEXT_DOMAIN ),
            'not_found'             => __( 'No doctors found.', self::TEXT_DOMAIN ),
            'not_found_in_trash'    => __( 'No doctors found in Trash.', self::TEXT_DOMAIN ),
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'rewrite'            => [ 'slug' => 'doctors', 'with_front' => false ],
            'supports'           => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
            'menu_icon'          => 'dashicons-id',
            'show_in_rest'       => true,
        ];

        register_post_type( self::POST_TYPE, $args );
    }

    /**
     * Activation: ensure CPT registered and flush rewrite rules.
     */
    public static function activate() {
        $plugin = new self();
        $plugin->register_post_type();
        flush_rewrite_rules();
    }

    /**
     * Deactivation: flush rewrite rules to clean up.
     */
    public static function deactivate() {
        flush_rewrite_rules();
    }
}

/**
 * Bootstrap
 */
function doctors_plugin_init() {
    // instantiate plugin (stores hooks)
    $GLOBALS['doctors_plugin'] = new Doctors_Plugin();
}
add_action( 'plugins_loaded', 'doctors_plugin_init' );

/**
 * Activation / Deactivation hooks
 */
register_activation_hook( __FILE__, [ 'Doctors_Plugin', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'Doctors_Plugin', 'deactivate' ] );
