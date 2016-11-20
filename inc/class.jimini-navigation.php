<?php
/**
 * Jimini Navigation class
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
 * Class JiminiNavigation
 */
class JiminiNavigation {

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
	 * @return null|JiminiNavigation
	 */
	public static function create_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Menu
	 *
	 * Navigation menu
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @param   string|array $menu_args to change menu by passing new arguments.
	 *
	 * @see     wp_parse_args()
	 * @see     wp_nav_menu()
	 */
	function menu( $menu_args = '' ) {

		$defaults  = array(
			'theme_location' => 'primary',
			'menu_class'     => 'nav-menu',
			'fallback_cb'    => array( $this, 'list_pages' ),
		);
		$menu_args = wp_parse_args( (array) $defaults, $menu_args );

		wp_nav_menu( $menu_args );

	}

	/**
	 * List Pages
	 *
	 * Callback function for the wp_nav_menu call; accepts wp_nav_menu arguments
	 * passed through the callback function.
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @param   string|array $menu_args to change list by passing new arguments.
	 *
	 * @see     wp_parse_args()
	 * @see     wp_list_pages()
	 */
	function list_pages( $menu_args ) {

		$defaults       = array(
			'title_li' => '',
		);
		$page_menu_args = wp_parse_args( (array) $defaults, $menu_args );

		echo '<ul class="nav-menu">';

		wp_list_pages( $page_menu_args );

		echo '</ul><!-- .nav-menu -->';

	}

	/**
	 * Comments Navigation
	 *
	 * Displays a link between pages of comments
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     previous_comments_link()
	 * @see     next_comments_link()
	 */
	function comments_navigation() {
		?>

		<p class="navigation comment-link cf">
			<span class="left"><?php previous_comments_link() ?></span>
			<span class="right"><?php next_comments_link() ?></span>
		</p>

		<?php

	}

	/**
	 * Link Pages
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     wp_link_pages()
	 */
	function link_pages() {
		?>
		<div class="link-pages-post cf">
			<?php wp_link_pages(); ?>
		</div>
		<?php
	}
}
