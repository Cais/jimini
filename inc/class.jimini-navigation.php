<?php
/**
 * Jimini Navigation class
 *
 * @package   Jimini
 * @since     0.1
 *
 * @author    Edward Caissie <edward.caissie@gmail.com>
 * @copyright Copyright 2017, Edward Caissie
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

	/**
	 * Post to Post Navigation
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     previous_post_link()
	 * @see     next_post_link()
	 */
	function post_to_post_navigation() {

		$newer_nav_symbol = '<span class="dashicons dashicons-arrow-left-alt2"></span>';
		$older_nav_symbol = '<span class="dashicons dashicons-arrow-right-alt2"></span>';
		?>

		<!-- Add some navigation controls between post pages -->
		<div class="pagination for-posts-to-posts">
			<hr class="pre-post-link-navigation" />
			<p class="navigation post-link cf">
				<span class="right"><?php next_post_link( '%link' . $older_nav_symbol ); ?></span>
				<span class="left"><?php previous_post_link( $newer_nav_symbol . '%link' ); ?></span>
			</p>
		</div><!-- pagination for-posts-to-posts -->

	<?php }

	/**
	 * Post to Post Navigation via Categories
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     next_post_link()
	 * @see     previous_post_link()
	 */
	function post_to_post_navigation_via_categories() {

		$newer_nav_symbol   = '<span class="dashicons dashicons-arrow-left-alt2"></span>';
		$older_nav_symbol   = '<span class="dashicons dashicons-arrow-right-alt2"></span>';
		?>

		<!-- Add some navigation controls between post pages -->
		<div class="pagination for-posts-to-posts-via-categories">
			<hr class="pre-post-link-navigation" />
			<p class="navigation post-link cf">
				<span class="right"><?php next_post_link( '%link' . $older_nav_symbol, '%title', 'true', '', 'category' ); ?></span>
				<span class="left"><?php previous_post_link( $newer_nav_symbol . '%link', '%title', 'true', '', 'category' ); ?></span>
			</p>
		</div><!-- pagination for-posts-to-posts-via-categories -->

	<?php }

	/**
	 * Post to Post Navigation via Tags
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     next_post_link()
	 * @see     previous_post_link()
	 */
	function post_to_post_navigation_via_tags() {

		$newer_nav_symbol   = '<span class="dashicons dashicons-arrow-left-alt2"></span>';
		$older_nav_symbol   = '<span class="dashicons dashicons-arrow-right-alt2"></span>';
		?>

		<!-- Add some navigation controls between post pages -->
		<div class="pagination for-posts-to-posts-via-tags">
			<hr class="pre-post-link-navigation" />
			<p class="navigation post-link cf">
				<span class="right"><?php next_post_link( '%link' . $older_nav_symbol, '%title', 'true', '', 'post_tag' ); ?></span>
				<span class="left"><?php previous_post_link( $newer_nav_symbol . '%link', '%title', 'true', '', 'post_tag' ); ?></span>
			</p>
		</div><!-- pagination for-posts-to-posts-via-tags -->

	<?php }
}
