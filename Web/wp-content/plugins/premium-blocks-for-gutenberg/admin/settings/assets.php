<?php

//Exit if accessed directly
if( ! defined('ABSPATH') ) exit;

// Define class 'Premium_Guten_Maps' if not Exists
if( ! class_exists('Premium_Guten_Maps') ) {
    
    /**
    * Define Premium_Guten_Maps class
    */
    class Premium_Guten_Maps {

        private static $instance = null;

        public static $pb_maps_keys = [ 'premium-map-key', 'premium-map-api', 'premium-fa-css' ];

        private $pb_maps_default;

        private $pb_maps_settings;

        private $pb_maps_get;

        /**
		 * Constructor for the class
		 */
        public function __construct() {

            add_action( 'admin_menu', array ( $this,'premium_gutenberg_maps' ), 100 );

            add_action( 'wp_ajax_pb_maps', array( $this, 'pb_save_maps_settings' ) );

        }

        //Create Google Maps API submenu
        public function premium_gutenberg_maps() {
            add_submenu_page(
                'premium-gutenberg',
                '',
                __('Settings','premium-blocks-for-gutenberg'),
                'manage_options',
                'premium-gutenberg-maps',
                [ $this, 'pb_maps_page']
            );
        }

        //Update options and Create HTML layout for System Info submenu
        public function pb_maps_page() {
            $js_info = array(
                'ajaxurl'   => admin_url( 'admin-ajax.php' ),
                'nonce'     => wp_create_nonce( 'pbg-assets' )
            );

            wp_localize_script( 'pbg-admin-js', 'settings', $js_info );

            $this->pb_maps_default = $this->get_default_keys();

            $this->pb_maps_get = $this->get_enabled_keys();

            $pb_maps_new = array_diff_key( $this->pb_maps_default, $this->pb_maps_get );

            if( ! empty( $pb_maps_new ) ) {

                $pa_maps_updated = array_merge( $this->pa_maps_get_settings, $pb_maps_new );

                update_option( 'pbg_maps_settings', $pa_maps_updated );

            }

            $this->pa_maps_get = get_option( 'pbg_maps_settings', $this->pb_maps_default );

            ?>
            <div class="wrap">
                <div class="response-wrap"></div>
                <form action="" method="POST" id="pb-maps" name="pb-maps">
                    <div class="pb-header-wrapper">
                        <div class="pb-title-left">
                            <h1 class="pb-title-main"><?php echo __('Premium Blocks for Gutenberg','premium-blocks-for-gutenberg'); ?></h1>
                            <h3 class="pb-title-sub"><?php echo __('Thank you for using Premium Blocks for Gutenberg. This plugin has been developed by Leap13 and we hope you enjoy using it.','premium-blocks-for-gutenberg'); ?></h3>
                        </div>
                        <div class="pb-title-right">
                            <img class="pb-logo" src="<?php echo PREMIUM_BLOCKS_URL . 'admin/images/premium-blocks-logo.png';?>">
                        </div>
                    </div>
                    <div class="pb-settings-tabs">
                       <div id="pb-maps-api" class="pb-maps-tab">
                          <div class="pb-row">
                                <table class="pb-maps-table">
                                    <tr>
                                        <p class="pb-maps-api-notice">
                                            <?php echo sprintf(__('Premium Maps Block requires Google API key to be entered below. If you don’t have one, Click <a href="%s" target="_blank"> Here</a> to get your key.','premium-blocks-for-gutenberg'), 'https://developers.google.com/maps/documentation/javascript/get-api-key'); ?>
                                        </p>
                                    </tr>
                                    <tr>
                                        <th>
                                            <h4 class="pb-api-title"><label><?php echo __('Google Maps API Key:', 'premium-blocks-for-gutenberg'); ?></label><input name="premium-map-key" id="premium-map-key" type="text" placeholder="API Key" value="<?php echo esc_attr( $this->pa_maps_get['premium-map-key'] ); ?>"></h4>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <h4 class="pb-api-disable-title"><label><?php echo __('Enable Maps API JS File:','premium-blocks-for-gutenberg'); ?></label><input name="premium-map-api" id="premium-map-api" type="checkbox" <?php checked( 1, $this->pb_maps_get['premium-map-api'], true) ?>><span><?php echo __('This will Enable the API JS file if it\'s not included by another theme or plugin','premium-blocks-for-gutenberg');?></span></h4>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <h4 class="pb-api-disable-title"><label><?php echo __('Enable Font Awesome Icons:','premium-blocks-for-gutenberg'); ?></label><input name="premium-fa-css" id="premium-fa-css" type="checkbox" <?php checked( 1, $this->pb_maps_get['premium-fa-css'], true) ?>><span><?php echo __('This will load Font Awesome Icons to be used within Premium Blocks','premium-blocks-for-gutenberg');?></span></h4>
                                        </th>
                                    </tr>
                                </table>
                                <input type="submit" value="Save Settings" class="button pb-btn pb-save-button">
                                <div>
                                    <p><?php echo __('Did you like Premium Blocks for Gutenberg Plugin? Please', 'premium-blocks-for-gutenberg') ?> <a href="https://wordpress.org/support/plugin/premium-blocks-for-gutenberg/reviews/?filter=5" target="_blank"><?php echo __('Click Here to Rate it ★★★★★', 'premium-blocks-for-gutenberg') ?></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
               </form>
            </div>
        <?php }

        //Get Default Keys
        public static function get_default_keys() {

            $default_keys = array_fill_keys( self::$pb_maps_keys, true );

            return $default_keys;
        }

        //Get Default Configuration
        public static function get_enabled_keys() {

            $enabled_keys = get_option( 'pbg_maps_settings', self::get_default_keys() );

            return $enabled_keys;
        }

        /**
        * Save map block configuration settings
        *
        * @since  1.0.0
        * @return object
        */
        public function pb_save_maps_settings() {
            
            check_ajax_referer( 'pbg-assets', 'security' );

            if( isset( $_POST['fields'] ) ) {
                parse_str( $_POST['fields'], $settings );
            } else {
                return;
            }

            $this->pb_maps_settings = array(
                'premium-map-key'           => sanitize_text_field( $settings['premium-map-key'] ),
                'premium-map-api'           => intval( $settings['premium-map-api'] ? 1 : 0),
                'premium-fa-css'            => intval( $settings['premium-fa-css'] ? 1 : 0),
            );

            update_option( 'pbg_maps_settings', $this->pb_maps_settings );

            return true;
            die();
        }

        /**
        * Returns the instance.
        *
        * @since  1.0.0
        * @return object
        */
        public static function get_instance() {
            if( self::$instance == null ) {
                self::$instance = new self;
            }
            return self::$instance;
        }

    }
}

if( ! function_exists('premium_gutenberg_maps') ) {
    
    function premium_gutenberg_maps() {
        return Premium_Guten_Maps::get_instance();
    }
    
}
premium_gutenberg_maps();