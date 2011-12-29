=== Simple Local Avatars ===
Contributors: jakemgold, 10up, thinkoomph
Donate link: http://get10up.com/plugins/simple-local-avatars-wordpress/
Tags: avatar, gravatar, user photos, users, profile
Requires at least: 3.2
Tested up to: 3.3
Stable tag: 1.3.1

Adds an avatar upload field to user profiles if the current user has media permissions. Generates requested sizes on demand just like Gravatar!


== Description ==

Adds an avatar upload field to user profiles if the current user has media permissions. Generates requested sizes on demand just like Gravatar! Simple and lightweight.

Just edit a user profile, and scroll down to the new "Avatar" field. The plug-in will take care of cropping and sizing!

Unlike other avatar plug-ins, Simple Local Avatars:

1. Stores avatars in the "uploads" folder where all of your other media is kept
1. Has a simple, native interface
1. Fully supports Gravatar and default avatars if no local avatar is set for the user
1. Generates the requested avatar size on demand (and stores the new size for efficiency), so it looks great, just like Gravatar!
1. Let's you decide whether lower privilege users (subscribers, contributors) can upload their own avatar


== Installation ==

1. Install easily with the WordPress plugin control panel or manually download the plugin and upload the extracted folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. If you only want users with file upload capabilities to upload avatars, check the applicable option under Settings > Discussion
1. Start uploading avatars by editing user profiles!

Use avatars in your theme using WordPress' built in `get_avatar()` function: [http://codex.wordpress.org/Function_Reference/get_avatar](http://codex.wordpress.org/Function_Reference/get_avatar "get_avatar function")

You can also use `get_simple_local_avatar()` (with the same arguments) to retreive local avatars a bit faster, but this will make your theme dependent on this plug-in.


== Screenshots ==

1. Avatar upload field on a user profile page


== Changelog ==

= 1.3.1 =
* Brazilian Portuguese and Belarusian translations
* Bug fixes (most notably correct naming of image files based on user display name)
* Optimization for WordPress 3.2 / 3.3 (substitutes deprecated function)

= 1.3 =
* Avatar file name saved as "user-display-name_avatar" (or other image extension) 
* Russian localization added
* Assorted minor code optimizations

= 1.2.4 =
* Support for front end avatar uploads (e.g. Theme My Profile)

= 1.2.3 =
* Russian localization

= 1.2.2 =
* Fix for avatars uploaded pre-1.2.1 having a broken path after upgrade

= 1.2.1 =
* French localization
* Simplify uninstall code

= 1.2 =
* Fix path issues on some IIS servers (resulting in missing avatar images)
* Fix rare uninstall issues related to deleted avatars
* Spanish localization
* Other minor under the hood optimizations

= 1.1.3 =
* Properly deletes old avatars upon changing avatar
* Fixes "foreach" warning in debug mode when updating avatar image

= 1.1.2 =
* Norwegian localization

= 1.1.1 =
* Italian localization

= 1.1 =
* All users (regardless of capabilities) can upload avatars by default. To limit avatar uploading to users with upload files capabilities (Authors and above), check the applicable option under Settings > Discussion. This was the default behavior in 1.0.
* Localization support; German included


== Upgrade Notice ==

= 1.3.1 =
Like WordPress 3.2, now *REQUIRES* PHP 5.2 or newer.