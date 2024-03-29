=== WP Fastest Cache ===
Contributors: emrevona
Donate link: http://profiles.wordpress.org/emrevona/
Tags: cache, performance, wp-cache, total cache, super cache
Requires at least: 3.3
Tested up to: 4.5
Stable tag: 4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The simplest and fastest WP Cache system

== Description ==

<h4>Official Website</h4>

You can find more information on our web site (<a href="http://www.wpfastestcache.com/">wpfastestcache.com</a>)

This plugin creates static html files from your dynamic WordPress blog.
When a page is rendered, php and mysql are used. Therefore, system needs RAM and CPU. 
If many visitors come to a site, system uses lots of RAM and CPU so page is rendered so slowly. 
In this case, you need a cache system not to render page again and again.
Cache system generates a static html file and saves. Other users reach to static html page.
<br><br>
Setup of this plugin is so easy. You don't need to modify the .htacces file. It will be modified automatically.

<h4>Multisite Support</h4>
Wpfc does not support Wordpress Multisite yet.

<h4>Features</h4>

1. Mod_Rewrite which is the fastest method is used in this plugin
2. All cache files are deleted when a post or page is published
3. Admin can delete all cached files from the options page
4. Admin can delete minified css and js files from the options page
5. Block cache for specific page or post with Short Code
6. Cache Timeout - All cached files are deleted at the determinated time
7. Cache Timeout for specific pages
8. Enable/Disable cache option for mobile devices
9. Enable/Disable cache option for logged-in users
10. SSL support
11. CDN support
12. Preload Cache - Create the cache of all the site automatically
13. Exclude pages and user-agents

<h4>Performance Optimization</h4>

1. Generating static html files from your dynamic WordPress blog
2. Minify Html - You can decrease the size of page
3. Minify Css - You can decrease the size of css files
4. Enable Gzip Compression - Reduce the size of files sent from your server to increase the speed to which they are transferred to the browser.
5. Leverage browser caching - Reduce page load times for repeat visitors
6. Combine CSS - Reduce number of HTTP round-trips by combining multiple CSS resources into one
7. Combine JS

<h4>Supported languages: </h4>

* 中文 (by suifengtec)
* Deutsch
* English
* Español (by Diplo)
* Français (by PascalJ)
* Italiana (by Valerio)
* 日本語 (by KUCKLU)
* Nederlands (by Frans Pronk https://ifra.nl)
* Polski (by roan24.pl)
* Português
* Română
* Русский (by Maxim)
* Suomi (by Arhi Paivarinta)
* Svenska (by Linus Wileryd)
* Türkçe

== Installation ==

1. Upload `wp-fastest-cache` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Permission of .htacces must 644
4. Enable this plugin on option page

== Screenshots ==

1. Performance Comparison
2. Without Cache
3. With Cache
4. Main Page
5. Delete All File Page
6. All cached files are deleted at the determinated time
7. Block caching for post and pages (TinyMCE)
8. Clean cached files via admin toolbar easily
9. Exclude page
10. CDN

== Changelog ==

= 0.8.6.0 =
* to fix the problem about replacing url after minify css
* to add "start with" option to the cache timeout
* to add uninstall feature
* to add "user-agent" option to the exclude page
* to convert cache time to local time
* to exclude WhatsApp user-agent

= 0.8.5.9 =
* to remove X-Wap-Profile from htaccess
* to show warning lightbox if the cache cannot be deleted
* <strong>[FEATURE]</strong> Set preload number
* refactoring of is_wptouch_smartphone()
* <strong>[FEATURE]</strong> to clear only the homepage cache
* wp nonces added for security

= 0.8.5.8 =
* to remove hostname from exclude rule
* to fix file cache problem
* to change the mobile user-agents
* to fix Wordfence Security report

= 0.8.5.7 =
* <strong>[FEATURE]</strong> Preload
* to exclude the renamed page of woocommerce
* to fix path which starts with ./ in css files
* <strong>[FEATURE]</strong> Compatible with Visual Composer Post Grid
* application/x-javascript has been added for leverage browser caching
* to prevent removing newlines from .htaccess
* <strong>[FEATURE]</strong> Compatible with WP-CLI
* to add wp-touch mobile user-agent list
* to exclude facebookexternalhit user-agent
* <strong>[FEATURE]</strong> Compatible with Any Mobile Theme Switcher
* <strong>[FEATURE]</strong> CDN for css files
* to fix the huge size of tmpWpfc problem

= 0.8.5.6 =
* to combine css files by media attribute
* to fix lots of disk usage issue
* to fix design broken which occours after some time
* to fix PHP Notice:  Undefined index: HTTP_ACCEPT
* to fix WP-Polls issue if PHP v5.6
* to remove ï»¿
* <strong>[FEATURE]</strong> to add Polish language
* <strong>[FEATURE]</strong> to add CDN77
* to get the source of fonts.googleapis.com
* new style of Exclude Page
* to set cache timeout for specific pages
* gzip for woff type
* to fix "unknown error" of AWS cdn integration
* <strong>[FEATURE]</strong> chinese language has been added
* <strong>[FEATURE]</strong> Compatible with WP-PostRatings
* to add WPFC_TOOLBAR_FOR_AUTHOR
* to fix combine css issue if a file is empty after minify
* to add woff2 for browser caching
* to disable creating cache if get_option("home") is secure and current url is not secure
* to fix switching theme from mobile to desktop on wptouch
* to remove carriage return (^M)
* <strong>[FEATURE]</strong> Finnish language has been added
* <strong>[FEATURE]</strong> Nginx support
* to use case-insensitive file system for browser caching
* WAP-Browser has been added into mobile user agent list
* to prevent 404 error for wpfc-minified after clearing minified files
* <strong>[FEATURE]</strong> to add any cdn provider
* <strong>[FEATURE]</strong> WPFC_DELETE_ALL_CACHE_AFTER_UPDATE has been added
* to prevent from xss attacks (Brendon Boshell)
* to clear the cache of homepage after update static page
* to clear the cache of homepage after update sticky page
* to clear the cache of homepage after update post which appears on homepage

= 0.8.5.5 =
* to add Amazon CloudFront CDN
* to add KeyCDN
* to update Russian Language
* to fix PHP Notice: Undefined index: HTTP_USER_AGENT
* to fix PHP Notice: Undefined index: name
* to fix combine js issue with commented out js
* to fix delete minify files issue
* to add image/svg+xml for leverage browser cache
* refactoring of minify and combine css features
* to fix redirection to /wp-content/cache/all for ssl
* to add text for toolbar icon

= 0.8.5.4 =
* to be compatible with Guideline

= 0.8.5.3 =
* to check zlib extension for downloading premium automatically
* to update Portuguese and Turkish languages
* to be compatible with sub-directory installation with renamed wp-content
* refactoring of js-utilities.php
* to fix delete comment issue

= 0.8.5.2 =
* to replace https:// and http:// to // after converting inline css to link
* to replace https:// and http:// to // after converting inline js to link
* to ignore the empty css files
* to optimize exclude page feature
* to fix mobile cache issue for ipad user if wp touch is used
* to prevent caching js files whose type is text/template
* to update Portuguese language

= 0.8.5.1 =
* <strong>[FEATURE]</strong> to add MaxCDN
* to remove comments from inline js
* to fix trim() issue
* to be compatible with Leaflet Maps Marker

= 0.8.5.0 =
* to prevent combine js file which is added by WP Socializer
* to make ruleForWpContent() pasive
* refactoring of inlineToScript()
* <strong>[FEATURE]</strong> Romanian has been added

= 0.8.4.9 =
* <strong>[FEATURE]</strong> to be compatible with WP Mobile Edition
* to prevent from sql injection attacks (Kacper Szurek)
* to prevent using Head Cleaner

= 0.8.4.8 =
* to show .htaccess rules if not writeable
* not to comment out Facebook js
* not to comment out document.createElement('script')
* not to minify and combine style and js codes in noscript tag

= 0.8.4.7 =
* to update Portuguese language
* to make compatible with Google Adsense plugin
* to add user-agent of Samsung S5, LG and HTC

= 0.8.4.6 =
* to add popup warning modal for premium download
* to remove mobile cache after update post

= 0.8.4.5 =
* wpfcNOT is visible only for admins
* to prevent creating cache for POST request
* to fix issue of converting inline js to internal file

= 0.8.4.4 =
* to fix inline css issue
* to prevent caching for renamed wp-login.php

= 0.8.4.3 =
* to stop caching for /wp-api/v1, /cart, /checkout, /receipt, /confirmation, /product - WooCommerce
* to prevent caching if useragent Mediapartners-Google
* to decrease pcre.recursion_limit in css optimization to prevent Internal Server Error

= 0.8.4.2 =
* to fix premium page issue

= 0.8.4.1 =
* exclude page is case insensitive
* to check buffer is json or not for checkWoocommerceSession()
* not to comment out Google Analytics by Yoast

= 0.8.4.0 =
* refactoring of checkHtml()

= 0.8.3.9 =
* other plugins can use the functions
* to put ";" at the end of js file if last char is not ";"
* to make compatible renamed wp-content sites

= 0.8.3.8 =
* to prevent using GZip Ninja Speed Compression
* to prevent using GZIP Output
* to show success message after saving exclude page
* style of left panel
* opera mini has been added into mobile user agent list
* to fix download premium version issue

= 0.8.3.7 =
* to prevent confliction on left menu
* to fix error and success message icon

= 0.8.3.6 =
* MIDP has been added into mobile user agent list

= 0.8.3.5 =
* to fix vulnerability (discoverd by 0pc0deFR aka Kevin FALCOZ)
* to fix issue of moving chartset to the top
* to prevent combine Google Fonts javascripts
* <strong>[FEATURE]</strong>  exclude page

= 0.8.3.4 =
* to prevent inline to external if the style is used in the javascript
* to prevent creating cache for xmlrpc.php
* to fix white page issue because of combine css and js
* icons for premium version

= 0.8.3.3 =
* WPtouch issue has been solved
* improvement of cache delete
* to add ";" at the end of JS file if it does not exist

= 0.8.3.2 =
* to prevent comment out google analitics code
* refactoring of isPasswordProtected()
* the clear cache button on toolbar is available for editors

= 0.8.3.1 =
* index.html files have been added intead of .htaccess
* to prevent comment out inline js rules twice
* <strong>[FEATURE]</strong>  to add delete button on the admin bar
* to fix url() problem for data:image/svg+xml

= 0.8.3.0 =
* to fix <!--[wpfcNOT]--> issue of text to visual
* refactoring of redirect rule
* to prevent the directory access
* to prevent from xss attacks (Kacper Szurek)

= 0.8.2.9 =
* to fix 301 redirection issue of sub-folder
* to support non-english characters on search

= 0.8.2.8 =
* to prevent caching wp-login.php if renamed
* to prevent caching if the page has a contactform7 form with captcha
* to prevent caching for ajax call

= 0.8.2.7 =
* to implement single post cache deletion when a post/page is modified
* <strong>[FEATURE]</strong> to implement new frequency values for cache timeout
* html corrupted warning has been added
* to make compatible with WooCommerce Themes
* to prevent combine inline css if commented out

= 0.8.2.6 =
* to fix sub-domain redirect issue with www
* to prevent caching of sitemap.xml
* to fix getting error when .htaccess is not found
* to improve combine css
* to prevent caching wp-comments-post.php
* to prevent combine comment out js files
* to prevent caching js files whose type is application/ld+json
* style changes of delete cache panel
* to fix php warning which is Invalid argument supplied for foreach()
* to fix "File not found" message when trying to leave a comment

= 0.8.2.5 =
* to prevent converting style rules to link more than once
* to clear cache after admin writes a comment
* to clear cache if comment has not ben manually approved 
* to disable minute and hour when hourly is selected
* to show both time when twice daily is selected on cache timeout panel

= 0.8.2.4 =
* rewrite rule issue has been solved
* to remove empty chars from url()
* to add media type for inline css after minify

= 0.8.2.3 =
* to support setting hour and minute as a 0
* to fix server time NaN
* to check the length of inline css for combine css
* to support selecting the css files which do not include home_url()
* to support selecting the js files which do not include home_url()
* publish_page to save_post

= 0.8.2.2 =
* to minify css files which are NOT "media='all'"
* to support selecting the css files which do not include home_url()
* to insert define('WP_CACHE', true) into wp-config.php for wp-postviews
* to fix PHP Warning: Missing argument 2 for CssUtilities::minifyCss()
* to fix PHP Warning: scandir warning

= 0.8.2.1 =
* to support WP-PostViews
* tab of minified css and js has been removed
* warning about Microsoft IIS has been added
* to prevent minify and combine css if returns 404
* to prevent combine js if returns 404
* warning about Multisite has been added

= 0.8.2.0 =
* warning of regular expression is too large has been added
* <strong>[FEATURE]</strong> to be able to choose specific time
* js and css merging is not beta anymore

= 0.8.1.9 =
* to delete cachen when page is edited or published
* warning of DONOTCACHEPAGE has been added
* file_get_contents_curl() issue for the files which start with //
* to combine the css files which has media="all" attribute
* to fix re-write rule for sub-directory installation
* <strong>[FEATURE]</strong> to prevent 304 browser caching to see new post
* <strong>[FEATURE]</strong> wpfcNOT works for pages as well except the themes
* the warning has been added for empty buffer

= 0.8.1.8 =
* to fix disable the plugin
* to check permalinks was set or not
* modified of deletion of minified files' warning
* to fix inserting extra comment tag

= 0.8.1.7 =
* wp-polls issue
* cache timeout issue
* minify css issue for data:application/x-font-woff

= 0.8.1.6 =
* optimization of deletion cache
* creating cache problem when combine css is unchecked

= 0.8.1.5 =
* <strong>[FEATURE]</strong> JS Combine
* to check that super cache is active or not
* to check that better wordPress minify is active or not
* <strong>[FEATURE]</strong> french translation

= 0.8.1.4 =
* to prevent creating cache for logged-in users
* gzip for svg, x-font-ttf, vnd.ms-fontobject, font/opentype font/ttf font/eot font/otf
* stlye files issue with https
* <strong>[FEATURE]</strong> Keep Alive
* compatible with @import "style.css";
* <strong>[FEATURE]</strong> italian language has been added

= 0.8.1.3 =
* to support renamed wp-content

= 0.8.1.2 =
* to fix combine css breaking css down
* the password protected posts are not cached
* change of minified css file name

= 0.8.1.1 =
* to show which style files are combined
* to fix the minify css issue
* to fix minify css breaking css down

= 0.8 =
* <strong>[FEATURE]</strong> Supports "Subdirectory Install"
* <strong>[FEATURE]</strong> SSL support
* <strong>[FEATURE]</strong> Leverage browser caching has been added
* GZippy warning has been added
* Path issue of rewrite rules has been solved
* to prevent create cache for mobile devices
* <strong>[FEATURE]</strong> Enable/Disable cache option for logged-in users has been added
* Improvement of Turkish and Spanish translation
* Issue of subdirectory install using with subdirectory url
* Double slash in the rewrite rule problem has been solved
* Full path is written instead of %{DOCUMENT_ROOT}
* Stop to prevent not to minify css files which has small size
* Improvement of detection active plugins
* <strong>[FEATURE]</strong> "Combine Css" has been added
* Stop to prevent not to minify css files which has small size
* Improvement of detection active plugins
* <strong>[FEATURE]</strong> "Combine Css" has been added
* Improvement of combine css
* to prevent creating cache for the urls which has query string

= 0.7.9 =
* <strong>[FEATURE]</strong> Compatible with WP-Polls
* <strong>[FEATURE]</strong> Enable/Disable cache option for mobile devices has been added
* <strong>[FEATURE]</strong> "[wpfcNOT]" shortcode has been converted to the image
* Optimization of CSS minify
* r10.net support forum url has been added
* Some style changes
* to correct misspelling
* Icon has been changed
* <strong>[FEATURE]</strong> Portuguese language has been added
* <strong>[FEATURE]</strong> German language has been added
* Minify css issue has been solved
* <strong>[FEATURE]</strong> Blackberry PlayBook has been added into mobiles
* <strong>[FEATURE]</strong> www and non-www redirections have been added

= 0.7.8 =
* <strong>[FEATURE]</strong> Delete Minified Css & Js feature has been added
* Update of Spanish translation
* Update of Turkish translation
* Update of Russian translation
* Update of Ukrainian translation

= 0.7.7 =
* Optimization of CSS minify
* rmdir, mkdir and rename error_log problem
* modify .htaccess problem
* Update of Spanish translation
* Update of Turkish translation
* Update of Russian translation
* Update of Ukrainian translation

= 0.7.6 =
* <strong>[FEATURE]</strong> Gzip Compression

= 0.7.5 =
* Performance of delete all files is improved
* Rewrite rules of WPFC is removed from .htaccess when wpfc is deactivated
* CSS of Warnings has been changed

= 0.7.4 =
* Minify Css problem has been solved
* Info panel has been added
* Update of Spanish translation
* Update of Turkish translation
* Update of Russian translation
* Update of Ukrainian translation

= 0.7.3 =
* Info Tip has been added

= 0.7.2 =
* <strong>[FEATURE]</strong> Minify CSS files

= 0.7.1 =
* Delete Cron Job when the plugin is deactivated
* Delete from DB when the plugin is deactivated

= 0.7 =
* <strong>[FEATURE]</strong> works with Wordfence properly

= 0.6.9 =
* <strong>[FEATURE]</strong> 404 pages are not cached

= 0.6.8 =
* urls which includes words that wp-content, wp-admin, wp-includes are not cached
* The issue about cache timeout has been solved

= 0.6.7 =
* <strong>[FEATURE]</strong> Cache Timeout has been added

= 0.6.6 =
* <strong>[FEATURE]</strong> Spanish language has been added

= 0.6.5 =
* <strong>[FEATURE]</strong> Minify html

= 0.6.4 =
* <strong>[FEATURE]</strong> Supported languages: Russian, Ukrainian and Turkish

= 0.6.3 =
* <strong>[FEATURE]</strong> "Block Cache For Posts and Pages" has been added as a icon for TinyMCE and  Quicktags editor

= 0.6.2 =
* Cache file is not created if the file is exist

= 0.6.1 =
* Cached files are deleted after deactivation of the plugin

= 0.6 =
* Cached file is not updated after comment because of security reasons

= 0.5.9 =
* Checking corruption of html

= 0.5.8 =
* Creation time of file has been added

= 0.5.7 =
* "Not cached version" text has been removed

= 0.5.6 =
* Some style changes

= 0.5.5 =
* System works under sub wp sites

= 0.5.4 =
* Plugin URI has been added

= 0.5.3 =
* Dir path has been removed from not cached version 

= 0.5.2 =
* Some styles changes

= 0.5.1 =
* Some styles changes

= 0.5 =
* <strong>[FEATURE]</strong> Admin can delete all cached files from the options page
* <strong>[FEATURE]</strong> All cache files are deleted when a post or page is published
* <strong>[FEATURE]</strong> Blocking cache with Shortcode

== Frequently Asked Questions ==

= How do I know my blog is being cached? =
You need to refresh a page twice. If a page is cached, at the bottom of the page there is a text like "&lt;!-- WP Fastest Cache file was created in 0.330816984177 seconds, on 08-01-14 9:01:35 --&gt;".

= Does it work with Nginx? =
Yes, it works with Nginx properly.

= Does it work with IIS (Windows Server) ? =
No, it does not work with IIS.

= What does ".htaccess not found" warning mean? =
Wpfc does not create .htaccess automatically so you need to create empty one.

= How is "tmpWpfc" removed? =
When the cached files are deleted, they are moved to "tmpWpfc" instead of being deleted and a cron-job is set. Delete all files are so difficult for server so cron-job is set not to use a lot of CPU resources. Cron-job is set and it deletes 100 files every 5 minutes. When all files in "tmpWpfc" are deleted, cron-job is unset.

= How can stop caching for some pages? =
If you add &lt;!--[wpfcNOT]--&gt; into source coude, creating cache stops. You can find it on visual and text editor after opening Add New Post panel.

= Does Wpfc work with WPMU (Wordpress Multisite) properly? =
No. Wpfc does not support Wordpress Multisite yet.

= Does Wpfc work in "Subdirectory Install"? =
Yes. Wpfc supports "Subdirectory Install".

= Is this plugin compatible with Http Secure (https) ? =
Yes, it is compatible with Http Secure (https).

= Is this plugin compatible with Adsense? =
Yes, it is compatible with Adsense 100%.

= Is this plugin compatible with CloudFlare? =
Yes, it is compatible with CloudFlare 100%. If the "minify html" option is active on CloudFlare, the minify system removed the comment from html so you cannot see the comment of Wpfc at the bottom of the page and you cannot be sure that it works or not. In this case, you need to look at the style files. You can see the minified css files.

= Is this plugin compatible with WP-Polls? =
Yes, it is compatible with WP-Polls 100%.

= Is this plugin compatible with Bulletproof Security? =
Yes, it is compatible with Bulletproof Security 100%.

= Is this plugin compatible with Wordfence Security? =
Yes, it is compatible with Wordfence Security 100%.

= Is this plugin compatible with qTranslate? =
Yes, it is compatible with qTranslate 100%.

= Is this plugin compatible with WPtouch Mobile Plugin? =
Yes, it is compatible with WPtouch Mobile Plugin 100%.

= Is this plugin compatible with Any Mobile Theme Switcher Plugin? =
Yes, it is compatible with Any Mobile Theme Switcher Plugin 100%.

= Is this plugin compatible with WP-PostRatings? =
Yes, it is compatible with WP-PostRatings.

= Is this plugin compatible with AdRotate? =
No, it is NOT compatible with AdRotate.

= Is this plugin compatible with WP-PostViews? =
Yes, it is compatible with WP-PostViews. The current post views appear on the admin panel. The visitors cannot see the current post views. The developer of WP-PostViews needs to fix this issue.

= Is this plugin compatible with MobilePress? =
No, it is NOT compatible with MobilePress. We advise WPtouch Mobile.

= Is this plugin compatible with WooCommerce Themes? =
Yes, it is compatible with WooCommerce Themes 100%.

== Upgrade notice ==
....