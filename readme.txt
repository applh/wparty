=== Plugin Name ===
Contributors: applh
Donate link: http://applh.com/
Tags: widget, pages, post, sidebar, content, mix, multi loop, shortcode, posts, page, theme, builder, custom, layout
Requires at least: 3.5
Tested up to: 3.5.1
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Mix website contents with WParty  
* pages  
* articles  
* widgets  
* menus  
* media  
* Simply use shortcode [part]  
* Soon: Theme Builder  

== Description ==

WParty is a WordPress Plugin to mix website contents  
* Pages  
* Articles  
* Widgets  
* Menus  
* Media  

* Simply use the shortcode [part]
* [part name="page-name"]

* Coming soon: Theme Builder  

NOTE: The plugin also activates ALL shortcodes in Text Widgets.
It makes easier to write HTML content in WordPress Editor, using Pages, and then embed the content in Text Widgets.

Custom HTML styles attributes can be added (id, class, style).

* [part name="page-name" id="my-id" class="my-class" style="background-color:#123456;"]

* Manage easily Events or Multi-languages websites

* REDIRECT
* [part widget="redirect" instance="/url2/"]

* CONDITIONS 
* [part name="page-name" start="01-03-2013" end="25-03-2013"]  
* [part if="lang=fr" widget="redirect" instance="/url2/"]  

* Custom Menus can also be included.
* [part menu="my-menu" name="page-name"]  

* Default LOOP can be included same as a widget:
* Read more... http://codex.wordpress.org/Template_Tags/get_posts

* [part widget="loop"]  
* [part widget="loop" args="numberposts=5&tag=my-tag1,my-tag2"]  

* CUSTOM LOOP HTML LAYOUT
`
[part widget="list" args="numberposts=5&tag=my-tag1,my-tag2"]  
<a href="PERMALINK"><h4>TITLE</h4></a>
CONTENT  
<small>TAGS</small> / <small>CATS</small> / <small>DATE</small>
[/part]
`  

WP Widgets can be added inside Pages/Posts. (Calendar, Recent_Posts, Tags, RSS, etc...).
* Read more... http://codex.wordpress.org/Function_Reference/the_widget
  
* [part widget="news"]  
* [part widget="tags"]  
* [part widget="categories"]  
* [part widget="archives"]  
* [part widget="calendar"]  
* [part widget="pages"]  
* [part widget="rss" instance="url=http://applh.com/feed/"]  
* [part widget="menu" instance="nav_menu=toto"]  
* [part widget="slider" name="my-slider"]  

* META
* [part meta="extra-name"]

NOTE: Content can embed recursive shortcodes.

* SIDEBARS
* [part widget="sidebar" name="theme-sidebar-name"]  

* WParty is also a theme builder: 
* [part theme="My Theme" name="new-theme"]

* WParty is designed to work with MultiSites installation.

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

= 1.6.1 =
* Add widget 'list'
* Add protection against infinite loop (recursion max=10)

= 1.6 =
* Add CONDITIONS to parts (if, start, end)
Manage easily Events or Multilang

* Add Redirection widget
* Add Meta part

= 1.5.1 =
* BUGFIX: Add missing filter

= 1.5 =
* Add Widgets LOOP, SIDEBARS

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

= 1.6.1 =
* Add widget 'list' for custom loop layout
* Add protection against infinite loop (recursion max=10)

= 1.6 =
* Manage easily Events or Multilang
* Add CONDITIONS to parts (if, start, end)
* Add Redirection widget
* Add Meta part

= 1.5.1 =
BUGFIX

= 1.5 =
More features.

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

