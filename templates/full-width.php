<?php
/**
 * Template Name: Full-width Layout
 * Template Post Type: post, page
 *
 * Full width template for posts and pages that triggers the mobile view script
 * to close the left-sidebar by default.
 *
 * @package   Jimini
 * @version   0.1
 *
 * @author    Edward Caissie <edward.caissie@gmail.com>
 * @copyright Copyright 2016, Edward Caissie
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
 * Enqueue full width layout (aka mobile) script
 *
 * @package Jimini
 * @since   0.1
 *
 * @see     JiminiRouter::path_uri()
 * @see     wp_enqueue_script()
 * @see     jimini_version()
 */
function jimini_full_width_script() {

	// Create a router instance.
	$router = JiminiRouter::create_instance();

	wp_enqueue_script( 'jimini-mobile', $router->path_uri( 'js' ) . 'mobile.js', array( 'jquery' ), jimini_version() );

}

add_action( 'wp_enqueue_scripts', 'jimini_full_width_script' );

// After triggering the mobile script use the default `index.php` template.
get_template_part( 'index' );
