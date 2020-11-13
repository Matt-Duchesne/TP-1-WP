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
define( 'DB_NAME', 'web' );

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
define( 'AUTH_KEY',         '+fY,-+QUeZ_aI+tm:}TRRqGTbb)Oq[>|!mPOQx`]tV&?] %jTkH!PfY95hZlnxMM' );
define( 'SECURE_AUTH_KEY',  'ZNTlO*Btm8ai<[V/7ZRlLs6=$?H=T<lD?9)j[[?t0y9aK!3i94c4pl`3W9,o(-{R' );
define( 'LOGGED_IN_KEY',    'u=|)9l1r~B3*v#bhg:8y#wc7k4?L$seDd0$>8+_c+h=3?2ccO,G;j`4IYiQj[0En' );
define( 'NONCE_KEY',        'r)F@r0C7,]b$Dc/waG9r~We%4E}{Dxp[w%iBv28Us{j}pN9)T#SVXvFQZszW.@3*' );
define( 'AUTH_SALT',        '~B lC;0KYfnp-at?6TcZ4v_d*cwQchp0:&_av,Ym9!1(UpZdp+u%JrXoJP(7/T5J' );
define( 'SECURE_AUTH_SALT', 'LCR(my&zqyL?P{kQH&;B0T2UEH>d]R70i+FqhV2K2IX`|Fm6nZr>430SZw*ewqF5' );
define( 'LOGGED_IN_SALT',   '2Jh4B]_LwzKrf2oNSLx=VQT`>djY[3((+!}Dsaxt<d$yT-N}5O<n_p!FjBk(@}r7' );
define( 'NONCE_SALT',       'BqmdUZc~1OI&qSnA<i`7K|v|Z1VVqXf6wD BuAW^QP:PFcv&|.1c^~RoglR*|qfR' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'w_';

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
