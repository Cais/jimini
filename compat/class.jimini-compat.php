<?php
/**
 * Jimini Compatibility class
 *
 * Sometimes you have to look behind the curtain ...
 *
 * @package   Jimini
 * @since     0.1
 *
 * @author    Edward Caissie <edward.caissie@gmail.com>
 * @copyright Copyright 2016, Edward Caissie
 *
 * This file is part of Jimini.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2, as published by the
 * Free Software Foundation.
 *
 * You may NOT assume that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to:
 *
 *      Free Software Foundation, Inc.
 *      51 Franklin St, Fifth Floor
 *      Boston, MA  02110-1301  USA
 *
 * The license for this software can also likely be found here:
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Class JiminiCompat
 */
class JiminiCompat {

	/**
	 * Class instance.
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @var null $instance
	 */
	private static $instance = null;

	/**
	 * Create Instance
	 *
	 * Creates a single instance of the class
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @return null|JiminiCompat
	 */
	public static function create_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * JiminiCompat constructor.
	 *
	 * @package Jimini
	 * @since   0.1
	 */
	function __construct() {
	}

	/**
	 * Check whether a plugin is active.
	 *
	 * Only plugins installed in the /plugins/ folder can be active.
	 *
	 * Plugins in the /mu-plugins/ folder cannot be "activated"; this function
	 * will return false for those plugins.
	 *
	 * Borrowed from the WordPress Plugin Administration API
	 *
	 * @link    ../wp-admin/includes/plugin.php
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     get_option()
	 * @see     JiminiCompat::is_plugin_active_for_network()
	 *
	 * @param string $plugin Base plugin path from plugins directory.
	 *
	 * @return bool True, if in the active plugins list. False, not in the list.
	 */
	static public function is_plugin_active( $plugin ) {
		return in_array( $plugin, (array) get_option( 'active_plugins', array() ), true ) || self::is_plugin_active_for_network( $plugin );
	}

	/**
	 * Check whether the plugin is active for the entire network.
	 *
	 * Only plugins installed in the /plugins/ folder can be active.
	 *
	 * Plugins in the /mu-plugins/ folder cannot be "activated"; this function
	 * will return false for those plugins.
	 *
	 * Borrowed from the WordPress Plugin Administration API
	 *
	 * @link    ../wp-admin/includes/plugin.php
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     is_multisite()
	 * @see     get_site_option()
	 *
	 * @param string $plugin Base plugin path from plugins directory.
	 *
	 * @return bool True, if active for the network, otherwise false.
	 */
	static private function is_plugin_active_for_network( $plugin ) {
		if ( ! is_multisite() ) {
			return false;
		}

		$plugins = get_site_option( 'active_sitewide_plugins' );
		if ( isset( $plugins[ $plugin ] ) ) {
			return true;
		}

		return false;
	}


	/**
	 * Initialize class
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     JiminiCompat::bns_login_compatibility()
	 * @see     add_action()
	 */
	function init() {
		// Plugin: BNS Login.
		$this->bns_login_compatibility();
		add_action( 'wp_enqueue_scripts', array(
			$this,
			'bns_login_compatibility_styles',
		) );

		// Plugin: NextGEN Gallery.
		add_action( 'wp_enqueue_scripts', array(
			$this,
			'nextgen_gallery_compatibility',
		) );

		// Plugin: BNS Featured Category.
		add_action( 'wp_enqueue_scripts', array(
			$this,
			'bns_featured_category_compatibility',
		) );

		// Plugin: WooCommerce.
		add_action( 'wp_enqueue_scripts', array(
			$this,
			'woocommerce_compatibility_styles',
		) );
	}

	/**
	 * BNS Login Compatibility
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     JiminiCompat::is_plugin_active()
	 * @see     add_filter()
	 * @see     remove_action()
	 * @see     add_action()
	 */
	function bns_login_compatibility() {

		if ( $this->is_plugin_active( 'bns-login/bns-login.php' ) ) {
			// Change BNS Login to use dashicons.
			add_filter( 'bns_login_dashed_set', '__return_true' );

			/*
			 * Move BNS Login to under post navigation by first removing the
			 * action call to `wp_footer` and then adding the action call to
			 * `jimini_content_without_sidebar_end` hook.
			 */
			global $bns_login;
			remove_action( 'wp_footer', array(
				$bns_login,
				'bns_login_output',
			) );
			add_action( 'jimini_content_without_sidebar_end', array(
				$bns_login,
				'bns_login_output',
			) );
		}

	}

	/**
	 * BNS Login Compatibility Styles
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     wp_enqueue_style()
	 * @see     JiminiRouter::path_uri()
	 * @see     jimini_version()
	 */
	function bns_login_compatibility_styles() {
		// Add BNS Login custom style.
		wp_enqueue_style( 'jimini-bns-login-styles', JiminiRouter::path_uri( 'compat' ) . 'bns-login.css', array(), jimini_version(), 'screen' );
	}

	/**
	 * NextGEN Gallery Compatibility
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     JiminiCompat::is_plugin_active()
	 * @see     wp_enqueue_style()
	 * @see     JiminiRouter::path_uri()
	 * @see     jimini_version()
	 */
	function nextgen_gallery_compatibility() {

		if ( $this->is_plugin_active( 'nextgen-gallery/nggallery.php' ) ) {
			// Enqueue NextGEN Gallery custom styles.
			wp_enqueue_style( 'jimini-ngg-styles', JiminiRouter::path_uri( 'compat' ) . 'nextgen-gallery.css', array(), jimini_version(), 'screen' );
		}
	}

	/**
	 * BNS Featured Category Compatibility
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     JiminiCompat::is_plugin_active()
	 * @see     wp_enqueue_style()
	 * @see     JiminiRouter::path_uri()
	 * @see     jimini_version()
	 */
	function bns_featured_category_compatibility() {

		if ( $this->is_plugin_active( 'bns-featured-category/bns-featured-category.php' ) ) {
			// Enqueue BNS Featured Category custom styles.
			wp_enqueue_style( 'jimini-bnsfc-style', JiminiRouter::path_uri( 'compat' ) . 'bns-featured-category.css', array(), jimini_version(), 'screen' );
		}
	}

	/**
	 * WooCommerce Compatibility Styles
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     JiminiCompat::is_plugin_active()
	 * @see     wp_enqueue_style()
	 * @see     JiminiRouter::path_uri()
	 * @see     jimini_version()
	 */
	function woocommerce_compatibility_styles() {
		if ( $this->is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			// Enqueue WooCommerce custom styles.
			wp_enqueue_style( 'jimini-woocommerce-style', JiminiRouter::path_uri( 'compat' ) . 'woocommerce.css', array(), jimini_version(), 'screen' );
		}

	}

	/**
	 * WooCommerce Loop
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     JiminiCompat::is_plugin_active()
	 * @see     woocommerce_content()
	 */
	static function woocommerce_loop() {
		if ( self::is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			woocommerce_content();
		}
	}
}

// Instantiate and initialize the class.
$jimini_compat = JiminiCompat::create_instance();
$jimini_compat->init();
