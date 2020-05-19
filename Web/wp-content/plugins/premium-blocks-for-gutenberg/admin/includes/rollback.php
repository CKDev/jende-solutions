<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit();

//Declare `Premium_Guten_Blocks` if not declared yet.
if ( ! class_exists('Premium_Guten_RollBack') ) {

	class Premium_Guten_RollBack {

		protected $package_url;

		protected $version;

		protected $plugin_name;

		protected $plugin_slug;

		private static $instance = null;

		public function __construct( $args = [] ) {
			foreach ( $args as $key => $value ) {
				$this->{$key} = $value;
			}
		}

		private function print_inline_style() {
			?>
			<style>
				.wrap {
					overflow: hidden;
				}

				h1 {
					background: #6ec1e4;
					text-align: center;
					color: #fff !important;
					padding: 70px !important;
					text-transform: uppercase;
					letter-spacing: 1px;
				}
				h1 img {
					max-width: 300px;
					display: block;
					margin: auto auto 50px;
				}
			</style>
			<?php
		}

		protected function apply_package() {
			$update_plugins = get_site_transient( 'update_plugins' );
			if ( ! is_object( $update_plugins ) ) {
	            
				$update_plugins = new \stdClass();
			}

			$plugin_info = new \stdClass();
			$plugin_info->new_version = $this->version;
			$plugin_info->slug = $this->plugin_slug;
			$plugin_info->package = $this->package_url;
			$plugin_info->url = 'https://premiumblocks.io/';

			$update_plugins->response[ $this->plugin_name ] = $plugin_info;

			set_site_transient( 'update_plugins', $update_plugins );
		}

		protected function upgrade() {
			require_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );

			$logo_url = PREMIUM_BLOCKS_URL . 'admin/images/premium-blocks-logo.png';

			$upgrader_args = [
				'url' => 'update.php?action=upgrade-plugin&plugin=' . rawurlencode( $this->plugin_name ),
				'plugin' => $this->plugin_name,
				'nonce' => 'upgrade-plugin_' . $this->plugin_name,
				'title' => '<img src="' . $logo_url . '" alt="Premium Blocks">' . __( 'Rolling Back to Version ' . PREMIUM_BLOCKS_STABLE_VERSION, 'premium-gutenberg' ),
			];

			$this->print_inline_style();

			$upgrader = new \Plugin_Upgrader( new \Plugin_Upgrader_Skin( $upgrader_args ) );
			$upgrader->upgrade( $this->plugin_name );
		}

		public function run() {
			$this->apply_package();
			$this->upgrade();
		}

		public static function get_instance() {
            if( self::$instance == null ) {
                self::$instance = new self;
            }
            return self::$instance;
        }
        
	}
}

if( ! function_exists('premium_gutenberg_rollback') ) {
    
    function premium_gutenberg_rollback() {
        return Premium_Guten_RollBack::get_instance();
    }
    
}
premium_gutenberg_rollback();