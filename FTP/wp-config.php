<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'contactability_ca');

/** MySQL database username */
define('DB_USER', 'contactability_c');

/** MySQL database password */
define('DB_PASSWORD', 'YGHYcnLKeWFv8DNB');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'sAOO2lX]<+Qr5]Q]eXfcH8g$+YLs6CGD4n<kU~ #gk#^PWbteHsW(uurM..W#YXx');
define('SECURE_AUTH_KEY',  'Rj06Jmms,V-h!2nNOe<E=aNBaj0}d;q+^h{+fYJ624ZpAYC7YWf<5myV/0u-nF;.');
define('LOGGED_IN_KEY',    '?GM346._M5(lHdcVK>!@elcg#<e[qLP#~aD<^|DC>{&C-g7+)>]TrQ[g(Z46nnR]');
define('NONCE_KEY',        '4covV0R/3^1UV 0$fCZC>+MqcjI)=Zt)][$mHg~Q5[uKowHcI2_Olq67es/_{WJb');
define('AUTH_SALT',        '6uJRKA&8B+${>u`U8+.fxcBEmW>QWX+Q<hmx2/pnv~nJlSN+BT,?DP%W`l6RU&TB');
define('SECURE_AUTH_SALT', 'W.8r%: )w|<3XfRSZ2-&)|2-`bmt=Z-S7pp@h^`^-mJ]~gox<PQF21xqaow;5>P?');
define('LOGGED_IN_SALT',   '1;dht-l8r]&|1_pYFZvkOyE|DfwL{(^<u6<l5LbB-bOEY`d.-/H39-Vqf5d+>S]A');
define('NONCE_SALT',       '7G ?*X,y&P:%Tq+;H&mD;pZFY</b6E#bz-+FlY<kjgm6: Zz|Y{C(9G+Jr!`0[ou');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'en-EN');

$_SERVER['SERVER_SOFTWARE'] = 'Apache';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
