<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'grand_old');

/** MySQL database username */
define('DB_USER', 'admin');

/** MySQL database password */
define('DB_PASSWORD', '1234');

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
 
 define( 'WP_SITEURL', 'http://grand.loc/');
define( 'WP_HOME', 'http://grand.loc/');
define('AUTH_KEY',         '<k{E%}<.].^+3sfo<b$-<|I5F.sYb96ytboxHQM-ZPY!J|whT[J{p|DI+.{uW eV');
define('SECURE_AUTH_KEY',  'Dp-oSL#DDzErRW^17PDJE_b@s<6Y3Hx3$jl~D2Y- Kc|7W!=Fhb!_}&8>-W}o$|A');
define('LOGGED_IN_KEY',    'CR=W{{9-?qeGr*~7K($jj4X<{YJ64p1e+mF Oh9]k<Qk%S491iffY8I?-tvzA2]M');
define('NONCE_KEY',        '>SB`:ZALqE_/6S|X_M;8V-_B-?PTc{jmqWqM8xk<Kyh!. 67`/!(8.;t&bgh7,YC');
define('AUTH_SALT',        '+aC!;!j`ZJ`N*>oy5|Kvqq?|4OkxZ1PN$n^sa@iVk1.FaMWZ_bmWEC_.BavOGPo$');
define('SECURE_AUTH_SALT', '/CR9IX|mT^{xvb~:f.;hTQM#)V_X5F[wNS-ai|SxT>TmTK)YnW-E#5XSQu6b@jFz');
define('LOGGED_IN_SALT',   'plQ@uo5w&Asflp1g0}~|7G)OvU-#,T7M_Z+1-1&kuNB<*_6a1!G+k)%-72}a_$+z');
define('NONCE_SALT',       '?Hm7.pPT|oFg%ht%xqlnSrxO?LG0< nJY-Xowv[cK(v?OQm:Frs[F8K.IaWCGL-f');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define( 'FS_METHOD', 'direct' );
