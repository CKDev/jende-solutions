<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Premium_Guten_Version_Control {

    private static $instance = null;
    
    public function __construct() {

        add_action( 'admin_menu', array ( $this,'create_version_control_menu' ), 100 );

        add_action( 'admin_post_premium_gutenberg_rollback', array( $this, 'post_premium_gutenberg_rollback' ) );
    }
    
    
    public function create_version_control_menu(){
          add_submenu_page(
          'premium-gutenberg',
          '',
          __('Version Control','premium-gutenberg'),
          'manage_options',
          'premium-gutenberg-version',
          [$this, 'pbg_version_page']
      );
    }
    
    public function pbg_version_page() { ?>
      
      <div class="wrap">
        <div class="response-wrap"></div>
          <form action="" method="POST" id="pb-beta-form" name="pb-beta-form">
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
            <div id="pb-maintenance" class="pb-settings-tab">
               <div class="pb-row">
                  <table class="pb-beta-table">
                     <tr>
                        <th>
                           <h4 class="pb-roll-back">Rollback to Previous Version</h4>
                           <span class="pb-roll-back-span"><?php echo sprintf('Experiencing an issue with Premium Blocks for Gutenberg version %s? Rollback to a previous version before the issue appeared.',PREMIUM_BLOCKS_VERSION); ?></span>
                        </th>
                     </tr>
                     <tr class="pb-roll-row">
                        <th>Rollback Version</th>
                        <td>
                           <div><?php echo sprintf( '<a href="%s" target="_blank" class="button pb-btn pb-rollback-button elementor-button-spinner">Reinstall Version 1.7.8</a>', wp_nonce_url( admin_url( 'admin-post.php?action=premium_gutenberg_rollback' ), 'premium_gutenberg_rollback' ) ); ?> </div>
                           <p class="pb-roll-desc"><span>Warning: Please backup your database before making the rollback.</span></p>
                        </td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>
        </form>
      </div>
    <?php }

    public function post_premium_gutenberg_rollback() {

	    check_admin_referer( 'premium_gutenberg_rollback' );
	    $plugin_slug = basename( PREMIUM_BLOCKS_FILE, '.php' );
	    $pbg_rollback = new Premium_Guten_RollBack(
	        [
	            'version' => PREMIUM_BLOCKS_STABLE_VERSION,
	            'plugin_name' => PREMIUM_BLOCKS_BASENAME,
	            'plugin_slug' => $plugin_slug,
	            'package_url' => sprintf( 'https://downloads.wordpress.org/plugin/%s.%s.zip', $plugin_slug, PREMIUM_BLOCKS_STABLE_VERSION ),
	        ]
	    );

	    $pbg_rollback->run();

	    wp_die(
	        '', __( 'Rollback to Previous Version', 'premium-gutenberg' ), [
	        'response' => 200,
	        ]
	    );
	}

    public static function get_instance() {
      if( self::$instance == null ) {
          self::$instance = new self;
      }
      return self::$instance;
    }
}


if( ! function_exists('premium_gutenberg_version_control') ) {
    
    function premium_gutenberg_version_control() {
        return Premium_Guten_Version_Control::get_instance();
    }
    
}
premium_gutenberg_version_control();