<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit();

//Declare `Premium_Guten_Blocks` if not declared yet.
if ( ! class_exists('Premium_Guten_Blocks') ) {
    
    /**
    * Define Premium_Guten_Admin class
    */
    class Premium_Guten_Admin {
    
        private static $instance = null;

        protected $slug = 'premium-gutenberg';

        public static $pbg_blocks = ['dualHeading','banner','pricingTable','maps','testimonial', 'countUp', 'icon', 'button', 'container', 'accordion', 'iconBox', 'videoBox'];

        private $pbg_default;

        private $pbg_settings;

        private $pbg_get_settings;

        /*
         * Constructor for the class
         */
        public function __construct() {
            
            add_action( 'admin_menu', array( $this,'pbg_admin') );
            
            add_action( 'admin_menu', array( $this,'change_pbg_admin_name'), 999 );
            
            add_action('admin_enqueue_scripts', array( $this, 'pa_admin_page_scripts' ) );

            add_action( 'wp_ajax_pbg_settings', array( $this, 'pbg_settings' ) );
        }

        //Enqueue dashboard menu required assets
        public function pa_admin_page_scripts () {
            
            wp_enqueue_style( 'pbg-icon', PREMIUM_BLOCKS_URL .'admin/assets/pbg-font/css/pbg-font.css' );
            
            wp_enqueue_style( 'pbg-blocks-icons', PREMIUM_BLOCKS_URL .'admin/assets/pbg-font/css/pbg-elements.css' );

            wp_enqueue_style( 'pbg-notices', PREMIUM_BLOCKS_URL .'admin/assets/notice.css' );
            
            $current_screen = get_current_screen();
            
            if( strpos( $current_screen->id, $this->slug ) !== false){
                
                wp_enqueue_style(
                    'pbg-admin',
                    PREMIUM_BLOCKS_URL . 'admin/assets/admin.css',
                    array(),
                    PREMIUM_BLOCKS_VERSION,
                    'all'
                );
                
                wp_enqueue_style(
                    'swal-style',
                    PREMIUM_BLOCKS_URL . 'admin/assets/js/sweetalert2/css/sweetalert2.min.css'
                );
                
                wp_enqueue_script(
                    'swal-core',
                    PREMIUM_BLOCKS_URL . 'admin/assets/js/sweetalert2/js/core.js',
                    array( 'jquery' ),
                    PREMIUM_BLOCKS_VERSION,
                    true
                );
            
                wp_enqueue_script(
                    'swal',
                    PREMIUM_BLOCKS_URL . 'admin/assets/js/sweetalert2/js/sweetalert2.min.js',
                    array( 'jquery', 'swal-core' ),
                    PREMIUM_BLOCKS_VERSION,
                    true
                );
                
                wp_enqueue_script(
                    'pbg-admin-js',
                    PREMIUM_BLOCKS_URL . 'admin/assets/admin.js',
                    array( 'jquery' ),
                    PREMIUM_BLOCKS_VERSION, 
                    true
                );
            }
        }

        //Create Premium Blocks for Gutenberg menu page
        public function pbg_admin() {
            
            add_menu_page(
                __('Premium Blocks for Gutenberg','premium-gutenberg'),
                __('Premium Blocks for Gutenberg','premium-gutenberg'),
                'manage_options',
                'premium-gutenberg',
                array( $this , 'pbg_blocks_page' ),
                '' ,
                100
            );
            
        }
        
        //Replace first submenu name
        public function change_pbg_admin_name() {
            global $submenu;
            
            if( isset( $submenu['premium-gutenberg'] ) ){
                $submenu['premium-gutenberg'][0][0] = __( 'Blocks Settings', 'premium-gutenberg' );
            }
            
        }

        //Update options and Create HTML layout for Blocks Settings submenu
        public function pbg_blocks_page() {
            
            $js_info = array(
                'ajaxurl'   => admin_url( 'admin-ajax.php' ),
                'nonce'     => wp_create_nonce( 'pbg-blocks' )
            );

            wp_localize_script(
                'pbg-admin-js',
                'settings',
                $js_info
            );
            
            $this->pbg_default = $this->get_default_keys();

            $this->pbg_get_settings = $this->get_enabled_keys();

            $pbg_new_settings = array_diff_key( $this->pbg_default, $this->pbg_get_settings );

            if( ! empty( $pbg_new_settings ) ) {

                $pbg_updated_settings = array_merge( $this->pbg_get_settings, $pbg_new_settings );

                update_option( 'pbg_settings', $pbg_updated_settings );

            }

            $this->pbg_get_settings = get_option( 'pbg_settings', $this->pbg_default );
      
        ?>

        <div class="wrap">
            <div class="response-wrap"></div>
            <form action="" method="POST" id="pbg-settings" name="pbg-settings">
                <div class="pb-header-wrapper">
                    <div class="pb-title-left">
                        <h1 class="pb-title-main"><?php echo __('Premium Blocks for Gutenberg','premium-gutenberg'); ?></h1>
                        <h3 class="pb-title-sub"><?php echo __('Thank you for using Premium Blocks for Gutenberg. This plugin has been developed by Leap13 and we hope you enjoy using it.','premium-gutenberg'); ?></h3>
                    </div>
                    
                    <div class="pb-title-right">
                        <img class="pb-logo" src="<?php echo PREMIUM_BLOCKS_URL . 'admin/images/premium-blocks-logo.png';?>">
                    </div>
                    
                </div>
                <div class="pb-settings-tabs">
                    <div id="pb-modules" class="pb-settings-tab">
                        <div>
                            <br>
                            <input type="checkbox" class="pb-checkbox" checked="checked">
                            <label>Enable/Disable All</label>
                        </div>
                        <table class="pb-elements-table">
                            <tbody>
                                <tr>
                                    <th><?php echo __('Premium Accordion', 'premium-gutenberg'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" id="accordion" name="accordion" <?php checked(1, $this->pbg_get_settings['accordion'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <th><?php echo __('Premium Banner', 'premium-gutenberg'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" id="banner" name="banner" <?php checked(1, $this->pbg_get_settings['banner'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Premium Button', 'premium-gutenberg'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" id="button" name="button" <?php checked(1, $this->pbg_get_settings['button'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <th><?php echo __('Premium Count Up', 'premium-gutenberg'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" id="countUp" name="countUp" <?php checked(1, $this->pbg_get_settings['countUp'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Premium Dual Heading', 'premium-gutenberg'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" id="dualheading" name="dualHeading" <?php checked(1, $this->pbg_get_settings['dualHeading'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <th><?php echo __('Premium Icon', 'premium-gutenberg'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" id="icon" name="icon" <?php checked(1, $this->pbg_get_settings['icon'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Premium Icon Box', 'premium-gutenberg'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" id="iconBox" name="iconBox" <?php checked(1, $this->pbg_get_settings['iconBox'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>

                                    <th><?php echo __('Premium Maps', 'premium-gutenberg'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" id="maps" name="maps" <?php checked(1, $this->pbg_get_settings['maps'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Premium Pricing Table', 'premium-gutenberg'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" id="pricingTable" name="pricingTable" <?php checked(1, $this->pbg_get_settings['pricingTable'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <th><?php echo __('Premium Section', 'premium-gutenberg'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" id="maps" name="container" <?php checked(1, $this->pbg_get_settings['container'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo __('Premium Testimonials', 'premium-gutenberg'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" id="testimonial" name="testimonial" <?php checked(1, $this->pbg_get_settings['testimonial'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <th><?php echo __('Premium Video Box', 'premium-gutenberg'); ?></th>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" id="videoBox" name="videoBox" <?php checked(1, $this->pbg_get_settings['videoBox'], true) ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                        <input type="submit" value="Save Settings" class="button pb-btn pb-save-button">
                    </div>
                    <div>
                        <p><?php echo __('Did you like Premium Blocks for Gutenberg Plugin? Please', 'premium-gutenberg') ?> <a href="https://wordpress.org/support/plugin/premium-blocks-for-gutenberg/reviews/?filter=5" target="_blank"><?php echo __('Click Here to Rate it ★★★★★', 'premium-gutenberg') ?></a></p>
                    </div>
                </div>
            </form>
        </div>
        <?php
        }
        
        //Get Default Keys
        public static function get_default_keys() {
            
            $default_keys = array_fill_keys( self::$pbg_blocks, true );
        
            return $default_keys;
        }
        
        //Get Default Configuration
        public static function get_enabled_keys() {
        
            $enabled_keys = get_option( 'pbg_settings', self::get_default_keys() );
        
            return $enabled_keys;
        }

        /**
        * Save blocks configuration settings
        *
        * @since  1.0.0
        * @return object
        */
        public function pbg_settings() {

            check_ajax_referer( 'pbg-blocks', 'security' );
            
            if( isset( $_POST['fields'] ) ) {

                parse_str( $_POST['fields'], $settings );

            } else {

                return;
            }
            
            $this->pbg_settings = array(
                'dualHeading'   => intval( $settings['dualHeading'] ? 1 : 0 ),
                'banner'        => intval( $settings['banner'] ? 1 : 0 ),
                'maps'          => intval( $settings['maps'] ? 1 : 0 ),
                'pricingTable'  => intval( $settings['pricingTable'] ? 1 : 0 ),
                'testimonial'   => intval( $settings['testimonial'] ? 1 : 0 ),
                'countUp'       => intval( $settings['countUp'] ? 1 : 0 ),
                'icon'          => intval( $settings['icon'] ? 1 : 0 ),
                'button'        => intval( $settings['button'] ? 1 : 0 ),
                'container'     => intval( $settings['container'] ? 1 : 0 ),
                'accordion'     => intval( $settings['accordion'] ? 1 : 0 ),
                'iconBox'       => intval( $settings['iconBox'] ? 1 : 0 ),
                'videoBox'      => intval( $settings['videoBox'] ? 1 : 0 ),
            );

            update_option( 'pbg_settings', $this->pbg_settings );

            return true;

        }
        
        public static function get_instance() {
            if( self::$instance == null ) {
                self::$instance = new self;
            }
            return self::$instance;
        }
    
    }
}

if( ! function_exists('premium_gutenberg') ) {
    
    function premium_gutenberg() {
        return Premium_Guten_Admin::get_instance();
    }
    
}
premium_gutenberg();