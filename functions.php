<?php
/**
 * Functions
 *
 * Where the jumping jellybeans comes to play ...
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
 * Theme Setup
 *
 * @package Jimini
 * @since   0.1
 *
 * @see     locate_template()
 * @see     load_theme_textdomain()
 * @see     add_theme_support()
 * @see     register_nav_menus()
 * @see     __()
 * @see     JiminiCompat::is_plugin_active()
 */
function jimini_setup() {
	// Fire things up with some the essential classes, widgets, etc.
	locate_template( 'jimini-ignite.php', true, true );

	// Make theme available for translation.
	load_theme_textdomain( 'jimini' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Add post thumbnail support.
	add_theme_support( 'post-thumbnails' );

	// Add WordPress HTML5 markup support.
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'caption',
		'gallery',
		'widgets',
	) );

	// Add custom menu support.
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'jimini' ),
		)
	);

	// Add WooCommerce support.
	if ( JiminiCompat::is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		add_theme_support( 'woocommerce' );
	}

}

add_action( 'after_setup_theme', 'jimini_setup' );

/**
 * Version
 *
 * Return the current theme version.
 *
 * @package Jimini
 * @since   0.1
 *
 * @see     wp_get_theme()
 *
 * @return false|string
 */
function jimini_version() {
	return wp_get_theme()->get( 'Version' );
}

/**
 * Enqueue theme style sheets
 *
 * @package Jimini
 * @since   0.1
 *
 * @see     wp_enqueue_style()
 * @see     get_stylesheet_uri()
 * @see     jimini_version()
 * @see     JiminiRouter::path_uri()
 * @see     wp_enqueue_script()
 * @see     is_singular()
 */
function jimini_scripts_and_styles() {

	// Create a router instance.
	$router = JiminiRouter::create_instance();

	// Jimini styles.
	wp_enqueue_style( 'jimini-style', get_stylesheet_uri(), array(), jimini_version(), 'screen' );
	wp_enqueue_style( 'jimini-layout-left-sidebar', $router->path_uri( 'css' ) . 'layout-left-sidebar.css', array(), jimini_version(), 'screen' );
	wp_enqueue_style( 'jimini-custom', $router->path_uri( 'css' ) . 'custom.css', array(), jimini_version(), 'screen' );
	// Temporary "work-in-progress" stylesheet.
	// @todo remove before release.
	wp_enqueue_style( 'jimini-wip', $router->path_uri( 'wip' ) . 'wip.css', array(), jimini_version(), 'screen' );

	// Jimini scripts.
	wp_enqueue_script( 'jimini-sidebar-toggle', $router->path_uri( 'js' ) . 'sidebar-toggle.js', array( 'jquery' ), jimini_version() );

	// Mobile scripts and styles.
	if ( wp_is_mobile() ) {
		wp_enqueue_style( 'jimini-mobile', $router->path_uri( 'css' ) . 'mobile.css', array(), jimini_version(), 'screen' );
		wp_enqueue_script( 'jimini-mobile', $router->path_uri( 'js' ) . 'mobile.js', array( 'jquery' ), jimini_version() );
	}

	/*
	 * Enqueue Jimini Comment Tabs which will enqueue jQuery, jQuery UI Core,
	 * jQuery UI Widget, and jQuery UI Tabs as dependencies.
	 */
	if ( is_singular() ) {
		wp_enqueue_script(
			'jimini-comment-tabs', $router->path_uri( 'js' ) . 'comment-tabs.js', array(
			'jquery',
			'jquery-ui-core',
			'jquery-ui-widget',
			'jquery-ui-tabs',
		), jimini_version(), true );
	}

}

add_action( 'wp_enqueue_scripts', 'jimini_scripts_and_styles' );

/**
 * Jimini Content Width
 *
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 * Set content width to 1000 - an arbitrary number?!
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @package Jimini
 * @since   0.1
 *
 * @global int $content_width rendered in pixels.
 *
 * @see     apply_filters()
 */
function jimini_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'jimini_content_width', 1000 );
}

add_action( 'after_setup_theme', 'jimini_content_width', 0 );

/**
 * Jimini Search form
 *
 * Change HTML5 default search form label text ("Search for:") in
 * ../wp-includes/general-template.php to an open eye.
 *
 * @package Jimini
 * @since   0.1
 *
 * @see     esc_url()
 * @see     home_url()
 * @see     esc_html_x()
 * @see     get_search_query()
 *
 * @return string
 */
function jimini_search_form() {

	$form = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
				<label>
					<span class="dashicons dashicons-visibility"></span>
					<input type="search" class="search-field" placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder', 'jimini' ) . '" value="' . get_search_query() . '" name="s" />
				</label>
				<input type="submit" class="search-submit" value="' . esc_attr_x( 'Search', 'submit button', 'jimini' ) . '" />
			</form>';

	return $form;

}

add_filter( 'get_search_form', 'jimini_search_form' );

/**
 * Jimini No Active Widgets
 *
 * Adjust layout and remove sidebar toggle if there are no active widgets.
 *
 * @package Jimini
 * @since   0.1
 *
 * @see     JiminiSidebars::active_widgets()
 * @see     wp_dequeue_style()
 * @see     wp_dequeue_script()
 */
function jimini_no_active_widgets() {
	if ( ! JiminiSidebars::active_widgets() ) {
		wp_dequeue_style( 'jimini-layout-left-sidebar' );
		wp_dequeue_script( 'jimini-sidebar-toggle' );
	}
}

add_action( 'wp_enqueue_scripts', 'jimini_no_active_widgets' );

/**
 * Nada
 *
 * A meaningless function to accomplish nothing.
 * Just a meaningless additional comment.
 *
 * @return null
 */
function jimini_nada() {
	return null;
}
