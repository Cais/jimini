<?php
/**
 * Jimini Content
 *
 * The loops and related methods
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
 * Class JiminiContent
 */
class JiminiContent {

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
	 * @return null|JiminiContent
	 */
	public static function create_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Init
	 *
	 * Add all of the filters and actions as needed.
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     add_filter
	 * @see     JiminiContent::extra_post_classes()
	 * @see     JiminiContent::protected_title_symbol()
	 * @see     JiminiContent::private_title_symbol()
	 */
	function init() {
		// Add extra post classes.
		add_filter( 'post_class', array(
			$this,
			'extra_post_classes',
		) );

		// Change Protected Text to a symbol.
		add_filter( 'protected_title_format', array(
			$this,
			'protected_title_symbol',
		) );

		// Change Private Text to a symbol.
		add_filter( 'private_title_format', array(
			$this,
			'private_title_symbol',
		) );
	}

	/**
	 * Protected Title Symbol
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * Used in place of the "Protected" text found with password protected posts
	 * and pages.
	 *
	 * @return string
	 */
	function protected_title_symbol() {
		$protected_title_symbol = '<span class="dashicons dashicons-lock protected-title-symbol" title="' . esc_attr__( 'Protected', 'jimini' ) . '"></span> %s';

		return $protected_title_symbol;
	}

	/**
	 * Private Title Symbol
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * Used in place of the "Private" text found with private posts and pages.
	 *
	 * @todo    use conditional checks for readers to change icons as needed?
	 *
	 * @return string
	 */
	function private_title_symbol() {
		$private_title_symbol = '<span class="dashicons dashicons-unlock private-title-symbol" title="' . esc_attr__( 'Private', 'jimini' ) . '"></span> %s';

		return $private_title_symbol;
	}

	/**
	 * The Loop
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     have_posts()
	 * @see     the_post()
	 * @see     post_class()
	 * @see     the_title()
	 * @see     JiminiMeta::create_instance()
	 * @see     JiminiComments::create_instance()
	 * @see     jimini_featured_image()
	 * @see     the_content()
	 * @see     wp_link_pages()
	 * @see     JiminiContent::no_posts_found()
	 */
	function the_loop() {
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();

				/*
				 * We have some content, let's get to work showing it.
				 */ ?>
				<div <?php post_class(); ?>>

					<h2 class="post-title">
						<span class="post-title-link">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</span>
					</h2>

					<?php
					/** Show the related meta data */
					$post_meta         = JiminiMeta::create_instance();
					$post_meta_data    = $post_meta->date() . $post_meta->author() . $post_meta->categories() . $post_meta->tags();
					$post_meta_display = '<span class="post-meta-display">' . $post_meta_data . '</span>';

					$jimini_comments = JiminiComments::create_instance();

					echo '<div class="post-meta">' . $post_meta_display . $jimini_comments->comments_link() . '</div>';

					echo $this->featured_image( 'medium' );

					/** Show the content */
					the_content(); ?>

				</div><!-- post class(es) -->

				<?php
				/** If there are multiple pages to the post, add some navigation. */
				$jimini_navigation = JiminiNavigation::create_instance();
				$jimini_navigation->link_pages(); ?>

				<hr /><!-- Horizontal Rule to delineate between posts -->

				<?php
				$jimini_comments->wrapped_comments_template();

			}
		} else {
			/*
			 * We don't have any content, let the visitor know and give them options.
			 */
			$this->no_posts_found();
		}
	}

	/**
	 * Post Navigation
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     posts_nav_link()
	 * @see     esc_html__()
	 */
	function post_navigation() {

		$nav_separator_symbol = '<span class="dashicons dashicons-controls-pause"></span>';
		$newer_nav_symbol     = '<span class="dashicons dashicons-arrow-left-alt2"></span>';
		$older_nav_symbol     = '<span class="dashicons dashicons-arrow-right-alt2"></span>';
		?>

		<!-- Add some navigation controls between post pages -->
		<div class="pagination for-posts">
			<?php
			posts_nav_link(
				$nav_separator_symbol,
				$newer_nav_symbol . esc_html__( 'Newer Posts', 'jimini' ),
				esc_html__( 'Older Posts', 'jimini' ) . $older_nav_symbol
			); ?>
		</div><!-- pagination for-posts -->

	<?php }

	/**
	 * No Posts Found
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     get_search_query()
	 * @see     esc_html__()
	 * @see     esc_html_e()
	 * @see     get_search_form()
	 */
	function no_posts_found() {

		if ( get_search_query() ) {
			echo '<h2 class="search-results">' . sprintf( esc_html__( 'Search Results for: %1$s', 'jimini' ), '<span class="search-query">' . get_search_query() . '</span>' ) . '</h2>';
			esc_html_e( 'Would you like to search again?', 'jimini' );
		} else {
			echo '<h2 class="search-results">' . esc_html__( 'There was no search performed.', 'jimini' ) . '</h2>';
		}

		get_search_form();

	}

	/**
	 * Extra Post Classes
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @param array $classes from the current post.
	 *
	 * @return array
	 */
	function extra_post_classes( $classes ) {
		$classes[] = 'cf';

		return $classes;
	}

	/**
	 * Post Is Paged
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @param array $haystack the body classes.
	 *
	 * @return bool|int
	 */
	function post_is_paged( $haystack ) {
		$needle = 'paged';

		return ( strpos( $haystack, $needle ) );
	}

	/**
	 * Featured Image
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @param string $size assigned in template.
	 *
	 * @see     has_post_thumbnail()
	 * @see     wp_get_attachment_metadata()
	 * @see     get_post_thumbnail_id()
	 * @see     get_body_class()
	 * @see     JiminiContent::post_is_paged()
	 * @see     esc_url()
	 * @see     home_url()
	 * @see     get_the_ID()
	 * @see     esc_attr()
	 * @see     the_title_attribute()
	 * @see     get_the_post_thumbnail()
	 *
	 * @return string|null
	 */
	function featured_image( $size ) {

		/** Sanity check. */
		if ( has_post_thumbnail() ) {

			/** Assign most correct class. */
			$featured_image_metadata = wp_get_attachment_metadata( get_post_thumbnail_id() );
			if ( $featured_image_metadata['height'] > $featured_image_metadata['width'] ) {
				$featured_image_class = 'portrait-featured-image alignleft';
			} else {
				$featured_image_class = 'landscape-featured-image alignleft';
			}
			if ( $featured_image_metadata['height'] === $featured_image_metadata['width'] ) {
				$featured_image_class = 'square-featured-image alignleft';
			}

			$post_is_paged = array_filter( get_body_class(), array(
				$this,
				'post_is_paged',
			) );

			if ( ! $post_is_paged ) {
				/** Create output to be displayed. */
				$output = '<a class="featured-thumbnail" href="' . esc_url( home_url( '/?p=' . get_the_ID() ) ) . '" title="' . esc_attr( the_title_attribute( 'echo=0' ) ) . '" >';
				$output .= get_the_post_thumbnail( get_the_ID(), $size, array( 'class' => $featured_image_class ) );
				$output .= '</a>';
			} else {
				$output = '';
			}

			/** Return the output. */
			return $output;

		} else {

			/** Nothing to see here, return null. */
			return null;

		}
	}
}

/** Instantiate and initialize the class. */
$jimini_content = JiminiContent::create_instance();
$jimini_content->init();
