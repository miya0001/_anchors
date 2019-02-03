<?php
/**
 * Plugin Name:     _anchors
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     _anchors
 * Domain Path:     /languages
 * Version:         nightly
 *
 * @package         _anchors
 */

namespace _anchors;

use Miya\WP\GH_Auto_Updater;
use \Miya\WP\Custom_Field;

// Autoload
require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );

add_action( 'init', '_anchors\activate_autoupdate' );

function activate_autoupdate() {
	$plugin_slug = plugin_basename( __FILE__ );
	$gh_user = 'miya0001';
	$gh_repo = '_anchors';

	// Activate automatic update.
	new GH_Auto_Updater( $plugin_slug, $gh_user, $gh_repo );
}

add_action( 'wp_enqueue_scripts', function() {
	if ( is_singular() && "1" === get_post_meta( get_the_ID(), '_anchor_links', true ) ) {
		wp_enqueue_script(
			'anchors',
			plugins_url( 'js/_anchors.js', __FILE__ ),
			array(),
			filemtime( dirname( __FILE__ ) . '/js/_anchors.js' ),
			true
		);

		wp_enqueue_style(
			'anchors',
			plugins_url( 'css/_anchors.css', __FILE__ ),
			array(),
			filemtime( dirname( __FILE__ ) . '/css/_anchors.css' )
		);
	}
} );

class _Anchors extends Custom_Field
{
	/**
	 * Displays the form for the metabox. The nonce will be added automatically.
	 *
	 * @param object $post The object of the post.
	 * @param array $args The argumets passed from `add_meta_box()`.
	 * @return none
	 */
	public function form( $post, $args )
	{
		?>
		<label>
		<?php if ( "1" === get_post_meta( get_the_ID(), '_anchor_links', true ) ): ?>
			<input type="checkbox" name="_anchor_links" value="1" checked>
		<?php else: ?>
			<input type="checkbox" name="_anchor_links" value="1">
		<?php endif; ?>
		Display anchor links</label>
		<?php
	}

	/**
	 * Save the metadata from the `form()`. The nonce will be verified automatically.
	 *
	 * @param int $post_id The ID of the post.
	 * @return none
	 */
	public function save( $post_id )
	{
		if ( ! empty( $_POST['_anchor_links'] ) ) {
			update_post_meta( $post_id, '_anchor_links', "1" );
		} else {
			update_post_meta( $post_id, '_anchor_links', "0" );
		}
	}
}

$text_field = new _Anchors( '_anchors', 'Anchor Links', array( 'context' => 'side' ) );
$text_field->add( array( 'post', 'page' ) );
