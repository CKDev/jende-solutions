<?php
/*
 * Plugin Name: Premium Blocks for Gutenberg
 * Description: Gutenberg blocks that will help you build amazing pages with the new WordPress Gutenberg editor.
 * Plugin URI: https://premiumblocks.io/
 * Author: Leap13
 * Author URI: https://leap13.com/
 * Version: 1.7.9
 * Text Domain: premium-blocks-for-gutenberg
 * Domain Path: /languages
 * License: GNU General Public License v3.0
 * @package gutenberg_premium_blocks
 */

/**
 * Exit if accessed directly
 */
if( ! defined( 'ABSPATH' ) ) exit;

//Define plugin constants
define( 'PREMIUM_BLOCKS_VERSION', '1.7.9');
define( 'PREMIUM_BLOCKS_URL', plugins_url('/', __FILE__) );
define( 'PREMIUM_BLOCKS_PATH', plugin_dir_path(__FILE__) );
define( 'PREMIUM_BLOCKS_FILE', __FILE__);
define( 'PREMIUM_BLOCKS_BASENAME', plugin_basename(__FILE__) );
define( 'PREMIUM_BLOCKS_STABLE_VERSION', '1.7.8');

require_once( PREMIUM_BLOCKS_PATH . 'includes/plugin.php' );

/*
 * Initialize Plugin Main Class
 * @return void
 */
add_action('init', array('Premium_Blocks_Gutenberg','get_instance') );