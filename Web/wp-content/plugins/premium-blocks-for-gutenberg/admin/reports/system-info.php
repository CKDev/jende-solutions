<?php

//Exit if accessed directly
if( ! defined('ABSPATH') ) exit;

// Define class 'Premium_Guten_System' if not Exists
if( ! class_exists( 'Premium_Guten_System' ) ) {
    
    /**
    * Define Premium_Guten_System class
    */
    class Premium_Guten_System {

        private static $instance = null;

        /**
        * Constructor for the class
        */
        public function __construct() {
            add_action( 'admin_menu', array ( $this,'create_sys_info_menu' ), 100 );
        }

        //Create System Info submenu
        public function create_sys_info_menu() {
            add_submenu_page(
                'premium-gutenberg',
                '',
                __('System Info','premium-blocks-for-gutenberg'),
                'manage_options',
                'premium-gutenberg-system',
                [$this, 'get_system_info_layout']
            );
        }

        //Creates HTML layout for System Info submenu
        public function get_system_info_layout(){
        ?>
            <div class="wrap">
                <div class="response-wrap"></div>
                <div class="pb-header-wrapper">
                    <div class="pb-title-left">
                        <h1 class="pb-title-main"><?php echo __('Premium Blocks for Gutenberg','premium-blocks-for-gutenberg'); ?></h1>
                        <h3 class="pb-title-sub"><?php echo __('Thank you for using Premium Blocks for Gutenberg. This plugin has been developed by Leap13 and we hope you enjoy using it.','premium-blocks-for-gutenberg'); ?></h3>
                    </div>
                    <div class="pb-title-right">
                        <img class="pb-logo" src="<?php echo PREMIUM_BLOCKS_URL . 'admin/images/premium-blocks-logo.png';?>">
                    </div>
                </div>
                <div class="pb-settings-tabs pb-sys-info-tab">
                    <div id="pb-system" class="pb-settings-tab">
                        <div class="pb-row">                
                            <h3 class="pb-sys-info-title"><?php echo __('System setup information useful for debugging purposes.','premium-blocks-for-gutenberg');?></h3>
                            <div class="pb-system-info-container">
                                <?php  echo nl2br( premium_gutenberg_get_sysinfo() ); ?>
                                <p><?php echo __('Did you like Premium Blocks for Gutenberg Plugin? Please ','premium-blocks-for-gutenberg');?><a href="https://wordpress.org/support/plugin/premium-blocks-for-gutenberg/reviews/?filter=5" target="_blank"><?php echo __('Click Here to Rate it ★★★★★','premium-blocks-for-gutenberg'); ?></a></p>
                            </div>
                        </div>
                    </div>
                        
                </div>
            </div>
        <?php }
        
        /**
        * Returns the instance.
        *
        * @since  1.0.0
        * @return object
        */
        public static function get_instance(){
            if( self::$instance == null ) {
                self::$instance = new self;
            }
            return self::$instance;
        }
    }
}

if( ! function_exists('premium_gutenberg_system') ) {
    
    function premium_gutenberg_system() {
        return Premium_Guten_System::get_instance();
    }
    
}
premium_gutenberg_system();