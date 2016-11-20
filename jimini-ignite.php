<?php
/**
 * Jimini Ignite
 *
 * Jumpin' Jimini ... let's fire this up!
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

// Add the Jimini Router class.
locate_template( 'inc/class.jimini-router.php', true, true );

// Add the Jimini Meta class.
locate_template( 'inc/class.jimini-meta.php', true, true );

// Add the Jimini Compatibility class.
locate_template( 'compat/class.jimini-compat.php', true, true );

// Add the Jimini Navigation class.
locate_template( 'inc/class.jimini-navigation.php', true, true );

// Add the Jimini Sidebars class.
locate_template( 'inc/class.jimini-sidebars.php', true, true );

// Add the Jimini Comments class.
locate_template( 'inc/class.jimini-comments.php', true, true );

// Add the Jimini Content class.
locate_template( 'inc/class.jimini-content.php', true, true );

// Add widgets.
locate_template( 'inc/widgets.php', true, true );

/**
 * Nothing to see here!
 *
 * @return null
 */
function jimini_nothing_to_see_here() {
	return null;
}
