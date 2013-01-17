=== Plugin Name ===
Contributors: applh
Donate link: http://applh.com/
Tags: pages, content, mix, multi loop, widgets, shortcode
Requires at least: 3.5
Tested up to: 3.5
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

WParty is a WordPress plugin to mix pages/articles/media/widgets/menus content.

== Description ==

WParty is a WordPress plugin to mix pages / articles / widgets / media / menus content.

// shortcode [part name="page-name"]

// shortcode [part name="page-name" id="my-id" class="my-class" style="background-color:#123456;"]

// shortcode [part menu="my-menu" name="page-name"]

// http://codex.wordpress.org/Function_Reference/the_widget

// shortcode [part widget="news"]

// shortcode [part widget="tags"]

// shortcode [part widget="categories"]

// shortcode [part widget="archives"]

// shortcode [part widget="calendar"]

// shortcode [part widget="pages"]

// shortcode [part widget="rss" instance="url=http://applh.com/feed/"]

// shortcode [part widget="menu" instance="nav_menu=toto"]

// shortcode [part theme="My Theme" name="new-theme"]

The plugin also activates ALL shortcodes in Text Widgets.
It makes easier to write HTML content in WordPress Editor, using Pages, and then embed the content in Text Widgets.

Custom HTML styles attributes can be added (id, class, style).

Widgets can be added inside Pages/Posts. (Calendar, Recent_Posts, Tags, RSS, etc...).

Content can embed recursive shortcodes.

Custom Menus can also be included.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `/wparty/` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place shortcode `[part name="page-name"]` in your pages content

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets 
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png` 
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.4 =
* Add Widgets

= 1.3 =
* Bug Correction
* Add Widgets
* DEV: Add theme builder

= 1.2 =
* Add custom CSS (id, class and style)
* Add custom menu inclusion

= 1.1 =
* Add recursion in page content for embedded shortcodes
* Activate shortcodes in Text Widget

= 1.0 =
* Initial version

== Upgrade Notice ==

= 1.4 =
More features.

= 1.3 =
More features. Bugs Correction.

= 1.2 =
More features

= 1.1 =
The plugin activates shortcodes in Text Widget.
Easier writing of HTML with WP Editor!
Simply include [part page="page-name"] to get your HTML content in text widget.

= 1.0 =
Improve content management for your website.

== Happy New Year ==

Best wishes for 2013. ;-)

