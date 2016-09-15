<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'app');

/** MySQL database username */
define('DB_USER', 'db-user');

/** MySQL database password */
define('DB_PASSWORD', 'db-pwd');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Spv:2Un5wwh-@~}]{]q%Mh`%T9=,H0%Xi24Xm$i?z:X)toqORkT|uw+<L>R=*f G');
define('SECURE_AUTH_KEY',  'w[WIj$/N{w.SV5iY;~FPqb!zQMM3V_xvS96`P@mP_O%7*5fmVXQei~z1cP1_SHjg');
define('LOGGED_IN_KEY',    '@d^pGcAv1 iJJ?htCdaK&.+zQu^6Fn@GtARCmt<q^5xfD:!4;y6=+O/8 :9=LW+Q');
define('NONCE_KEY',        'q%^*gi9Kl2jDs@fz7dZ%yK=pBEaJx0PUst`,#QV%R]WMdSS6V^J]0VUKK 48>{mO');
define('AUTH_SALT',        'ac`c. n^+QOZnFAkTyB{a{{Bcf_?qz.G]5]ZXb%4r13W+c|rw_pi@8P=dunz6Ji;');
define('SECURE_AUTH_SALT', 'kB<RV+qzKA^,U]R9>2DaRWlr|;rJt%8SB$6r r%y,ACl.{)8HwZAlx4PB]n6@.hF');
define('LOGGED_IN_SALT',   'sgm5uxc-$ El{V6N`4#TyjvHWGJTKZ,9je:95d-#tOs=SmoLAeuJ=p)3X{[]Z5H[');
define('NONCE_SALT',       'c1~`O;{!CkkYe#|@Jbkma!*zm?@CT:84<E`uhM*}~3SscD=&c;[Ft*H*Iom4ij]w');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
