<?php

//Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit();

/**
* Define Premium_Blocks_Integration class
*/
class Premium_Blocks_Integration {
    
    private static $instance = null;

    public static $blocks;

    public static $config;
    
    /**
    * Constructor for the class
    */
    public function __construct() {

        //Gets Active Blocks
        self::$blocks = Premium_Guten_Admin::get_enabled_keys();
        
        //Gets Plugin Admin Settings
        self::$config = Premium_Guten_Maps::get_enabled_keys();
        
        //Enqueue Editor Assets
        add_action( 'enqueue_block_editor_assets', array( $this, 'premium_gutenberg_editor' ) );
        
        //Enqueue Frontend Styles
        add_action( 'enqueue_block_assets', array( $this, 'premium_gutenberg_frontend' ) );
                
        //Register Premium Blocks category
        add_filter( 'block_categories', array( $this, 'register_premium_category' ), 10, 1 );

    }
    
    /**
    * Enqueue Editor CSS/JS for Premium Blocks
    * @since 1.0.0
    * @access public
    * @return void
    */
    public function premium_gutenberg_editor() {

        $is_fa_enabled = isset( self::$config['premium-fa-css'] ) ? self::$config['premium-fa-css'] : true;
        
        wp_enqueue_script(
            'pbg-editor',
            PREMIUM_BLOCKS_URL . 'assets/js/build.js', 
            array( 'wp-blocks',
                'wp-i18n',
                'wp-element',
                'wp-components',
                'wp-data', 
                'wp-editor'
            ),
            PREMIUM_BLOCKS_VERSION
        );
        
    
        wp_enqueue_style(
            'pbg-editor-css',
            PREMIUM_BLOCKS_URL . 'assets/css/blockseditor.css',
            array( 'wp-edit-blocks' ),
            PREMIUM_BLOCKS_VERSION
        );
        
        wp_enqueue_style(
            'pbg-editor-panel-css',
            PREMIUM_BLOCKS_URL . 'assets/css/editorpanel.css',
            array( 'wp-edit-blocks' ),
            PREMIUM_BLOCKS_VERSION
        );
        
        wp_localize_script(
            'pbg-editor',
            'PremiumBlocksSettings',
            array(
				'defaultAuthImg'    => PREMIUM_BLOCKS_URL . 'assets/img/author.jpg',
                'activeBlocks'      => self::$blocks
			)
        );

        wp_localize_script(
            'pbg-editor',
            'FontAwesomeConfig',
            array(
                'FontAwesomeEnabled'    => $is_fa_enabled,
            )
        );
    }
    
    /**
    * Enqueue Frontend CSS for Premium Blocks
    * @since 1.0.0
    * @access public
    * @return void
    */
    public function premium_gutenberg_frontend() {
       
        $is_fa_enabled = isset( self::$config['premium-fa-css'] ) ? self::$config['premium-fa-css'] : true;

        $is_enabled = isset( self::$config['premium-map-api'] ) ? self::$config['premium-map-api'] : true;
        
        $api_key = isset( self::$config['premium-map-key'] ) ? self::$config['premium-map-key'] : '';
        
        $is_maps_enabled = self::$blocks['maps'];

        $is_counter_enabled = self::$blocks['countUp'];
        
        $is_banner_enabled = self::$blocks['banner'];
        
        $is_button_enabled = self::$blocks['button'];
        
        $is_accordion_enabled = self::$blocks['accordion'];
        
        $is_section_enabled = self::$blocks['container'];

        $is_video_enabled = self::$blocks['videoBox'];
        
        $is_dual_enabled = self::$blocks['dualHeading'];
        
        $is_icon_box_enabled = self::$blocks['iconBox'];
        
        wp_enqueue_style(
            'pbg-frontend',
            PREMIUM_BLOCKS_URL . 'assets/css/style.css',
            array('dashicons'),
            PREMIUM_BLOCKS_VERSION
        );
        
        if( $is_fa_enabled ) {
            wp_enqueue_style(
                'pbg-fontawesome',
                'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
            );
        }
        
        if( $is_banner_enabled ) {
            wp_enqueue_script(
                'banner-js',
                PREMIUM_BLOCKS_URL . 'assets/js/banner.js',
                array('jquery'),
                PREMIUM_BLOCKS_VERSION
            );
        }
        
        if( $is_button_enabled ) {
            wp_enqueue_script(
                'button-js',
                PREMIUM_BLOCKS_URL . 'assets/js/button.js',
                array('jquery'),
                PREMIUM_BLOCKS_VERSION
            );
        }
        
        if( $is_dual_enabled ) {
            wp_enqueue_script(
                'dual-heading-js',
                PREMIUM_BLOCKS_URL . 'assets/js/dual-heading.js',
                array('jquery'),
                PREMIUM_BLOCKS_VERSION
            );
        }
        
        if( $is_counter_enabled ) {
            wp_enqueue_script(
                'waypoints_lib',
                PREMIUM_BLOCKS_URL . 'assets/js/lib/jquery.waypoints.js',
                array('jquery'),
                PREMIUM_BLOCKS_VERSION
            );
            
            wp_enqueue_script(
                'counter_lib',
                PREMIUM_BLOCKS_URL . 'assets/js/lib/countUpmin.js',
                array('jquery'),
                PREMIUM_BLOCKS_VERSION
            );
            
            wp_enqueue_script(
                'countup-js',
                PREMIUM_BLOCKS_URL . 'assets/js/countup.js',
                array('jquery'),
                PREMIUM_BLOCKS_VERSION
            );
        }
        
        if( $is_accordion_enabled ) {
            wp_enqueue_script(
                'accordion-js',
                PREMIUM_BLOCKS_URL . 'assets/js/accordion.js',
                array('jquery'),
                PREMIUM_BLOCKS_VERSION
            );
        }
        
        if( $is_section_enabled ) {
            wp_enqueue_script(
                'section-js',
                PREMIUM_BLOCKS_URL . 'assets/js/section.js',
                array('jquery'),
                PREMIUM_BLOCKS_VERSION
            );
            
            $is_rtl = is_rtl() ? true : false;
            
            wp_localize_script(
                'section-js',
                'siteDirection',
                array(
                    'isRTL'    => $is_rtl,
                )
            );
        }
        
        if( $is_video_enabled ) {
            wp_enqueue_script(
                'video-box-js',
                PREMIUM_BLOCKS_URL . 'assets/js/video-box.js',
                array('jquery'),
                PREMIUM_BLOCKS_VERSION
            );
        }
        
        if( $is_icon_box_enabled ) {
            wp_enqueue_script(
                'icon-box-js',
                PREMIUM_BLOCKS_URL . 'assets/js/icon-box.js',
                array('jquery'),
                PREMIUM_BLOCKS_VERSION
            );
        }

        //Enqueue Google Maps API Script
        if( $is_maps_enabled && $is_enabled ) {
            if( ! empty( $api_key ) && '1' != $api_key ) {
                wp_enqueue_script(
                    'premium-map-block',
                    'https://maps.googleapis.com/maps/api/js?key=' . $api_key
                );
            }
        }
        
    }
    
    /**
    * Add Premium Blocks category to Blocks Categories
    * @since 1.0.0
    * @access public
    * @return void
    */
    public function register_premium_category( $categories ) {
        
        return array_merge(
            $categories,
            array(
                array(
                    'slug'  => 'premium-blocks',
                    'title' => __('Premium Blocks', 'premium-blocks-for-gutenberg')
                )
            )
        );
        
    }


    /**
    * Creates and returns an instance of the class
    * @since 1.0.0
    * @access public
    * return object
    */
    public static function get_instance() {
        if( self::$instance == null ) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}
    

if ( ! function_exists( 'premium_blocks_integration' ) ) {

	/**
	 * Returns an instance of the plugin class.
	 * @since  1.0.0
	 * @return object
	 */
	function premium_blocks_integration() {
		return Premium_Blocks_Integration::get_instance();
	}
}
premium_blocks_integration();