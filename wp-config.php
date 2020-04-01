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

 /** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', getenv( 'DB_NAME' ) );

/** MySQL database username */
define( 'DB_USER', getenv( 'DB_USER' ) );

/** MySQL database password */
define( 'DB_PASSWORD', getenv( 'DB_PASSWORD' ) );

/** MySQL hostname */
define( 'DB_HOST', getenv( 'DB_HOST' ) );

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
define( 'AUTH_KEY',         'VFj^.3T1e@-qIqldGb*WjZW#J_uC[}n~.(-$x~fgY4D1o+{4I0@8aFu[o]&J_0~7' );
define( 'SECURE_AUTH_KEY',  'k25mRO;7FRm/xQ99YGAkj>:3tU1oouc#rc~-%b|2j)mLQCFsGu,S62u4fqL}w1|S' );
define( 'LOGGED_IN_KEY',    'V95ATklQ!SiJeLSNk]I`(u,e`Xljt@9&`ETPGz:`+8T?LTGdb|(F+Zgf&J)M85n]' );
define( 'NONCE_KEY',        '!;ph)>;bR/oU0t^2u{N-*-71=yo6i{#U},3m19We*@O wA`$L5+}1)T6-)v9|z.W' );
define( 'AUTH_SALT',        '453aELr%mZT)l4HkvnL>pk92w|*I1)H!{+A|A`nCO+RP2+u&jdr]bn^GM6w>Kj)o' );
define( 'SECURE_AUTH_SALT', 'c u4RIs_IIDY%cv/!?*hXHYimtZl;0W9&$qjI<$;Ct$to2 !V8-zAKs#AaY| G`^' );
define( 'LOGGED_IN_SALT',   'r [^];D,vbrcYq),MRwZEDtF5htm&r9 [5NmO$BpD6<1j{2]w[NQ--YI#U$1n0Nc' );
define( 'NONCE_SALT',       'KW>7i>pt2]foBs{t}kmLFZHX+;88+51OOy<qP-L#!(b_}q>}mC3f>+rW9;kH6guo' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'mvc_';

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
