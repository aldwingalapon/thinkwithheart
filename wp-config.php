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
define( 'DB_NAME', 'holewinski_area55' );

/** MySQL database username */
define( 'DB_USER', 'holewinski' );

/** MySQL database password */
define( 'DB_PASSWORD', 'v+f~quJJjlPFoI@1' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Q/]|AymKB4{:/-eF{LGg35@sLF[LVmo|`>h&P2Xq|lu(x5eO 21u?{cPUDfh(hZ[' );
define( 'SECURE_AUTH_KEY',  'FrFQ-h-V<l >aN0AHxgaehQf7&%u{5uuy-uSy];t: sSnk45h4 hZ;M#;dKi}cWx' );
define( 'LOGGED_IN_KEY',    '`f}oET-($CQq_X@U.Y:d%jx~+LoTnPW_7&7122M?B/M-?wb)n}~vE>bEWFZD Wl*' );
define( 'NONCE_KEY',        'm/fpW-78fgr,:&)w~HM,Ym(c1*W_&.%8S8xbg*Hrf,{;`@6DEE!)-hp_-?vK||@5' );
define( 'AUTH_SALT',        ',#i9Z/M=|N<{XVt7dCy$<JT{2*v2`=)+L7Id@szXVaf@vv+HH]5&r]PaO%tZC%Vy' );
define( 'SECURE_AUTH_SALT', '6qN]RC!}0`yK-lq<amA;P,O)a!X#zJ#JQy7NoWDb;siS/]GHJ1@0nXgTk#e:5@7Y' );
define( 'LOGGED_IN_SALT',   'X@1O~Ksr]VdPO.px&6d~xUcqPPUu,6)DQhYbG{]|L31k+@AHw>h0<ZC87pV2./)<' );
define( 'NONCE_SALT',       '5)?O_{ccl}Tq|tH1vm0HR_u&C2S|].9qr0OS0,r}A=S-H2k-:z&OJnqDD,is4pN8' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
