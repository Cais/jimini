=== Jimini readme.md ===

== Table of Contents ==
- Frequently Asked Questions
- Copyright
- Licenses
- Minimum Versions
- Changelog

= Frequently Asked Questions =
* How do I change the background colors?
The background colors of the theme are currently found defined in the following
places:
`.with-left-sidebar` defines the left sidebar;
`.with-left-sidebar .content-and-sidebar` defines the main content body; and,
the header area uses the default browser background color, usually white.

* How do I not display the post meta data?
The easiest method to not display the post meta data is to set each meta element
to not be displayed by returning false to its display "hook". Have a look inside
the `class.jimini-meta.php` file for specific examples.

* What happens if I do not have any active sidebars?
The theme adapts to having no active sidebars by changing from a left-sidebar
layout to a full-width layout.

= Copyright =
- Copyright (c) 2016, Edward Caissie

This file is part of Jimini.

Opus Primus is free software; you can redistribute it and/or modify it under the
terms of the GNU General Public License version 2, as published by the Free
Software Foundation.

You may NOT assume that you can use any other version of the GPL.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program; if not, write to:

    Free Software Foundation, Inc.
    51 Franklin St, Fifth Floor
    Boston, MA  02110-1301  USA

The license for this software can also likely be found here:
http://www.gnu.org/licenses/gpl-2.0.html

= Licenses =

All items are licensed under the GNU General Public License v2; or, as the case
may be, individually noted below.

* Normalize.css is a project by Nicolas Gallagher and Jonathan Neal. Licensed as
Public Domain for more information see:
http://necolas.github.com/normalize.css/

= Minimum Versions =
* WordPress 4.1.0 (required); WordPress 4.7.0 recommended for "Post Templates"
* PHP 5.6 (recommended)
* MySQL 5.6 (recommended)

= Changelog =
* Initial release.