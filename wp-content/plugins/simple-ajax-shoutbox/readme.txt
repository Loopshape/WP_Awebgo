=== Plugin Name ===
Contributors: social_enemy, honza.skypala
Tags: chat, comments, widget, ajax
Requires at least: 4.0
Tested up to: 4.3
Stable tag: 2.0

Simple AJAX shoutbox, add shoutbox on your sidebar.

== Description ==

This plugin will add a shoutbox on your sidebar. Using AJAX technology so visitor doesnt have to refresh page to view their messages. It automatically reload every few seconds so you can see other visitor messages live. It has simple design, so it will blend to your current theme whatever it is. No extra graphics, color, text. Just a simple box. Support smilies, smilies tags are instantly converted to graphics smilies.

== Installation ==

1. Upload `ajax-shoutbox` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Enable it on sidebar from admin widget manager (Appearance → Widgets).

== Frequently Asked Questions ==

= Where can i delete the message? =

Log in as admin and delete directly from messagebox. You should find a delete link there.

= Where can i found configuration for this plugin? =

You can find all of it on widget manager (Appearance → Widgets).

= How to change the widget height =

it's easy to change the widget height via css. Just insert the following (adjust the height to whatever you like):
`#sb_messages {
    height: 600px;
}`
You can either put this to your theme CSS, or if you are using a standard theme, then maybe putting this to Jetpack → Custom CSS is better place (so it is not overwritten once you update the theme).

== Screenshots ==

1. Shoutbox widget
2. Widget configuration

== Changelog ==

= 2.0 =
* overtake of the repository for this plugin by honza.skypala
* if shoutbox content is scrolled down, then it is locked and not refreshing; after scrolling back to the top, refreshing is enabled again.
* scrolling the content to the bottom loads more (older) messages, this way history is fully accessible
* widget already contains the messages when the page is loaded; anyway, widget still refreshes its content immediately after page load, this is due to possible caching plugins
* Gravatars supported
* message replies supported
* labels for input fields utilize HTML5 placeholders with jQuery fallback for browsers that do not support this
* Ctrl-Enter for posting new message
* added filter to process each message
* support to texturize the message (via filter, so can be switched off by template)
* URLs in messages are converted to hyperlinks, shortened to fit the width of the widget (via filter)
* e-mail addresses in messages converted to hyperlinks (via filter)
* embed support for images, oEmbed (using WordPress oEmbed code -- so working e.g. for Twitter and other services), YouTube (custom embed), HTML5 audio, HTML5 video, eBay auctions, Amazon items, Imgur and Tumblr images (each embed via filter)
* caching of embed fetches for increased loading speed
* if shoutbox content not changed, no refresh performed on the page (good for images and videos, so they do not reload)
* RSS channel containing messages from the shoutbox
* if the plugin is deactivated, the messages are not erased anymore (i.e. if you deactivate the plugin and then activate it again, the widget still has the messages)
* if browser tab with chatbox inactive, then chatbox does not refresh; after it becomes active again, refreshes immediately
* smilies fetched from WordPress API, no hardcode list of smilies in the plugin
* does not display duplicate smiley icons (still processes/converts all smilies if entered via text)
* i18n support
* (internal) updated to WordPress 2.8+ widget API
* (internal) CSS and JS moved to external file and folder
* (internal) local jQuery.js copy removed (not used by the plugin anyway)
* (internal) other fixes

= 1.2.3 =
* Change registered user login into display name.
* Fix compatibility with jquery 1.3.2 and IE.
* Few cosmetic changes.

= 1.2.2 =
* Akismet support for spam checking.
* Tweak AJAX process, more efficient.
* Add only registered user allowed to post.

= 1.2.1 =
* Added HTML enable/disable for security issue.
* Language support.

= 1.2 =
* Fix image not shown.

= 1.1 =
* Fix path.

= 1.0 =
* New plugin published.
