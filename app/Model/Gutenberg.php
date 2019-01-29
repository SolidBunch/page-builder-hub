<?php
namespace PBH\Model;

use PBH\Helper\Utils;
use PBH\Model\Abstracts\AddonAbstract;

/**
 * Gutenberg addon model
 *
 * @category   Wordpress
 * @package    Page Builder Hub
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      Class available since Release 1.0.0
 */

class Gutenberg extends AddonAbstract {

	/**
	 * Constructor.
	 *
	 */
	public function __construct() {
		parent::__construct();

		add_action( 'init', [ $this, 'register_block_type' ] );
	}

	public function init() {

		load_plugin_textdomain( 'pbh-blocks-'.$this->slug, false, $this->dir . '/languages' );

		// ---------------------------------------------------------------------------------
		// Editor Scripts
		// ---------------------------------------------------------------------------------
		$this->register_script(
			'pbh-blocks-'.$this->slug.'-editor', // Handle
			$this->url . '/assets/js/block.build.min.js',
			[ 'wp-editor', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components' ],
			filemtime( $this->dir . '/assets/js/block.build.min.js' ),
			true
		);

		// ---------------------------------------------------------------------------------
		// Front Scripts ( enqueued at both : front and back )
		// ---------------------------------------------------------------------------------
		$this->register_script(
			'pbh-blocks-'.$this->slug.'-editor', // Handle
			$this->url . '/assets/js/block.build.min.js',
			[ 'wp-editor', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components' ],
			filemtime( $this->dir . '/assets/js/block.build.min.js' ),
			true
		);

		// ---------------------------------------------------------------------------------
		// Editor Styles
		// ---------------------------------------------------------------------------------
		$this->register_style(
			'pbh-blocks-'.$this->slug.'-editor',
			$this->url . '/assets/css/block-editor.min.css',
			[ 'wp-edit-blocks' ],
			filemtime( $this->dir . '/assets/css/block-editor.min.css' )
		);

		// ---------------------------------------------------------------------------------
		// Front Styles ( enqueued at both : front and back )
		// ---------------------------------------------------------------------------------
		$this->register_style(
			'pbh-blocks-'.$this->slug.'-front',
			$this->url . '/assets/css/block-style.min.css',
			[],
			filemtime( $this->dir . '/assets/css/block-style.min.css' )
		);

		// ---------------------------------------------------------------------------------
		// TRANSLATION ( since WP 5.0 )
		// May be extended to wp_set_script_translations( 'my-handle', 'my-domain', plugin_dir_path( MY_PLUGIN ) . 'languages' ) ).
		// For details see * https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
		// ---------------------------------------------------------------------------------
		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'pbh-blocks-'.$this->slug.'-editor', 'pbh-blocks-'.$this->slug );
		}
	}

	/**
	 * Register Block Type
	 */
	public function register_block_type()
	{
		register_block_type( 'pbh-blocks/'.$this->slug, [
			'editor_script' => 'pbh-blocks-'.$this->slug.'-editor', // backend only
			'editor_style'  => 'pbh-blocks-'.$this->slug.'-editor', // backend only
			'style'         => 'pbh-blocks-'.$this->slug.'-front',  // backend + frontend
			'script'        => 'pbh-blocks-'.$this->slug.'-front',  // backend + frontend
		] );
	}

}