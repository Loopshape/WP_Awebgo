=== WCP Contact Form ===
Contributors: webcodin
Tags: contact, contact form, form, contact me, contact us, contactus, contact form plugin, email, email message, notifications, admin notifications, customer notifications, customer, form to email, wordpress contact form, subscribe, CSV, CSV export, form builder, builder, captcha, validation, dynamic fields, LESS, dynamic CSS, reCAPTCHA, indicator
Requires at least: 3.5.0
Tested up to: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Stable tag: trunk

The contact form plugin with dynamic fields, reCAPTCHA and other features that makes it easy to add custom contact form on your site in a few clicks

== Description ==

Main feature of our contact form is ready-to-use set of the fields includes CAPTCHA, that you can immediately use after installation.

All that you need it is install plugin, check form settings and add contact form in two ways:

1. As shortcode via TinyMCE toolbar button;
2. As widget to a page sidebar.

As additional options of the contact form, you can find dynamic fields with various types, custom form styles and notifications for administrator and users.

You can find [live demo](http://wpdemo.webcodin.com/stay-in-touch/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.

If you find issues or have any questions about the plugin, please feel free to ask questions in the [Support Tab](http://wordpress.org/support/plugin/wcp-contact-form), directly via our [demo site](http://wpdemo.webcodin.com/stay-in-touch/) or use following email address support@webcodin.com.

= Features =

* Ready-to-use fields preset after plugin instalation;
* Dynamic form fields with various parameters that can be reordered and deleted;
* Inbox page for message list with read/unread statuses and single detailed page for each message;
* Optional "Thank You" page that can be chosen from list of the existing pages;
* Optional HTML5 validation and editable error messages for non-HTML5 validation;
* Auto notifications for users and administrator with variables for notification letters;
* List of the messages can be exported to CSV format based on selected fields in the form settings;
* Minimum required PHP version is **5.3.0**;
* Custom styles for contact form;
* Drag&Drop re-order of the form fields for configurator;
* Success notification message after the form submission for form without "Thank You" page. 
* reCAPTCHA field support;
* Visual indicator for the new messages at the admin toolbar.
* Optional ability to enqueue scripts and styles only for the pages with contact form
* **NEW!** "Quick Reply" button to the Inbox (message list) and form details page that allows to open standard mail client and send quick reply to sender.
* **NEW!** Option for reCAPTCHA translation that based on default WordPress language that defined in the admin panel

= Ready-to-Use Fields Preset =

Ready-to-use fields preset after plugin instalation includs following fields: 

`Name, Email, Phone, Subject, Message, CAPTCHA`

= Dynamic Form Fields =

Dynamic form fields include following field types: 

`Text, Email, Numeric, Textarea, Checkbox, CAPTCHA, reCAPTCHA`

and support following parameters: 

`Type, Name, Visibility, Required, Export to CSV`

= Form Styling =

Contact form fields can be styled with following options:

* Border: size, style and color or no-border;
* Background color or no-background;
* Text color inside fields;
* Fields labels color;
* Button text and background colors.

= For Developers =

Developers have the possibility to customize the plugin by creating a duplicate templates and styles in the active theme folder.

More information and documentation can be found in the section [screenshots](https://wordpress.org/plugins/wcp-contact-form/screenshots/), [FAQ](https://wordpress.org/plugins/wcp-contact-form/faq/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.
 
= Notes =

* **Beware!** If you DELETE any field from existed form configuration all received data for this field won't be available for existed messages without possibility to restore.
* **NB!** If you use more than one email field you need to define field that will be used for user notification: "Contact Form" > "Settings" > "Notifications" > "User Notifications" > "User Email Field". By default, will be used first email field. Also, for properly work of user notifications email field should be required.
* **NB!** If use own fielsd set rater than default preset, please define fields for email and user name that will be used for email notifications in the "Contact Form" > "Settings" > "Notifications" > "General Settings".
* **NB!** Form uses standard WordPress [wp_mail()](https://codex.wordpress.org/Function_Reference/wp_mail) function for messages submission. If you have issues with notification receiving, try to use some third-party plugin for mail settings.
* **NB!** "Reset to default" button on the Settings page reset all tabs to default values includes form fields


== Installation ==

1. Download a copy of the plugin.
2. Unzip and Upload 'wcp-contact-form' to a sub directory in '/wp-content/plugins/'.
3. Activate the plugins through the 'Plugins' menu in WordPress.

= 3 easy steps to start using of our contact form on a page =

1. Check plugin "Contact Form" > "Settings" page and customize form options for your purposes;
2. Create new page or use existed;
3. Add shortcode via TinyMCE toolbar button and save the page.

... and that is all! You have a fully working contact form on your site page. New messages can be found in "Contact Form" > "Inbox".

= 3 easy steps to start using of our contact form at a sidebar =

1. Check plugin "Contact Form" > "Settings" page and customize form options for your purposes;
2. Go to the "Appearance" > "Widgets" sections;
3. Add "WCP Contact Form" to necessary sidebar. 

... and that is all! You have a fully working contact form at the sidebar on your site. New messages can be found in "Contact Form" > "Inbox"

More information and documentation can be found in the section [screenshots](https://wordpress.org/plugins/wcp-contact-form/screenshots/), [FAQ](https://wordpress.org/plugins/wcp-contact-form/faq/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.

== Frequently Asked Questions ==

= How can I add a form to a page =

To create a new page for the contact form, go to the menu "Pages" > "Add New". 
After filling all needed fields, add contact form shordcode via TinyMCE toolbar button and save the page.
As a result, ready-to-use form will appear on page with default configuration.

Also, the contact form can be added to an existing page. 
To do this, go to the menu "Pages" > "All Pages". Open for editing the necessary page and add contact form shordcode via TinyMCE toolbar button and save the page. 

More information can be found in the section [screenshots](https://wordpress.org/plugins/wcp-contact-form/screenshots/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.

= How can I add a form to a sidebar =

Go to the "Appearance" > "Widgets" sections.
Add "WCP Contact Form" to necessary sidebar, change sidebar title if you need and press "Save" button.

More information can be found in the section [screenshots](https://wordpress.org/plugins/wcp-contact-form/screenshots/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.

= I can't find button in TinyMCE toolbar for shortcode adding =

Go to menu "Contact Form" > "Settings" > "Form" tab > "Other Settings" section. Option "TinyMCE Support" should be enabled.
If this option is enabled, but you doesn't TinyMCE toolbar button after the page refresh, please let us know about this issue in the [Support Tab](http://wordpress.org/support/plugin/wcp-contact-form) or directly via [our site](http://wpdemo.webcodin.com/stay-in-touch/).
Also, you can manually add following shordcode into the TinyMCE editor area: [wcp_contactform id="wcpform_1"].

More information can be found in the section [screenshots](https://wordpress.org/plugins/wcp-contact-form/screenshots/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.  

= Where can I find received messages =

To view the list of received messages go to the menu "Contact Form" > "Inbox".
New messages are marked automatically as Unread. There is also automatic filtering for Read and Unread messages.
When you delete a message it goes to the "Trash". Deleted message is recoverable or can be completely removed.
You can use Mark as Read, Mark as Unread, Move to Trash actions on each message or the group.
Also on this page you able to export messages to CSV format by pressing on "Export to CSV" button.
Click on the name of the letter to review the letter details.

More information can be found in the section [screenshots](https://wordpress.org/plugins/wcp-contact-form/screenshots/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.

= How can I to configure form fields =

To configure form fields go to the menu "Contact Form" > "Settings" tab "Form".
In the "Fields Settings" section will be available settings for the form fields.
Form supports following field types: text, email, numeric, textarea, checkbox and CAPTCHA.
Each field has following available parameters for configuration: 

* **type** - allows to choose field type from preset;
* **name** - allows to define field label for displaying; 
* **visibility** - allows to enable/disable field visibility; 
* **required** - allows to make field required;
* **export to CSV** - allows to add field to CSV export.
 
When you configured all necessary fields, press the "Save Changes" button at the bottom of the page.

More information can be found in the section [screenshots](https://wordpress.org/plugins/wcp-contact-form/screenshots/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.

= How can I customize "Send" button text? =

To change Send button, go to menu "Contact Form" > "Settings" > "Form" tab > "Send Button" section. 
Following options are available:

* **Caption** - option allows to change submit button text;

More information can be found in the section [screenshots](https://wordpress.org/plugins/wcp-contact-form/screenshots/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.

= How can I use own "Thank You" page? =

To choose own Thank You page, go to menu "Contact Form" > "Settings" > "Form" tab > "Thank You Page" section. 
Following options are available:

* **Select Page** - option allows to set "Thank You" page from the list of existed pages 	

= How can I enable HTML5 validation? =

To eneble HTML5 validation, go to menu "Contact Form" > "Settings" > "Form" tab > "Other Settings" section and check "Enable HTML5 Validation" checkbox.

More information can be found in the section [screenshots](https://wordpress.org/plugins/wcp-contact-form/screenshots/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.

= How can I style contact form =

To style contact form, go to menu "Contact Form" > "Settings" > "Style" tab
In this tab following options are avialable:

**Submit Button**

* **Background Color** - option allows to change background color of the "Submit" button
* **Text Color** - option allows to change text color of the "Submit" button; 

More information can be found in the section [screenshots](https://wordpress.org/plugins/wcp-contact-form/screenshots/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.

**Fields Style**

* **Label Color** - option allows to change color of field labels (labels are displayed above the form fields);
* **Text Color** - option allows to change field text color inside the form fields;
* **No Border** - option allows to disable border around the form fields;
* **Border Size** - option allows to set size of the border around the form fields (positive digital value with "px");
* **Border Style** - option allows to set style of the border around the form fields;
* **Border Color** - option allows to set color of the border around the form fields;
* **No Background** - option allows to disable background inside the form fields;
* **Background Color** - option allows to set background color inside the form fields;

More information can be found in the section [screenshots](https://wordpress.org/plugins/wcp-contact-form/screenshots/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.

= How can I change validation error messages? =

To change non-HTML5 validation error messages, go to menu "Contact Form" > "Settings" > "Messages" tab > "Error Messages" section.
Following options are available:

* **Submit Success** - option allows to set error message for "required" fields;
* **Email Field** - option allows to set error message for "email "fields;
* **Captcha Field** - option allows to set error message for "CAPTCHA" field;
* **Number Field** - option allows to set error message for "number" fields.

More information can be found in the section [screenshots](https://wordpress.org/plugins/wcp-contact-form/screenshots/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.

= How can I change "Submit Success" message? =

To change "Submit Success" message for forms without "Thank You" page, go to menu "Contact Form" > "Settings" > "Messages" tab > "Notification Messages" section.
Following option is available:

* **Submit Success** - option allows to set submit success message for the form.

More information can be found in the section [screenshots](https://wordpress.org/plugins/wcp-contact-form/screenshots/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.

= How can I change administrator notifications? =

To change administrator notifications, go to menu "Contact Form" > "Settings" > "Notifications" tab > "Admin Notifications" section.
Following options are available:

* **Send to Email** - option allows to set administrator email address for notifications.
* **Subject** - option allows to set default subject of administrator notification message;
* **Message** - option allows to set default text of administrator notification message; 
* **Disable Admin Notifications** - option allows to disable notifications of new form submissions. 

= How can I change user notifications? =

To change user notifications, go to menu "Contact Form" > "Settings" > "Notifications" tab > "User Notifications" section.
Following options are available:

* **Subject** - option allows to set default subject of user notification message;
* **Message** - option allows to set default text of user notification message.
* **Disable User Notifications** - option allows to disable notifications for successful form submission. 

= How can I set notifications variables for Email and User Name, if I use a custom set of the fields? =

To change user notifications, go to menu "Contact Form" > "Settings" > "Notifications" tab > "General Settings" section.
If you use a custom set of the fields, you need to define manually following variables for properly work of the email notifications to users:

* **User Email Field** - option allows to set default field for user notification if you use more than one email field in the contact form;
* **User Name Field** - option allows to set default field for {$user_name} variable in the contact form;


= How can I export data to CSV =

To export the list of received messages go to the menu "Contact Form" > "Entries".
Press button "Export to CSV" at the top of the message list. All fiels that were defined as "Export to CSV" at the form settings ("Contact Form" > "Settings" > "Form" tab) will be exported to CSV format.

More information can be found in the section [screenshots](https://wordpress.org/plugins/wcp-contact-form/screenshots/) and [plugin documentation](http://wpdemo.webcodin.com/wordpress-plugin-wcp-contact-form/documentation/getting-started/) on our site.

= How can I style the form content? =

The plugin includes CSS file "assets/css/style.css".
You can copy this file in your active theme and customize it for your needs.
Path to the styles inside the active theme:

[ActiveTheme]/templates/wcp-contact-form/assets/css/style.css

= How can I change the form content? =

The plugin includes some templates in "templates/" folder. 
You can copy any template in your active theme and customize it for your needs. 
Path to the templates folder inside the active theme:

[ActiveTheme]/templates/wcp-contact-form/


== Screenshots ==

1. Form Sample
2. Form Sample :: Widget
3. Form Sample :: Custom Styles
4. Form Shordcode with TinyMCS toolbar button
5. Form Widget
6. Inbox
7. Inbox :: Group Actions
8. Inbox :: Detail
9.  Admin Panel :: Settings :: Form Tab :: Default Configuration
10. Admin Panel :: Settings :: Form Tab :: Custom Configuration
11. Admin Panel :: Settings :: Style Tab
12. Admin Panel :: Settings :: Errors Tab
13. Admin Panel :: Settings :: Notifications
14. Admin Panel :: Settings :: reCAPTCHA 

== Changelog ==
= 2.3.8 =
* fixed: Fixed issue with multiple form submit for some site configurations
* added: Added ability to change background / text colors on hover for "Submit" button via plugin settings

= 2.3.7 =
* minor changes

= 2.3.6 =
* added: Check of the minimum required PHP version on a server
* added: Lock of the "Submit" button during form submission

= 2.3.5 =
* added: "Quick Reply" button to the Inbox (message list) and form details page that allows to open standard mail client and send quick reply to sender.
* added: Option for reCAPTCHA translation that based on default WordPress language that defined in the admin panel
* minor changes in plugin core

= 2.3.4 =
* minor bugfixing

= 2.3.3 =
* minor bugfixing

= 2.3.2 =
* minor bugfixing

= 2.3.1 =
* added: Optional ability to enqueue scripts and styles only for the pages with contact form
* changed: Minor loading speed optimization

= 2.3.0 =
* added: New reCAPTCHA field for the form
* added: Indicator for unread inbox messages in admin toolbar
* minor styles changes
* minor bugfixing

= 2.2.0 =
* added: LESS-based dynamic CSS for custom form styles
* added: Drag&Drop re-order for fields configurator
* added: Success notification message after the form submission for form without "Thank You" page
* added: Ability to change type of the fields in the default fields preset
* added: New parameter "Submit Success" that allows to set submit success message for the form
* changed: Caption of the "Errors" tab changed to "Messages" value on the form settings page

= 2.1.3 =
* fixed: Issue with duplicate email notifications

= 2.1.2 =
* added: new parameter "Button Position" that allows to set submit button position

= 2.1.1 =
* added: filter hook 'wcp_contact_form_get_fields_settings' for developer needs
* added: new notifications varable **{$user_email}**
* added: setting for default "User Name" field for user notification variables

= 2.1.0 =
* added: new friendly "[wcp_contactform]" shortcode that can used instead "[scfp]"
* changed: now "id" parameter is not necessary for single shortcode on a page
* added: button in a TinyMCE editor that allows to add contact form in editor area by one click
* changed: layout of the "Settings" page
* added: notes for a parameters on the "Settings" page tabs
* added: possibility to form style customization 
* updated plugin documentation

= 2.0.1 =
* changed: "Refresh" button styling for CAPTCHA field 
* minor styles changes

= 2.0.0 =
* global changes of the plugin core and templates structure. **Beware!** You can have issues if you make some customization in the form templates manually by code!;
* added possibility to dynamic setup of the form fields. Fields can be added, deleted and reordered;
* added following field types: numeric, checkbox;
* added export to CSV format;
* added setting for default user notification email for forms with multiple email fields;
* added additional error message for numeric field type;
* Fixed: Issue with fatal error when trying to activate plugin for PHP 5.3;
* Fixed: Issue for AJAX request with enabled Zlib-compression;

= 1.2.0 =
* global changes of the plugin core;

= 1.1.0 =
* added form widget;
* added optional CAPTCHA field and editable error message;
* added ability to reset form options to default;
* added variables for notification messages;
* general cleanup and optimization;

= 1.0.0 =
* initial release.
