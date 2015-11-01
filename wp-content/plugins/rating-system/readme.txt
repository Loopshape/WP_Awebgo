=== Rating System ===
Contributors: VortexThemes, AlexAlexandru
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VVGFFVJSFVZ7S
Tags: like, dislike, voting, rating, upvote, downvote, ajax, interactive, widget, comments, post, posts, page, widgets, jquery, custom post type, dashbord, bbpress
Requires at least: 4.1
Tested up to: 4.3.1
Stable tag: 2.7.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The simple way to add like and dislike buttons for your posts, pages, comments and custom post type.

== Description ==
* ATTENTION!YOU NEED [REDUX FRAMEWORK](https://wordpress.org/plugins/redux-framework/)(FREE PLUGIN) INSTALLED AND ACTIVATED FOR THIS PLUGIN TO WORK.
* Support for custom post type(WooCommerce etc). &#10004;
* Support for bbPress. &#10004;
* Support for Epoch. &#10004;
* Support for buddyPress. &#10004;
* Integration with MyCred. &#10004;
* Support for posts, pages, comments. &#10004;
* No backlink. &#10004;
* No ads. &#10004;
* No external connections to another server. &#10004;
* Anonymous voting tracked by IP address. &#10004;
* Option to disable the dislike button. &#10004;
* Free Widget to show your most liked posts. &#10004;
* Free WordPress Dashboard widget. &#10004;
* Shortcode [rating-system-posts](You must have turned on like or dislike for posts and pages and if you want you can disable display buttons on). &#10004;
* Shortcode [rating-system-comments]. &#10004;
* Sort comments by likes. &#10004;
* Check the screenshots tab we have a lot of cool features.
* If you finds bugs or need support go to the support tab.
* If you like this plugin consider making a [donation](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VVGFFVJSFVZ7S) or Rate us &#9733;&#9733;&#9733;&#9733;&#9733;
* [Facebook](https://www.facebook.com/VortexThemes) [Twitter](https://twitter.com/VortexThemes) [Github](https://github.com/VortexThemes/rating-system)

== Installation ==
You can use this code to generate the like button inside the loop
<?php 	if(function_exists('vortex_render_for_posts')){
			echo vortex_render_for_posts(false);
		}
?>
If you want to generate both(like and dislike) use this code
<?php 	if(function_exists('vortex_render_for_posts')){
			echo vortex_render_for_posts();
		}
?>
1. After you download the plugin go to Plugins -> Add New -> Upload Plugin
2. Choose the zip and upload

== Screenshots ==

1. Settings for comments
2. Settings for posts-pages
3. Most liked posts widget
4. Comment buttons
5. Custom columns in 'All posts' with likes and dislikes for each post
6. Basic text to translate
7. Settings for WordPress Dashboard Widget
8. WordPress Dashboard Widge
9. Likes and dislike buttons and the widget on the wordpress site
10. More options
11. bbPress support
12. WooCommerce support

== Upgrade Notice ==

notices

== Frequently Asked Questions ==
> **Question: Does this plugin support bbPress?**
>
> **Answer:** Yes.You will have to turn on bbPress support from the plugin option panel(check the screenshots tab to see our plugin in action).
>
> **Question: Can I add like or dislike to WooCommerce products?**
>
> **Answer:** Yes.You will have to check Custom post type single or index from the plugin option panel(Display buttons on:).
>
> **Question: Can I disable the dislike button?**
>
> **Answer:** Yes.
>

== Changelog ==
= 2.7.2 = 
* Fixed fatal error on PHP 5.2.4.
* Added shortcode for comments.
* Improved myCred integration.
= 2.7.1 = 
* Fixed fatal error on PHP 5.3.
= 2.7 = 
* Added MyCred integration.
* Improved bbPress support.
= 2.6 = 
* Added buddyPress activity support.
* Improved Epoch support.
= 2.5 = 
* Added auto delete post at a given number of dislikes.
* Added Epoch Support.(Settings for comments -> Enable Epoch Support).
* Fix error when voting.
= 2.4 = 
* Added a way to disable the like button from function.
= 2.3 = 
* Fix fatal error.
= 2.2 = 
* Added the shortcode [rating-system](You must have turned on like or dislike for posts and pages).
= 2.1 = 
* Fix unable to save settings.Huge thanks to [aekae](https://wordpress.org/support/profile/aekae)

= 2.0 = 
* Fix english typos.
* Improved mobile experience.
* Minor performance improvement.

= 1.9 = 
* Fix undefined variable.
* Fix options from posts affected by options from comments.
* Fix buttons not showing.Huge thanks to [gkarapalidis ](https://profiles.wordpress.org/gkarapalidis) for letting me test on his website.
* Minor performance improvement.

= 1.8 = 
* Fix translation not working.
* Updated the .pot file.
* Changed error handling from fatal error to warning.
* Removed .temp file.

= 1.7 = 
* Fix rendering on password protected posts.
* Added option to exclude sticky posts from most liked widget.

= 1.6 = 
* Fix widgets not working after 1.5 update.

= 1.5 = 
* Fix options panel not working.Huge thanks to [AzzePis](https://wordpress.org/support/profile/azzepis) for letting me test on his/her website.

= 1.4 = 
* Fix upload

= 1.3 = 
* Fix posts being added to widget area with 0 likes
* Fix posts being added to widget area above the limit of the widget display
* Fix option panel not working

= 1.2 = 
* Added plugin icon
* Fix wrong text being displayed when Redux Framework is being required

= 1.1 = 
* Wordpress 4.1 compatibility

= 1.0 =
* First release.
