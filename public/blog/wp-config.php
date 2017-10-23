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
define('DB_NAME', 'takedaily_wp');

/** MySQL database username */
define('DB_USER', 'forge');

/** MySQL database password */
define('DB_PASSWORD', 'irxHSp3b6hFNVR0UJtBc');

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
define('AUTH_KEY',         'muW6w{}zz!`-Ahf)^#`Y=)Wq$|nkXJ5{nA?!7-vNs!!Z]Rh2j3WEWw@Ic9i}dr)}');
define('SECURE_AUTH_KEY',  '4ny;p=k|{<;l5e7dx?2Zx|mlx;:zX!Pn)tQ$t$FxEM(c32NIq)#~Bl3ZeX^P_H=G');
define('LOGGED_IN_KEY',    'JBpS)KZ&nm`B_>fefNo7?~!0|~M[(jUW-Nt2H_`@&$4lGqvbcN^BNCm@Vf[a6|LQ');
define('NONCE_KEY',        'P|n<K`>`O;u{fli&Y8sSUzv6$o6%qE5YD>*JNaRz]TfN/KeMP^#cli4J1PB?raH0');
define('AUTH_SALT',        'tYTv.02Qmb-tiyX%3KDj)EHKV.c[zNC|$G<2.uWqtjeimA[@%S6|mHpHyD9@&8@ ');
define('SECURE_AUTH_SALT', 'dpYx$.6pNb^p6^).B1v#$MWomU28!M*2Q)IUR5p+5pqsDq3`tvAXQN6e;_g[w)|G');
define('LOGGED_IN_SALT',   'vQvhIrMHFpBlbX6imXV=qqgh`/rp),6(v:`Ftwr?1W]spWiLVWy|2NU@A)8ToW+A');
define('NONCE_SALT',       'n/nFQzfvLiKc:>5.mPCPe6X#&+3a|2s`f[5}?Y<Pp8P#IAe2`m]LE i7qb^g6BT0');

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
