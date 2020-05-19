<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Define class 'Premium_Guten_About' if not Exists
if( ! class_exists( 'Premium_Guten_About' ) ) {
  class Premium_Guten_About {

      private static $instance = null;

      public function __construct() {
        add_action( 'admin_menu', array ( $this, 'create_about_menu' ) );
      }

      public function create_about_menu(){
          
          add_submenu_page(
            'premium-gutenberg',
            '',
            __('About','premium-blocks-for-gutenberg'),
            'manage_options',
            'premium-gutenberg-about',
            [ $this, 'pbg_about_page' ]
        );
      }

  	 public function pbg_about_page(){
          
      ?>
      <div class="wrap">
        <div class="response-wrap"></div>
          <div class="pb-header-wrapper">
            <div class="pb-title-left">
               <h1 class="pb-title-main"><?php echo __('Premium Blocks for Gutenberg', 'premium-blocks-for-gutenberg') ?></h1>
               <h3 class="pb-title-sub"><?php echo __('Thank you for using Premium Blocks for Gutenberg. This plugin has been developed by Leap13 and we hope you enjoy using it.','premium-blocks-for-gutenberg'); ?></h3>
            </div>
        
            <div class="pb-title-right">
              <img class="pb-logo" src="<?php echo PREMIUM_BLOCKS_URL . 'admin/images/premium-blocks-logo.png';?>">
            </div>
          </div>

      <div class="pb-settings-tabs">
        <div id="pb-about" class="pb-settings-tab">
           <div class="pb-row">
              <div class="pb-col-half">
                 <div class="pb-about-panel">
                    <div class="pb-icon-container">
                       <i class="dashicons dashicons-info abt-icon-style"></i>
                    </div>
                    <div class="pb-text-container">
                       <h4>What is Premium Blocks ?</h4>
                       <p>Premium Blocks for Gutenberg helps you create amazing looking websites using the new WordPress Editor: Gutenberg.</p>
                    </div>
                 </div>
              </div>
              <div class="pb-col-half">
                 <div class="pb-about-panel">
                    <div class="pb-icon-container">
                       <i class="dashicons dashicons-universal-access-alt abt-icon-style"></i>
                    </div>
                    <div class="pb-text-container">
                       <h4>Support</h4>
                       <p>You can join our <a href="https://www.facebook.com/groups/2339461846127319/" target="_blank">Facebook Group</a> and Our <a href="https://my.leap13.com/forums/" target="_blank">Community Forums</a> and we will be glad to help you.</p>
                    </div>
                 </div>
              </div>
           </div>
          
              <div>
                  <p><?php echo __('Did you like Premium Blocks for Gutenberg Plugin? Please ','premium-blocks-for-gutenberg');?><a href="https://wordpress.org/support/plugin/premium-blocks-for-gutenberg/reviews/?filter=5" target="_blank"><?php echo __('Click Here to Rate it ★★★★★','premium-blocks-for-gutenberg'); ?></a></p>
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

if( ! function_exists('premium_gutenberg_about') ) {
    
    function premium_gutenberg_about() {
        return Premium_Guten_About::get_instance();
    }
    
}
premium_gutenberg_about();