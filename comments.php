<?php
/**
 * Comments Template
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

/** Create OpusPrimusComments class object */
$jimini_comments = JiminiComments::create_instance(); ?>

<!-- Show the comments -->
<!-- Inspired by http://digwp.com/2010/02/separate-comments-pingbacks-trackbacks/ -->
<div class="comments-wrapper cf">
	<?php if ( ! post_password_required() && have_comments() ) { ?>

		<h2 id="all-comments">
			<?php $jimini_comments->show_all_comments_count(); ?>
		</h2><!-- #all-comments -->

		<div id="comment-tabs">

			<ul id="comment-tabs-header">

				<?php
				$jimini_comments->comments_only_tab();
				$jimini_comments->pingbacks_only_tab();
				$jimini_comments->trackbacks_only_tab(); ?>

			</ul>

			<?php
			$jimini_comments->comments_only_panel();
			$jimini_comments->pingbacks_only_panel();
			$jimini_comments->trackbacks_only_panel(); ?>

		</div><!-- #comment-tabs -->

		<?php }

	comment_form(); ?>

</div><!-- .comments-wrapper -->
