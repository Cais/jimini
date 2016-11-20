<?php
/**
 * Sidebar Template
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

// Sanity check - do we have any active widgets in the "sidebar".
if ( JiminiSidebars::active_widgets() ) { ?>

	<div class="left-sidebar-container">

		<ul id="sidebar-one">
			<?php
			if ( is_active_sidebar( 'first-widget' ) ) {
				dynamic_sidebar( 'first-widget' );
			} ?>
		</ul><!-- #sidebar-one -->

		<ul id="sidebar-two">
			<?php
			if ( is_active_sidebar( 'second-widget' ) ) {
				dynamic_sidebar( 'second-widget' );
			} ?>
		</ul><!-- #sidebar-two -->

	</div><!-- left-sidebar-container -->

	<?php
}
