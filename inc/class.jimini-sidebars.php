<?php
/**
 * Jimini Sidebars
 *
 * Everything happening in the widgets and other sidebar areas.
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
 * Class JiminiSidebars
 */
class JiminiSidebars {

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
	 * @return null|JiminiSidebars
	 */
	public static function create_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Init
	 */
	function init() {

		// Add extra body classes.
		add_filter( 'body_class', array(
			$this,
			'extra_body_classes',
		) );

		// Add sidebar toggles at start and end of the content content.
		add_action( 'jimini_content_wrapper_start', array(
			$this,
			'sidebar_toggle',
		) );
		add_action( 'jimini_content_wrapper_end', array(
			$this,
			'sidebar_toggle',
		) );
	}

	/**
	 * Extra Body Classes
	 *
	 * @package Jimini
	 * @since 0.1
	 *
	 * @see JiminiSidebars::active_widgets()
	 *
	 * @param array $classes from the current body classes.
	 *
	 * @return array
	 */
	function extra_body_classes( $classes ) {
		if ( ! JiminiSidebars::active_widgets() ) {
			$classes[] = 'no-active-widgets';
		}

		return $classes;
	}

	/**
	 * Active Widgets
	 *
	 * @package Jimini
	 * @since 0.1
	 *
	 * @see is_active_sidebar()
	 *
	 * @return bool true if either of the sidebars are in use, false otherwise.
	 */
	static function active_widgets() {
		// Sanity check - do we have any active widgets in the "sidebar".
		if ( is_active_sidebar( 'first-widget' ) || is_active_sidebar( 'second-widget' ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Sidebar Toggle
	 *
	 * Create an anchor link for the `sidebar-toggle.js` script to use when
	 * there are active widgets in the sidebar.
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see JiminiSidebars::active_widgets()
	 */
	static function sidebar_toggle() {
		if ( self::active_widgets() ) { ?>
			<div class="sidebar-toggle-tab">
				<a class="toggle-clicker" href="#"><span class="dashicons dashicons-download"></span></a>
			</div><!-- sidebar-toggle-tab -->
		<?php }
	}
}

/** Instantiate and initialize the class. */
$jimini_sidebars = JiminiSidebars::create_instance();
$jimini_sidebars->init();
