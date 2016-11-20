<?php
/**
 * Jimini Primus Router
 *
 * Defines the theme path structures
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
 * Class JiminiRouter
 */
class JiminiRouter {

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
	 * @return null|JiminiRouter
	 */
	public static function create_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Constructor
	 *
	 * @package Jimini
	 * @since   0.1
	 */
	function __construct() {
	}

	/**
	 * Path
	 *
	 * Retrieves the absolute path to the directory of the current theme
	 * appended with the folder and trailing slash
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     get_template_directory()
	 *
	 * @param string $string URL segment.
	 *
	 * @return string
	 */
	static function path( $string ) {
		return get_template_directory() . '/' . $string . '/';
	}

	/**
	 * Path URI
	 *
	 * Retrieve template directory URI for the current theme appended with the
	 * folder and trailing slash
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     get_template_directory_uri()
	 *
	 * @param string $string URL segment.
	 *
	 * @return string
	 */
	static function path_uri( $string ) {
		return get_template_directory_uri() . '/' . $string . '/';
	}

	/**
	 * Child Path
	 *
	 * Retrieves the absolute path to the directory of the current child-theme
	 * appended with the folder and trailing slash
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     get_stylesheet_directory()
	 *
	 * @param string $string URL segment.
	 *
	 * @return string
	 */
	static function child_path( $string ) {
		return get_stylesheet_directory() . '/' . $string . '/';
	}

	/**
	 * Child Path URI
	 *
	 * Retrieve template directory URI for the current child-theme appended with
	 * the folder and trailing slash
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     get_stylesheet_directory_uri()
	 *
	 * @param string $string URL segment.
	 *
	 * @return string
	 */
	static function child_path_uri( $string ) {
		return get_stylesheet_directory_uri() . '/' . $string . '/';
	}
}
