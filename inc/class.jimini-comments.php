<?php
/**
 * Jimini Comments
 *
 * Comments related functions
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
 * Class JiminiComments
 */
class JiminiComments {

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
	 * @return null|JiminiComments
	 */
	public static function create_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Enqueue Comment Reply
	 *
	 * If the page being viewed is a single post/page; and, comments are open;
	 * and, threaded comments are turned on then enqueue the built-in
	 * comment-reply script.
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     is_singular()
	 * @see     comments_open()
	 * @see     get_option()
	 * @see     wp_enqueue_script()
	 */
	function enqueue_comment_reply() {

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}


	/**
	 * Before Comment Form
	 *
	 * Text to be shown before form
	 *
	 * @package  Jimini
	 * @since    0.1
	 *
	 * @see      post_password_required()
	 * @see      apply_filters()
	 * @see      __()
	 * @see      have_comments()
	 */
	function before_comment_form() {
		/** Conditional check for password protected posts ... no comments for you! */
		if ( post_password_required() ) {
			echo '<span class="comments-password-message">' . esc_html__( 'This post is password protected. Enter the password to view comments.', 'jimini' ) . '</span>';

			return;
		}

		/** If comments are open, but there are no comments. */
		if ( ! have_comments() ) {
			echo '<span class="no-comments-message">' . esc_html__( 'Start a discussion ...', 'jimini' ) . '</span>';
		}

	}


	/**
	 * Comment Form Required Field Glyph
	 *
	 * Returns a filtered glyph used with Comment Form Required Fields
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     apply_filters()
	 */
	function comment_form_required_field_glyph() {

		$glyph = apply_filters( 'jimini_comment_form_required_field_glyph', '*' );

		return $glyph;

	}


	/**
	 * Change Comment Form Required Field Glyph
	 *
	 * Changes the default asterisk (*) to a filtered function
	 *
	 * @package  Jimini
	 * @since    0.1
	 *
	 * Props to Sergey Biryukov via the WordPress core trac for the base code
	 * used in this method
	 * @link     https://core.trac.wordpress.org/ticket/23870
	 *
	 * @see      JiminiComments::comment_form_required_field_glyph
	 *
	 * @param   object $defaults comment fields.
	 *
	 * @return  mixed
	 */
	function change_comment_form_required_field_glyph( $defaults ) {

		$defaults['fields']['author']     = str_replace( '*', $this->comment_form_required_field_glyph(), $defaults['fields']['author'] );
		$defaults['fields']['email']      = str_replace( '*', $this->comment_form_required_field_glyph(), $defaults['fields']['email'] );
		$defaults['comment_notes_before'] = str_replace( '*', $this->comment_form_required_field_glyph(), $defaults['comment_notes_before'] );

		return $defaults;

	}


	/**
	 * Comments Form Closed
	 *
	 * Test to be displayed if comments are closed
	 *
	 * @package  Jimini
	 * @since    0.1
	 *
	 * @see      is_page()
	 * @see      esc_html__()
	 */
	function comments_form_closed() {

		if ( ! is_page() ) {

			echo '<span class="comments-closed-message">' . esc_html__( 'New comments are not being accepted at this time, please feel free to contact the post author directly.', 'jimini' ) . '</span>';

		}

	}


	/**
	 * Comment Author Class
	 *
	 * Add additional classes to the comment based on the author
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @param array $classes default comment classes.
	 *
	 * @see     user_can()
	 *
	 * @return  array $classes - original array plus additional role and user-id
	 */
	function comment_author_class( $classes ) {

		global $comment;

		/** Add classes based on user role */
		if ( user_can( $comment->user_id, 'administrator' ) ) {
			$classes[] = 'administrator';
		} elseif ( user_can( $comment->user_id, 'editor' ) ) {
			$classes[] = 'editor';
		} elseif ( user_can( $comment->user_id, 'contributor' ) ) {
			$classes[] = 'contributor';
		} elseif ( user_can( $comment->user_id, 'subscriber' ) ) {
			$classes[] = 'subscriber';
		} else {
			$classes[] = 'guest';
		}

		/** Add user ID based classes */
		if ( 1 === $comment->user_id ) {
			/** Administrator 'Prime' => first registered user ID */
			$userid = 'administrator-prime user-id-1';
		} else {
			/** All other users - NB: user-id-0 -> non-registered user */
			$userid = 'user-id-' . ( $comment->user_id );
		}

		$classes[] = $userid;

		return $classes;

	}


	/**
	 * Comment Fields as List Items
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     wp_get_current_commenter()
	 * @see     get_option()
	 * @see     esc_html__()
	 * @see     esc_attr()
	 *
	 * @return  array
	 */
	function comment_fields_as_list_items() {

		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );

		$fields = array(
			'author' => '<li class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'jimini' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label>
			<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . ' " size="30" ' . $aria_req . ' /></li>',
			'email'  => '<li class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'jimini' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label>
			<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . ' " size="30" ' . $aria_req . ' /></li>',
			'url'    => '<li class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'jimini' ) . '</label>
			<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></li>',
		);

		return $fields;

	}


	/**
	 * Comment Fields Wrapper Start
	 *
	 * Echoes an opening `ul` tag
	 *
	 * @package  Jimini
	 * @since    0.1
	 *
	 * @internal Works in conjunction with `comment_fields_as_list_items`
	 */
	function comment_fields_wrapper_start() {
		echo '<ul id="comment-fields-listed-wrapper">';
	}


	/**
	 * Comment Fields Wrapper End
	 *
	 * Echoes a closing `ul` tag
	 *
	 * @package  Jimini
	 * @since    0.1
	 *
	 * @internal Works in conjunction with `comment_fields_as_list_items`
	 */
	function comment_fields_wrapper_end() {
		echo '</ul><!-- #comment-fields-listed-wrapper -->';
	}


	/**
	 * Comments Link
	 *
	 * Displays amount of approved comments the post or page has
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     is_single()
	 * @see     is_archive()
	 * @see     post_password_required()
	 * @see     esc_attr()
	 * @see     JiminiComments::comments_closed_class()
	 * @see     JiminiComments::has_comments_class()
	 * @see     comments_popup_link()
	 * @see     __()
	 * @see     _x()
	 * @see     esc_html__()
	 *
	 * @return null|string
	 */
	function comments_link() {

		/**
		 * Only show the comments_link when not in single views or in archive
		 * views
		 */
		if ( ! is_single() || is_archive() ) {

			$comments_open_icon   = '<span class="dashicons dashicons-admin-comments"></span>';
			$comments_closed_icon = '<span class="dashicons dashicons-welcome-comments"></span>';

			if ( ! post_password_required() ) {
				ob_start();
				echo '<span class="comments-link ' . esc_attr( $this->comments_closed_class() ) . ' ' . esc_attr( $this->has_comments_class() ) . '">';
				comments_popup_link(
					$comments_open_icon . __( 'No Comments', 'jimini' ),
					$comments_open_icon . __( '1 Comment', 'jimini' ),
					$comments_open_icon . _x( '% Comments', 'the % sign is a placeholder for the number of comments', 'jimini' ),
					'comments-link-from-post',
					$comments_closed_icon . __( 'Comments closed.', 'jimini' )
				);
				echo '</span><!-- .comments-link -->';
				$output = ob_get_clean();

				return $output;

			} else {

				return '<div class="comments-password-message">' . esc_html__( 'This post is password protected. Enter the password to view comments.', 'jimini' ) . '</div>';

			}
		} else {

			return null;

		}

	}


	/**
	 * Comments Closed Class
	 *
	 * Returns an appropriate string indicating if comments are open of closed
	 * on the post or page in question
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     comments_open()
	 *
	 * @return string
	 */
	function comments_closed_class() {

		if ( ! comments_open() ) {
			return 'comments-closed';
		} else {
			return 'comments-open';
		}

	}


	/**
	 * Has Comments Class
	 *
	 * Returns an appropriate string indicating if comments exist for the post
	 * or page in question
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     get_comments_number()
	 *
	 * @return string
	 */
	function has_comments_class() {

		if ( 0 < get_comments_number() ) {
			return 'has-comments';
		} else {
			return 'no-comments';
		}

	}


	/**
	 * Wrapped Comments Template
	 *
	 * Wraps the comments_template call in action hooks
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     comments_template()
	 */
	function wrapped_comments_template() {

		comments_template( '/comments.php', true );

	}


	/**
	 * Comments Only Tab
	 *
	 * Displays number of comments for the type:comment tab
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     _n()
	 * @see     __()
	 * @see     number_format_i18n()
	 */
	function comments_only_tab() {

		global $wp_query;

		$comments_only = $wp_query->comments_by_type['comment'];

		if ( ! empty( $comments_only ) ) { ?>

			<li id="comments-only-tab">
				<a href="#comments-only">
					<h3 id="comments">
						<?php
						printf(
							_n(
								__( '%1$s Comment', 'jimini' ),
								__( '%1$s Comments', 'jimini' ),
								count( $comments_only )
							),
							number_format_i18n( count( $comments_only ) )
						); ?>
					</h3><!-- #comments -->
				</a>
			</li><!-- #comments-only-tab -->

		<?php }

	}


	/**
	 * Pingbacks Only Tab
	 *
	 * Displays number of comments for the type:pingback tab
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     _n()
	 * @see     __()
	 * @see     number_format_i18n()
	 */
	function pingbacks_only_tab() {

		global $wp_query;

		$pingbacks_only = $wp_query->comments_by_type['pingback'];

		if ( ! empty( $pingbacks_only ) ) { ?>

			<li id="pingbacks-only-tab">
				<a href="#pingbacks-only">
					<h3 id="pingbacks">
						<?php
						printf(
							_n(
								__( '%1$s Pingback', 'jimini' ),
								__( '%1$s Pingbacks', 'jimini' ),
								count( $pingbacks_only )
							),
							number_format_i18n( count( $pingbacks_only ) )
						); ?>
					</h3><!-- #pingbacks -->
				</a>
			</li><!-- #pingbacks-only-tab -->

		<?php }

	}


	/**
	 * Trackbacks Only Tab
	 *
	 * Displays number of comments for the type:trackback tab
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     _n()
	 * @see     __()
	 * @see     number_format_i18n()
	 */
	function trackbacks_only_tab() {

		global $wp_query;

		$trackbacks_only = $wp_query->comments_by_type['trackback'];

		if ( ! empty( $trackbacks_only ) ) { ?>

			<li id="trackbacks-only-tab">
				<a href="#trackbacks-only">
					<h3 id="trackbacks">
						<?php
						printf(
							_n(
								__( '%1$s Trackback', 'jimini' ),
								__( '%1$s Trackbacks', 'jimini' ),
								count( $trackbacks_only )
							),
							number_format_i18n( count( $trackbacks_only ) )
						); ?>
					</h3><!-- #trackbacks -->
				</a>
			</li><!-- #trackbacks-only-tab -->

		<?php }

	}


	/**
	 * Comments Only Panel
	 *
	 * Displays only those comments of type: comment
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     wp_list_comments()
	 * @see     get_option()
	 * @see     JiminiNavigation::comments_navigation()
	 */
	function comments_only_panel() {

		global $wp_query;

		$comments_only = $wp_query->comments_by_type['comment'];

		if ( ! empty( $comments_only ) ) { ?>

			<div id="comments-only">
				<ul class="comments-list">
					<?php wp_list_comments( 'type=comment' ); ?>
				</ul>
				<!-- comments-list -->
				<?php
				if ( get_option( 'comments_per_page' ) < count( $comments_only ) ) {
					$jimini_navigation = JiminiNavigation::create_instance();
					$jimini_navigation->comments_navigation();
				} ?>
			</div><!-- #comments-only -->

		<?php }

	}


	/**
	 * Pingbacks Only Panel
	 *
	 * Displays only those comments of type: pingback
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     wp_list_comments()
	 * @see     get_option()
	 * @see     JiminiNavigation::comments_navigation()
	 */
	function pingbacks_only_panel() {

		global $wp_query;

		$pingbacks_only = $wp_query->comments_by_type['pingback'];

		if ( ! empty( $pingbacks_only ) ) { ?>

			<div id="pingbacks-only">
				<ul class="pingbacks-list">
					<?php wp_list_comments( 'type=pingback' ); ?>
				</ul>
				<!-- pingbacks-list -->
				<?php
				if ( get_option( 'comments_per_page' ) < count( $pingbacks_only ) ) {
					$jimini_navigation = JiminiNavigation::create_instance();
					$jimini_navigation->comments_navigation();
				} ?>
			</div><!-- #pingbacks-only -->

		<?php }

	}


	/**
	 * Trackbacks Only Panel
	 *
	 * Displays only those comments of type: trackback
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     wp_list_comments()
	 * @see     get_option()
	 * @see     JiminiNavigation::comments_navigation()
	 */
	function trackbacks_only_panel() {

		global $wp_query;

		$trackbacks_only = $wp_query->comments_by_type['trackback'];

		if ( ! empty( $trackbacks_only ) ) { ?>

			<div id="trackbacks-only">
				<ul class="trackbacks-list">
					<?php wp_list_comments( 'type=trackback' ); ?>
				</ul>
				<!-- trackbacks-list -->
				<?php
				if ( get_option( 'comments_per_page' ) < count( $trackbacks_only ) ) {
					$jimini_navigation = JiminiNavigation::create_instance();
					$jimini_navigation->comments_navigation();
				} ?>
			</div><!-- #trackbacks-only -->

		<?php }

	}


	/**
	 * All Comments Count
	 *
	 * Calculates total comments by adding the totals of each of the comment
	 * types: comment, pingback, and trackback
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @return  string
	 */
	function all_comments_count() {

		global $wp_query;

		$comments_only   = intval( count( $wp_query->comments_by_type['comment'] ) );
		$pingbacks_only  = intval( count( $wp_query->comments_by_type['pingback'] ) );
		$trackbacks_only = intval( count( $wp_query->comments_by_type['trackback'] ) );

		/** Initialize comments counter */
		$all_comments = 0;
		/**
		 * To remove a comment type count simply comment out or remove the
		 * appropriate line. This will affect the value passed to the method
		 * used to display the value.
		 * NB: This would be best done via a Child-Theme.
		 */
		$all_comments = $all_comments + $comments_only;
		$all_comments = $all_comments + $pingbacks_only;
		$all_comments = $all_comments + $trackbacks_only;

		return $all_comments;

	}


	/**
	 * Show All Comments Count
	 *
	 * Displays the `all_comments_count` value
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     JiminiComments::all_comments_count()
	 * @see     _n()
	 * @see     __()
	 * @see     number_format_i18n()
	 */
	function show_all_comments_count() {

		/** Get the total from `all_comments_count` */
		$total_comments = $this->all_comments_count();

		/** Check if there are any comments */
		if ( $total_comments > 0 ) {
			$show_all_comments_count = sprintf( _n( __( '%s Response', 'jimini' ), __( '%s Responses', 'jimini' ), $total_comments ), number_format_i18n( $total_comments ) );
		} else {
			$show_all_comments_count = __( 'No Responses', 'jimini' );
		}

		/** Display the total comments message */
		echo esc_html( $show_all_comments_count );

	}

	/**
	 * Class initializer
	 *
	 * @package Jimini
	 * @since   0.1
	 *
	 * @see     add_action()
	 * @see     JiminiComments::enqueue_comment_reply()
	 * @see     JiminiComments::before_comment_form()
	 * @see     JiminiComments::comments_form_closed()
	 * @see     JiminiComments::comment_fields_wrapper_start()
	 * @see     JiminiComments::comment_fields_wrapper_end()
	 * @see     add_filter()
	 * @see     JiminiComments::comment_author_class()
	 * @see     JiminiComments::change_comment_form_required_field_glyph()
	 * @see     JiminiComments::comment_fields_as_list_items()
	 */
	public function init() {
		/** Add comment actions - enqueue threaded comments */
		add_action(
			'comment_form_before', array(
				$this,
				'enqueue_comment_reply',
			)
		);

		add_action(
			'comment_form_before', array(
				$this,
				'before_comment_form',
			)
		);
		add_action(
			'comment_form_comments_closed', array(
				$this,
				'comments_form_closed',
			)
		);

		/** Add comment actions - wrap comment fields in unordered list */
		add_action(
			'comment_form_before_fields', array(
				$this,
				'comment_fields_wrapper_start',
			)
		);
		add_action(
			'comment_form_after_fields', array(
				$this,
				'comment_fields_wrapper_end',
			)
		);

		/** Add comment filters - NB: Order of these filters is important! */
		add_filter( 'comment_class', array( $this, 'comment_author_class' ) );

		add_filter(
			'comment_form_defaults', array(
				$this,
				'change_comment_form_required_field_glyph',
			)
		);

		/** Add comment filters - change fields to list items from paragraphs */
		add_filter(
			'comment_form_default_fields', array(
				$this,
				'comment_fields_as_list_items',
			)
		);
	}
}

/*
 * Instantiate and initialize the class.
 */
$jimini_comments = new JiminiComments();
$jimini_comments->init();
