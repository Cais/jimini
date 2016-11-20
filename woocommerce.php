<?php
/**
 * Jimini WooCommerce integration template.
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

// Pull in the header then build out the main content area.
get_header(); ?>

<?php do_action( 'jimini_main_content_with_left_sidebar_start' ); ?>
	<div class="main-content with-left-sidebar">

		<?php do_action( 'jimini_content_and_sidebar_start' ); ?>
		<div class="content-and-sidebar">

			<div class="content-wrapper">

				<?php do_action( 'jimini_content_wrapper_start' ); ?>

				<div class="content-without-sidebar">

					<?php
					/**
					 * This is where the compatibility magic happens:
					 * Use the WooCommerce compatibility loop here instead of JiminiContent loop.
					 * Do not render the post meta as it may be distracting in the shop details.
					 */
					JiminiCompat::woocommerce_loop();

					// Carry on with the display as usual.
					$jimini_content = JiminiContent::create_instance();
					$jimini_content->post_navigation(); ?>

					<?php do_action( 'jimini_content_without_sidebar_end' ); ?>

				</div><!-- content-without-sidebar -->

				<?php do_action( 'jimini_content_wrapper_end' ); ?>

			</div><!-- content-wrapper -->

			<div class="left-sidebar">

				<?php
				// We're finished with the content, let's take care of the sidebar.
				get_sidebar(); ?>

			</div><!-- left-sidebar -->

		</div><!-- content-and-sidebar -->
		<?php do_action( 'jimini_content_and_sidebar_end' ); ?>

	</div><!-- main-content with-left-sidebar -->
<?php do_action( 'jimini_main_content_with_left_sidebar_end' ); ?>

<?php

// The main content area is done, let's close off the page.
get_footer();
