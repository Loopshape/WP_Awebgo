=== cookie-cat ===
Contributors: bobbingwide, vsgloik
Donate link: http://www.oik-plugins.com/oik/oik-donate/
Tags: cookie, categories, catalog, oik, EU cookie directive, UK cookie law, audit
Requires at least: 3.9
Tested up to: 4.2
Stable tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Assist compliance with UK cookie law/EU cookie directive by listing the cookies your website uses using the [cookies] shortcode. depends on oik.


== Description ==    
Use the [cookies] shortcode to produce a table of all the cookies your WordPress site uses; showing cookie name, category, description and duration.
In April 2012 the International Chamber of Commerce (ICC) UK issued the ICC UK cookie guide ( a 15-page / 296KB PDF report ).
The guidance, which has been welcomed by the Information Commissioner's Office (ICO), contains information on the different categories of cookies that website operators use.
The ICC UK cookie guide suggests some standard wording to include in your website's Privacy policy.

This wording includes: **A list of all the cookies used in this website by category is set out below.**
 
This plugin will help you to create the list.
By default the list is dynamically generated taking into account the active plugins on the website. 
         
This plugin *does not* implement anything to help you obtain the user's consent to place a cookie on their device.
There are other plugins to help you do that. 

Use in conjunction with [oik-privacy-policy](http://wordpress.org/plugins/oik-privacy-policy/)

http://youtu.be/8i-sm6TS28M

== Installation ==
1. Upload the contents of the cookie-cat plugin to the `/wp-content/plugins/cookie-cat' directory
1. Activate the cookie-cat plugin through the 'Plugins' menu in WordPress
1. Visit oik options > cookie cat page and perform the following steps
1. Click on the Load XML button. A temporary XML file will be loaded for your active plugins
1. Check the 'Use temp XML file?' checkbox and click on Redisplay. The cookie catalog may change. If there are "unknown" see the FAQ
1. Click on the Save XML button to update the Latest XML file to the Latest loaded. 
1. Edit your Privacy policy page to include the [cookies] shortcode

Note: cookie-cat is dependent upon the oik plugin. You can activate it but it will not work unless oik is also activated.
Download oik from 
[oik download](http://wordpress.org/extend/plugins/oik/)

== Frequently Asked Questions ==
= What is the EU cookie law? =
Also known as the EU e-Privacy Directive the "UK Privacy and Electronic Communications Regulation" becomes effective in the UK on 26th May 2012.
That's the date when the Information Commissioner's Office (ICO) is due to begin enforcing the new rules.

= Who does it apply to? = 
All websites that use cookies which may be delivered to devices being used in the UK or EU countries.

= What should we do about it? =
Steps to take:

1. Each website should have a privacy policy page.
2. Each privacy policy page should list the cookies in use.
3. Each website should obtain consent to use cookies, as and when required, depending on cookie category

This plugin helps with step 2.

= What are the cookie categories? =
Here's a simple list. 

1. Strictly necessary cookies - these cookies enable services you have specifically asked for
2. Performance cookies - these cookies collect anonymous information on the pages visited
3. Functionality cookies - these cookies remember choices you make to improve your experience
4. Targeting cookies or advertising cookies - these cookies collect information about your browsing habits in order to make advertising relevant to you and your interests.

For more information see [cookie-cat](http://www.cookie-cat.co.uk) or read the ICC UK Cookie guide

= I just get [cookies]! =
You need to activate both the oik plugin and the cookie-cat plugin.
And check the syntax of the shortcode.

= Some of my cookies are "unknown" =
The list of cookies that this plugin recognises may never be a complete list of all known cookies.
If your website delivers cookies that are not recognised then the cookie category, description and duration will be shown as "unknown".
This is not really acceptable as the guidelines state that you're suppposed to explain "how they are used on the websites they visit".

There are several ways to address this problem.

1. Do nothing. NOT recommended.
2. Add a caveat saying something like "the exact purpose of the cookie has not yet been ascertained. If you are concerned please contact us for more information."
3. Remove the unknown items from the table.
4. Find out what the unknown cookies are; then update the output with the correct information.
5. Stop using the plugin/theme or service that delivers the "unknown" cookie
6. Let cookie-cat know you have an "unknown" cookie, wait for an update and retry.
6. Raise an issue if there is a bug in the code.

= How do I add a caveat? =
First you need a Privacy policy page. 
If you have used the [oik-privacy-policy](http://www.wordpress.org/extend/plugins/oik-privacy-policy) plugin to help generate your Privacy policy page then you can write the caveat in the section that starts *"A list of all the cookies used in this website by category is set out below".*

= How do I remove the items from the table =

1. Override the default logic to select the plugins you want processed
2. Override the default logic to select the cookies you want listed
3. Edit the generated HTML
4. Programmatically, using the "cookies" filter
5. A combination of the above

= How do I update the output? =
The [cookies] shortcode queries information from an XML file that contains the known information about a cookie.
If you think it's wrong then you can do one or more of the following:

* save the HTML generated by the [cookies] shortcode and edit it manually
* change the XML file 
* develop a "filter" to alter the data before it's displayed  

= How do I save the generated HTML = 
Use the "oik options > shortcode help" page, select the [cookies] entry then copy the generated "snippet"
Paste this into your Privacy policy page.
You may then wish to de-activate the cookie-cat plugin until you next change the installed plugins. 

= How do I change the XML file? =
From version 1.1 the XML file can be loaded directly from the cookie-cat website.
Use oik options > cookie cat and follow the instructions in the Installation section
Note that using the Load XML function passes the names of currently active cookies to the cookie-cat server.
By using the function you authorize cookie-cat to the information that is passed.


= What is the source of the XML file's data =
This comes from a website called [cookie-cat](http://www.cookie-cat.co.uk). 
The XML file delivered with the plugin is generated from the data held in the website.
Every so often it is regenerated, producing information about the known cookies used by known plugins.
Whenever the plugin is updated then a new version of this file will be delivered.

= The list of cookies shown is different from cookiecert.com's list =
The main reason is probably because the XML file doesn't yet have a mapping between a plugin and a group of cookies.
Try using [cookies browser=Y]; you may get some "unknown" cookies listed. If so, see above.

The cookiecert.com website reports the cookies it comes across when visiting your site. 
The list seems to include cookies that its spider has accessed by following links such as PayPal buttons.

= Can I list the browser cookies? =
Yes. Use [cookies browser=Y]

= What is the syntax for [cookies]? =
`[cookies
browser="N|Y - show browser cookies"
cookies="|cookie1,cookie2 - Optional list of cookie names."
plugins="|plugin1,plugin2 - Optional list of plugin names. Defaults to ALL active plugins"
temp="N|Y - Use the temporary cc_mapping XML file"]`

= Where can I find out more? = 
If you are in the UK you should see the [ICC UK Cookie Guide](http://www.international-chamber.co.uk/components/com_wordpress/wp/wp-content/uploads/2012/04/icc_uk_cookie_guide.pdf)

Also have a look at the links on the [cookie-cat](http://www.cookie-cat.co.uk) website.

== Screenshots ==
1. cookie-cat options section
2. XML feed section: showing the XML files being used
3. Cookie catalog - the "current" output from the [cookie] shortcode
4. Example showing selected cookies and plugins
5. cookie-cat.co.uk Mapping page - the source of the data
6. cookie cat Warning that data is passed to the cookie-cat server

== Upgrade Notice ==
= 1.4 =
Tested with WordPress 4.0, including WordPress Multi Site

= 1.3 =
Tested with WordPress 3.9

= 1.2 =
Changes to satisfy WordPress plugin review. Works with oik version 1.13 and above 

= 1.1 =
Now loads the XML directly from cookie-cat.co.uk

= 1.0 = 
Requires oik version 1.13 or higher

== Changelog ==
= 1.4 = 
* Changed: Improved some docblocks.
* Changed: Now depends on oik v2.2
* Changed: Responds to "oik_add_shortcodes" action to define the "cookies" shortcode
* Tested: With WordPress 4.0

= 1.3 = 
* Changed: Slight restructuring for improved documentation
* Changed: Now dependent upon oik v2.1 or higher

= 1.2 = 
* Added: Warning messages about information that is passed to the cookie-cat server when using "Load XML"
* Tested: Works with WordPress 3.6
* Added: Added table heading tags for the cookie-cat table.

= 1.1 = 
* Added: admin interface to load a new customised XML file from cookie-cat.co.uk
* Added: will now produce links to prompt installation, upgrade or activation of oik
* Added: temp=N|Y parameter for the [cookies] shortcode to advanced users to play with the "Extras" field
* Added: option field to set browser=Y by default
* Added: Extras field for adding special codes for plugins which aren't really active. Defaults to ",wordpress,PHP"
* Changed: cc_mapping.xml file updated to reflect latest mapping in cookie-cat.co.uk
* Changed: readme.txt file contains basic instructions for updating the XML mapping file. New screenshots.
* Changed: Minor changes to tracing

= 1.0 =
* initial version. Works with oik version 1.13

== Further reading ==
If you want to read more about the oik plugins then please visit the
[oik plugin](http://www.oik-plugins.com/oik) 
**"the oik plugin - for often included key-information"**


== DISCLAIMER ==
This version of the plugin is provided free of charge to the WordPress community.
Its purpose is to help with the creation of your cookie catalog. 
We accept no responsibility for ensuring the correctness of the information displayed.
Don't have a go at us if your cookies are not listed or are "unknown".


