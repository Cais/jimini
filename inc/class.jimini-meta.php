<?php
/**
 * Jimini Meta class
 *
 * The meta data elements used in the Jimini theme.
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
 * Class JiminiMeta
 */
class JiminiMeta {

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
	 * @return null|JiminiMeta
	 */
	public static function create_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Categories
	 *
	 * Displays the categories list wrapped prepended with a filterable symbol.
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     apply_filters()
	 * @see     get_the_category_list()
	 * @see     comments_open()
	 * @see     get_comments_number()
	 * @see     get_the_tag_list()
	 * @see     is_singular()
	 * @see     is_page()
	 *
	 * @return string|null
	 */
	function categories() {

		/**
		 * Default is to display the post categories; use the following,
		 * qualified as needed, to not display the post categories:
		 * - add_filter( 'jimini_display_post_categories', '__return_false' );
		 */
		$echo = apply_filters( 'jimini_display_post_categories', true );

		if ( $echo ) {
			$categories_symbol = '<span class="dashicons dashicons-category"></span>';
			$categories_symbol = apply_filters( 'jimini_categories_symbol', $categories_symbol );
			$categories        = get_the_category_list( ' | ' );

			// Sanity check: requires tests for categories ... and comments!
			if ( ( comments_open() || 0 < get_comments_number() ) || get_the_tag_list() ) {
				/*
				 * Wrap the categories in a span for styling then concatenate with
				 * the categories symbol before returning the data.
				 */
				$displayed_categories = '<span class="post-meta-categories">' . $categories . '</span>';
				$output               = $categories_symbol . $displayed_categories;

			} else if ( ! comments_open() && 0 <= get_comments_number() ) {

				$displayed_categories = '<span class="post-meta-categories no-comments">' . $categories . '</span>';
				$output               = $categories_symbol . $displayed_categories;

			} else {

				$output = '';

			}

			// Use same HTML containers in singular views as those without comments.
			if ( comments_open() && 0 <= get_comments_number() && is_singular() && ! get_the_tag_list() ) {
				$displayed_categories = '<span class="post-meta-categories no-comments">' . $categories . '</span>';
				$output               = $categories_symbol . $displayed_categories;
			}

			// Sanity Check: no categories on pages.
			if ( is_page() ) {
				$output = '';
			}

			return $output;
		} else {
			return null;
		}
	}

	/**
	 * Tags
	 *
	 * Displays the tag list prepended with a filterable symbol.
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     get_the_tag_list()
	 * @see     apply_filters()
	 * @see     comments_open()
	 * @see     get_comments_number()
	 * @see     is_singular()
	 *
	 * @return string|null
	 */
	function tags() {

		/**
		 * Default is to display the post tags; use the following, qualified
		 * as needed, to not display the post tags:
		 * - add_filter( 'jimini_display_post_tags', '__return_false' );
		 */
		$echo = apply_filters( 'jimini_display_post_tags', true );

		if ( $echo ) {
			// If there are no tags, return early.
			if ( ! get_the_tag_list() ) {
				return null;
			}

			$tags_symbol = '<span class="dashicons dashicons-tag"></span>';
			$tags_symbol = apply_filters( 'jimini_tags_symbol', $tags_symbol );
			$tags        = '<span class="post-meta-tags">' . get_the_tag_list( $tags_symbol, ' | ' ) . '</span>';

			/*
			 * Sanity check for comments:
			 * If there are tags and the post has comments then return $tags as is.
			 * If there are tags but no comments add `no-comments` class to adjust
			 * the style elements wrapping the $tags data.
			 * If there are no $tags return null.
			 */
			if ( get_the_tag_list() && ! comments_open() && 0 <= get_comments_number() ) {
				$tags = '<span class="post-meta-tags no-comments">' . get_the_tag_list( $tags_symbol, ' | ' ) . '</span>';
			}

			// Use same HTML containers in singular views as those without comments.
			if ( get_the_tag_list() && is_singular() ) {
				$tags = '<span class="post-meta-tags no-comments">' . get_the_tag_list( $tags_symbol, ' | ' ) . '</span>';
			}

			return $tags;
		} else {
			return null;
		}
	}

	/**
	 * Author
	 *
	 * Displays the author's linked name with a prepended filterable symbol.
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     apply_filters()
	 * @see     get_the_author_link()
	 * @see     is_page()
	 * @see     comments_open()
	 * @see     get_comments_number()
	 *
	 * @return string|null
	 */
	function author() {

		/**
		 * Default is to display the author link; use the following, qualified
		 * as needed, to not display the author link:
		 * - add_filter( 'jimini_display_author_link', '__return_false' );
		 */
		$echo = apply_filters( 'jimini_display_author_link', true );

		if ( $echo ) {
			$author_symbol = '<span class="dashicons dashicons-admin-users"></span>';
			$author_symbol = apply_filters( 'jimini_author_symbol', $author_symbol );
			$author_link   = '<span class="post-meta-author-link">' . get_the_author_link() . '</span>';

			if ( is_page() && ( comments_open() || 0 < get_comments_number() ) ) {
				$author_link = '<span class="post-meta-author-link on-page-with-comments">' . get_the_author_link() . '</span>';
			}

			return $author_symbol . $author_link;
		} else {
			return null;
		}
	}

	/**
	 * Date
	 *
	 * Displays the post date prepended with a filterable symbol as well as
	 * providing a link to the post if there is no post title.
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     apply_filters()
	 * @see     get_the_date()
	 * @see     get_option()
	 * @see     get_the_title()
	 * @see     get_permalink()
	 * @see     esc_attr()
	 * @see     get_the_excerpt()
	 *
	 * @return string|null
	 */
	function date() {

		/**
		 * Default is to display the date meta; use the following, qualified as
		 * needed, to not display the date meta:
		 * - add_filter( 'jimini_display_date_meta', '__return_false' );
		 */
		$echo = apply_filters( 'jimini_display_date_meta', true );

		if ( $echo ) {

			$date_symbol = '<span class="dashicons dashicons-calendar-alt"></span>';
			$date_symbol = apply_filters( 'jimini_date_symbol', $date_symbol );
			$date        = '<span class="post-meta-date">' . get_the_date( get_option( 'date_format' ) ) . '</span>';

			// If there is no post title use the date as the link to the post.
			$title = get_the_title();
			if ( empty( $title ) ) {
				$date_link = '<span class="no-title"><a href="' . get_permalink() . '" title="' . esc_attr( get_the_excerpt() ) . '">'
				             . $date
				             . '</a></span>';

				return $date_symbol . $date_link;
			}

			return $date_symbol . $date;
		} else {
			return null;
		}
	}
}
