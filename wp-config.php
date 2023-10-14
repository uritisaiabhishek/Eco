<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'eco' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '@Fxherb;ti<5ld he|^i.}DJXva=H%/|/u8U0 C j^bdB)R ?n]Pzjks Q4bXY!&' );
define( 'SECURE_AUTH_KEY',  'AWw0}CA6Yi2d`0m6*>d:WYO%<d+joz!5_s%[G*Z(xGdZ1Dp2FH^>_?Rl, YwvbP?' );
define( 'LOGGED_IN_KEY',    '/x_|4uFA_Lm=/.<$sl|G[A1}T9&?1v7OPdjrTGuN,BQ^svxNtqf0DgjBhsv_lnh3' );
define( 'NONCE_KEY',        ']}x+w< $S~HX])]?6Aa|$vCVo_@b(H5SZ=G5$g=Rn_QBMZjyk=p[Gj0HmT7=>9^l' );
define( 'AUTH_SALT',        '5xD^O?fyOa.cq}*;6,HTR0On^~lV1)Ze9S<1QyT|p40#k[UYCs]go7k$]ILr]e~p' );
define( 'SECURE_AUTH_SALT', 'gVRt73:2zn0%Phk<mh+y2m6y)vh+1b[Z&)a><3U#z4eU)H=0+YsR+0|f0k~,JBi/' );
define( 'LOGGED_IN_SALT',   'Qt-#@.s]f$zp4{i@(IO7@rLxB-9H8*{Bd%VV1#@;1@0]kqrh.>p93y|*;kdFUS+h' );
define( 'NONCE_SALT',       'HbIwFHi?hrdXt#kKApOLl?$OU)Bvb9iT:Iyn(]p#e4%]>rmJ2!DV;OwQ7aUg;V@`' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'cp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
// Enable WP_DEBUG mode
define( 'WP_DEBUG', true );

// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );

// Disable display of errors and warnings
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
define( 'SCRIPT_DEBUG', true );
/* Add any custom values between this line and the "stop editing" line. */

// Increase maximum upload file size
define('WP_MEMORY_LIMIT', '64M');
define('WP_MAX_UPLOAD_FILESIZE', '32M');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
