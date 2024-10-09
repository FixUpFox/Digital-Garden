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
define( 'DB_NAME', 'db.sqlite' );

/** Database username */
define( 'DB_USER', '' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', '' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',         '-l13*e&lI)#tZKLfJY`9sEY^l{w8/2Bt[?YX:Jj}?GJ?&xwO1bx^`?L*4fFSA,,/' );
define( 'SECURE_AUTH_KEY',  '*x`ZFsr&42`mr2.iJH/2tu<s1_{AZW_NBl/#r@mg)@.eSmPzTG&R5&Q4Tr8T%;PN' );
define( 'LOGGED_IN_KEY',    '~o-WBgi<47~N$xVt`VoXM}>u.7t.7ZzaC!X]xbVnk#]>2iV*$;+Lu3drf%Wz4>l{' );
define( 'NONCE_KEY',        'Hc$lZ@_cKjKXE98Cg_QC}7f0p!xrT)W]!wx?(-TdZHx@UPEw`rZ;u^um@.8s+XEH' );
define( 'AUTH_SALT',        'm4<+R*-m#!O?IcK!sR>Gjb2YN3Fy[,1[s@~p^zl3B~*M@wxQM@jnfiP9Xsm0.|{x' );
define( 'SECURE_AUTH_SALT', 'f(Vfmg>QBH7awbf@`RuU`[uL/zq2;NuJqWDCs7]k:422QWk+hb[HTz~*@b2reFH)' );
define( 'LOGGED_IN_SALT',   'SOqF2t90_(8+0d5]v_Dgp3_;3H]wv%y,+i@c2d_4GYnRC?b?FH6]8xEFCUgytqFK' );
define( 'NONCE_SALT',       'y2),P#W+s3i)feG!bE(w:&v89P@IaSXOEY*s5?4s1^`]9V6#XYpcGWs4[?FUu%-W' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

define( 'DB_DIR', __DIR__ . '/data' );
define( 'DB_FILE', 'db.sqlite' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
