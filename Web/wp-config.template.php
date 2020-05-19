<?php
/**
 * Custom WordPress configurations on "wp-config.php" file.
 *
 * This file has the following configurations: MySQL settings, Table Prefix, Secret Keys, WordPress Language, ABSPATH and more.
 * For more information visit {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php} Codex page.
 * Created using {@link http://generatewp.com/wp-config/ wp-config.php File Generator} on GenerateWP.com.
 *
 * @package WordPress
 * @generator GenerateWP.com
 */

/* MySQL settings */
define('DB_NAME',     @MYSQL_DATABASE);
define('DB_USER',     @MYSQL_USERNAME);
define('DB_PASSWORD', @MYSQL_PASSWORD);
define('DB_HOST',     @MYSQL_HOST);
define('DB_CHARSET',  'utf8mb4');

/* MySQL database table prefix. */
$table_prefix = '443_';

/* Authentication Unique Keys and Salts. */
define('AUTH_KEY',         @AUTH_KEY);
define('SECURE_AUTH_KEY',  @SECURE_AUTH_KEY);
define('LOGGED_IN_KEY',    @LOGGED_IN_KEY);
define('NONCE_KEY',        @NONCE_KEY);
define('AUTH_SALT',        @AUTH_SALT);
define('SECURE_AUTH_SALT', @SECURE_AUTH_SALT);

/* SSL */
define('FORCE_SSL_LOGIN', true);
define('FORCE_SSL_ADMIN', true);

/* Custom WordPress URL. */
define( 'WP_SITEURL',     'https://' . $_SERVER['HOST'] );

/* Multisite. */
define( 'WP_ALLOW_MULTISITE', 'false' );

/* WordPress debug mode for developers. */
define( 'WP_DEBUG',         $_SERVER['ENVIRONMENT'] == 'development' );
define( 'WP_DEBUG_LOG',     $_SERVER['ENVIRONMENT'] == 'development' );
define( 'WP_DEBUG_DISPLAY', $_SERVER['ENVIRONMENT'] == 'development' );
define( 'SCRIPT_DEBUG',     $_SERVER['ENVIRONMENT'] == 'development' );
define( 'SAVEQUERIES',      'false' );

/* PHP Memory */
define( 'WP_MEMORY_LIMIT', '30M' );
define( 'WP_MAX_MEMORY_LIMIT', '256M' );

/* WordPress Cache */
define( 'WP_CACHE', $_SERVER['ENVIRONMENT'] != 'development' );

/* Compression */
define( 'COMPRESS_CSS',        $_SERVER['ENVIRONMENT'] != 'development' );
define( 'COMPRESS_SCRIPTS',    $_SERVER['ENVIRONMENT'] != 'development' );
define( 'CONCATENATE_SCRIPTS', $_SERVER['ENVIRONMENT'] != 'development' );
define( 'ENFORCE_GZIP',        $_SERVER['ENVIRONMENT'] != 'development' );

/* CRON */
define( 'DISABLE_WP_CRON',      'false' );
define( 'WP_CRON_LOCK_TIMEOUT', 120 );

/* Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/* Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');