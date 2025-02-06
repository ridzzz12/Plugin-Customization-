<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpressdb' );

/** Database username */
define( 'DB_USER', 'rida12' );

/** Database password */
define( 'DB_PASSWORD', '123456789' );

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
define( 'AUTH_KEY',         '<>,H8T=;>`BR rn3pQNtU^Z9GA0Ybf]S?1p]<d$tL_ k^o.{:|w?5ZpeP{x&$:d}' );
define( 'SECURE_AUTH_KEY',  'b!y7mX)Qp^5Pi);-)|_N%tli-cT~rtM,_%46`uhkbPqWiHT$]u9@.2t3wzyR(BEP' );
define( 'LOGGED_IN_KEY',    'DB*ktk{9!oO/S[w=B,/DELGYf;~)rn3nG;ML k4!|YBpCHr+g-E0y3bEISJaDWw)' );
define( 'NONCE_KEY',        'Glh{ge~xdb~l(68U!~B5*}<v6:piwr&GO)$={i}16D:,8;v-U{}R,bMYFAl*OgXe' );
define( 'AUTH_SALT',        '2Zgk>K=Hg2Ea3w!2:xR|M=:3-+zi~KA`.h8VOgn>g3/  +B^?vm&Jt),#bAaEF|1' );
define( 'SECURE_AUTH_SALT', 'v6&QP,NrH{}BKksC&Q@p<L///:3>Y62#8D-IYn.NVVt6Tv$#r|{D.4:j;D.n*M*8' );
define( 'LOGGED_IN_SALT',   '&Md^],YHP7G@5tzPu8Q^DFY#[4TG.vumFEyNbW^)9P!&]A$bmW$uN;0hl.&W_Hl8' );
define( 'NONCE_SALT',       '@-{R0Oba@g$JhgOLVFS~SCw!NKm*;n_j2uxT~/</p%.N[-MiS=c(ft g#HivC%~B' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);