=== Keyboard Scroll ===
Contributors: Lutz Schroeer
Donate link: http://elektroelch.de
Tags: navigation, keyboard
Requires at least: 3.3
Tested up to: 3.7
Stable tag: trunk

This plugin allows easy scrolling your blog using J and K on your keyboard.

== Description ==

Many popular websites utilize the J and K keys to allow easy scrolling through their items. Many users got used to this navigation so it is a good idea to add this behaviour to your site. Especially if you have long posts on your main page this plugin makes it easy scroll between posts.
"Keyboard Scroll" will load the next/previous page if the user user reaches the end/beginning of the current page so there's no need to touch the mouse. You can disable this behaviour to be compatible with infinite scroll plugins.

== Features ==

* Automatic page change
* Configurable animation speed.
* Configurable CSS class

== Installation ==

Use the WordPress plugin installer or copy the downloaded files into the plugin directory. Activate the plugin.

== Configuration ==

* Animation speed:
If the page scrolls to the next post's heading the content is animated. This value defines the speed of the animation. The higher the value the slower the animation. A value of 0 disables the animation completely 

* CSS class:
Most themes use "post" as the main class for thei posts. Should your theme use a different class you can enter the name here (without the leading dot).

* Page change:
If the user reaches the end or the beginning of the current page and hits J/K again the page is changed. If you do not want this feature or use an infinite scroll plugin you should disable this setting.

== To-Do list ==
* message box if start or end of posts is reached
* pagination_base (http://toscho.de/2012/wordpress-seite-statt-page/)


== Changelog ==

= 1.05 =
+ Added: disable page change option on install if Jetpack's "Inifinite scroll" is detected.
+ Added: language file remplate
+ Added: German language file. Thanks to myself :-)
+ Added: uninstall.php
* Fixed: removed some short notation PHP tag


= 1.0 =
* Initial release.
