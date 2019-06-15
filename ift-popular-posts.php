<?php
/**
 * Plugin Name: Easy Popular Posts
 * Plugin URI:  https://github.com/iftee/ift-popular-posts
 * Description: Display popular posts in sidebar with an easy to configure options
 * Version:     1.0.0
 * Author:      Iftakhar Hasan
 * Author URI:  https://github.com/iftee
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ift-popular-posts
 * Domain Path: /languages
 */

namespace ift\epp;

/* Stops direct visit */
if( ! defined( 'ABSPATH' ) ) {
  exit( 'Go away!' );
}

/* Includes functions */
define( 'EPP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
require_once EPP_PLUGIN_PATH . 'inc/helper-functions.php';
require_once EPP_PLUGIN_PATH . 'inc/wordpress-widget.php';

/* Gets and sets hit count */
function easy_popular_post( $post_id ) {
  $count_key = 'hit_count';
	$count = get_post_meta( $post_id, $count_key, true );
	if ($count == '') {
    $count = 0;
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, '0' );
	} else {
		$count++;
		update_post_meta( $post_id, $count_key, $count );
	}
}

/* Adjusts hit count on single post load */
function easy_track_post( $post_id ) {
	if ( ! is_single() ) return;
	if ( empty( $post_id ) ) {
		global $post;
		$post_id = $post->ID;
	}
	easy_popular_post( $post_id );
}
add_action( 'wp_head', __NAMESPACE__.'\easy_track_post' );