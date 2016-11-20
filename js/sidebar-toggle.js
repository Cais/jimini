/**
 * Jimini Sidebar Toggle JavaScript
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

jQuery(document).ready(function ($) {
	/** Note: $() will work as an alias for jQuery() inside of this function */

	/** Change HTML element container classes as needed to toggle sidebar */
	$('a.toggle-clicker').click(function () {
		$('.with-left-sidebar').toggleClass('no-left-sidebar');
		$('.content-and-sidebar').toggleClass('content-only');
		$('.content-without-sidebar').toggleClass('content-only');
		$('.sidebar-toggle-tab').toggleClass('content-only');
	});

	/** Scroll down to display bottom sidebar toggle */
	$(window).scroll(function () {
		// If page is scrolled more than 50px.
		if ($(this).scrollTop() >= 50) {
			// Fade in the toggle icon.
			$('div.sidebar-toggle-tab.bottom > a').fadeIn(200);
		} else {
			// Else fade out the toggle icon.
			$('div.sidebar-toggle-tab.bottom > a').fadeOut(200);
		}
	});
});
