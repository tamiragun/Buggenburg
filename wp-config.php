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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'L9wp`zrcN_[Tbe,ss.9(B(Rg{duorPhmQJ8(2*kJfq%T@c;effJC3mu@i[)Ke&!a' );
define( 'SECURE_AUTH_KEY',  'gZNXxIZ`:/`Pp/J>7=b<b%py|D`5pl$,:SJwJm!LwFeH:DPp`an^AG|1{;.FpeZ-' );
define( 'LOGGED_IN_KEY',    '%2}-,)},2(Vc5oDsb!v{.nm~1QZt|e&jeUj0IVGno93bbfm|,v7??ZO1K`$dgoec' );
define( 'NONCE_KEY',        '@&#A-;j}S:?jk2g![qG)~[mwp]#l[9bLQb;Ig)zzX??6T U/{==WE/z31=JEM<[8' );
define( 'AUTH_SALT',        '=c`!wCbo}j<6Y$,r2U@kQ5qIBP5jDv;TMt[[?i}ggnX>,QY~A4P??|Ij,gY9Lj*~' );
define( 'SECURE_AUTH_SALT', 'VB}4~fW%$/5KVULX!zRa3}6p(AZvw`$;?5z+CQ(92.opv:?=#PjZEmYj1qB`d*HI' );
define( 'LOGGED_IN_SALT',   'o#,Z6I*UkN~<nt{=M17B&<Q|O{g8vA[*N>)E&ub9?4Zi:Af39B1]J}Vyd:#JOOq@' );
define( 'NONCE_SALT',       'zW*$%Y{4Jb6>{%s<r 4+DX4u_+/H.;&2H3awPoqu}AWR|ib<5n8S<YipMf|)3w4k' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
