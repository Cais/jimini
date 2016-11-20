<?php
/**
 * Jimini Widgets
 *
 * The base widgets template file.
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
 * Jimini Widgets
 *
 * @package Jimini
 * @since   0.1
 *
 * @see     register_sidebar()
 * @see     __()
 */
function jimini_widgets() {
	/**
	 * To override this function in a Child-Theme:
	 * - remove action hook (see functions.php call to `widget_init` action)
	 * - write your widget definition function
	 * - add your function to a new call on the `widget_init` action hook
	 */

	register_sidebar(
		array(
			'name'        => __( 'First Widget Area', 'jimini' ),
			'id'          => 'first-widget',
			'description' => __( 'This widget area will display at the top of the left sidebar area.', 'jimini' ),
		)
	);

	register_sidebar(
		array(
			'name'        => __( 'Second Widget Area', 'jimini' ),
			'id'          => 'second-widget',
			'description' => __( 'This widget area will display at the bottom of the left sidebar area.', 'jimini' ),
		)
	);
}

add_action( 'widgets_init', 'jimini_widgets' );
