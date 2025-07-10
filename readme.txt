=== Simple Local Avatars ===
Contributors:      jakemgold, 10up, thinkoomph, jeffpaul, faisal03
Donate link:       https://10up.com/plugins/simple-local-avatars-wordpress/
Tags:              avatar, gravatar, user photos, users, profile
Tested up to:      6.8
Stable tag:        2.8.4
License:           GPL-2.0-or-later
License URI:       https://spdx.org/licenses/GPL-2.0-or-later.html

Adds an avatar upload field to user profiles. Generates requested sizes on demand just like Gravatar!

== Description ==

Adds an avatar upload field to user profiles if the current user has media permissions. Generates requested sizes on demand just like Gravatar! Simple and lightweight.

Just edit a user profile, and scroll down to the new "Avatar" field. The plug-in will take care of cropping and sizing!

1. Stores avatars in the "uploads" folder where all of your other media is kept.
2. Has a simple, native interface.
3. Fully supports Gravatar and default avatars if no local avatar is set for the user - but also allows you turn off Gravatar.
4. Generates the requested avatar size on demand (and stores the new size for efficiency), so it looks great, just like Gravatar!
5. Lets you decide whether lower privilege users (subscribers, contributors) can upload their own avatar.
6. Enables rating of local avatars, just like Gravatar.

== Installation ==

1. Install easily with the WordPress plugin control panel or manually download the plugin and upload the extracted folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. If you only want users with file upload capabilities to upload avatars, check the applicable option under Settings > Discussion
1. Start uploading avatars by editing user profiles!

Use avatars in your theme using WordPress' built in `get_avatar()` function: [http://codex.wordpress.org/Function_Reference/get_avatar](http://codex.wordpress.org/Function_Reference/get_avatar "get_avatar function")

You can also use `get_simple_local_avatar()` (with the same arguments) to retrieve local avatars a bit faster, but this will make your theme dependent on this plug-in.

== Frequently Asked Questions ==

= Does Simple Local Avatars collect personal data of website visitors? =

No.  Simple Local Avatars neither collects, stores, nor sends any PII data of visitors or avatar users on the host site or to 10up or other services.

== Screenshots ==

1. Avatar upload field on a user profile page

== Changelog ==

= 2.8.4 - 2025-07-14 =
* **Changed:** Don't resize image if the full version already has the expected height/width (props [@ocean90](https://github.com/ocean90), [@jeffpaul](https://github.com/jeffpaul), [@faisal-alvi](https://github.com/faisal-alvi) via [#324](https://github.com/10up/simple-local-avatars/pull/324)).
* **Changed:** Bump WordPress "tested up to" version 6.8 (props [@qasumitbagthariya](https://github.com/qasumitbagthariya), [@dkotter](https://github.com/dkotter), [@jeffpaul](https://github.com/jeffpaul) via [#332](https://github.com/10up/simple-local-avatars/pull/332), [#334](https://github.com/10up/simple-local-avatars/pull/334)).
* **Changed:** Bump WordPress minimum from 6.5 to 6.6 (props [@qasumitbagthariya](https://github.com/qasumitbagthariya), [@dkotter](https://github.com/dkotter), [@jeffpaul](https://github.com/jeffpaul) via [#332](https://github.com/10up/simple-local-avatars/pull/332), [#334](https://github.com/10up/simple-local-avatars/pull/334)).
* **Security:** Bump `@sentry/node` from 8.38.0 to 8.52.0 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#325](https://github.com/10up/simple-local-avatars/pull/325)).
* **Security:** Bump `axios` from 1.7.7 to 1.8.4 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#330](https://github.com/10up/simple-local-avatars/pull/330)).
* **Security:** Bump `tar-fs` from 3.0.6 to 3.0.9 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#331](https://github.com/10up/simple-local-avatars/pull/331), [#336](https://github.com/10up/simple-local-avatars/pull/336)).
* **Security:** Bump `http-proxy-middleware` from 2.0.7 to 2.0.9 (props [@dependabot](https://github.com/apps/dependabot), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#335](https://github.com/10up/simple-local-avatars/pull/335)).

= 2.8.3 - 2024-11-18 =
* **Changed:** Only allow images that were uploaded by the same user be used when setting the avatar via a REST request (props [@dkotter](https://github.com/dkotter), [@justus12337](https://github.com/justus12337), [@faisal-alvi](https://github.com/faisal-alvi) via [#317](https://github.com/10up/simple-local-avatars/pull/317)).
* **Fixed:** Only allow image files to be set as the avatar in REST requests (props [@dkotter](https://github.com/dkotter), [@justus12337](https://github.com/justus12337), [@faisal-alvi](https://github.com/faisal-alvi) via [#317](https://github.com/10up/simple-local-avatars/pull/317)).
* **Security:** Bump `@10up/cypress-wp-utils` from 0.2.0 to 0.4.0, `@sentry/node` from 6.19.7 to 8.38.0, `@wordpress/env` from 9.2.0 to 10.11.0, `cypress` from 13.2.0 to 13.15.2, `cypress-mochawesome-reporter` from 3.6.0 to 3.8.2, `puppeteer-core` from 23.3.0 to 23.8.0 (props [@dkotter](https://github.com/dkotter) via [#319](https://github.com/10up/simple-local-avatars/pull/319)).

= 2.8.2 - 2024-11-12 =
* **Fixed:** Ensure dependencies are (actually) included properly in the release (props [@dkotter](https://github.com/dkotter) via [#316](https://github.com/10up/simple-local-avatars/pull/316)).

= 2.8.1 - 2024-11-12 =
* **Fixed:** Ensure dependencies are included properly in the release (props [@dkotter](https://github.com/dkotter) via [#315](https://github.com/10up/simple-local-avatars/pull/315)).

= 2.8.0 - 2024-11-12 =
**Note that this release bumps the minimum required version of WordPress from 6.4 to 6.5.**

* **Added:** Support for the WordPress.org plugin preview (props [@faisal-alvi](https://github.com/faisal-alvi), [@jeffpaul](https://github.com/jeffpaul) via [#297](https://github.com/10up/simple-local-avatars/pull/297)).
* **Changed:** Update PHP compatibility check to use `10up/wp-compat-validation-tool` (props [@Sidsector9](https://github.com/Sidsector9), [@jeffpaul](https://github.com/jeffpaul), [@faisal-alvi](https://github.com/faisal-alvi) via [#291](https://github.com/10up/simple-local-avatars/pull/291)).
* **Changed:** Bump Wordpress "tested up to" version 6.7 (props [@sudip-md](https://github.com/sudip-md), [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#310](https://github.com/10up/simple-local-avatars/pull/310), [#312](https://github.com/10up/simple-local-avatars/pull/312)).
* **Changed:** Bump WordPress minimum supported version to 6.5 (props [@sudip-md](https://github.com/sudip-md), [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#310](https://github.com/10up/simple-local-avatars/pull/310), [#312](https://github.com/10up/simple-local-avatars/pull/312)).
* **Fixed:** Ensure all strings are properly translated (props [@pedro-mendonca](https://github.com/pedro-mendonca), [@dkotter](https://github.com/dkotter) via [#295](https://github.com/10up/simple-local-avatars/pull/295)).
* **Fixed:** Properly handle malformed `simple_local_avatar` user data (props [@adekbadek](https://github.com/adekbadek), [@dkotter](https://github.com/dkotter), [@faisal-alvi](https://github.com/faisal-alvi) via [#302](https://github.com/10up/simple-local-avatars/pull/302)).
* **Security:** Run a user capability check before we clear the avatar cache (props [@dkotter](https://github.com/dkotter), [@truonghuuphuc](https://github.com/truonghuuphuc), [@Sidsector9](https://github.com/Sidsector9) via [#309](https://github.com/10up/simple-local-avatars/pull/309)).
* **Security:** Ensure REST API requests to set an avatar only allow existing attachment IDs to be used (props [@dkotter](https://github.com/dkotter), [@justus12337](https://github.com/justus12337), [@faisal-alvi](https://github.com/faisal-alvi) via [GHSA-wfjh-m788-w2c5](https://github.com/10up/simple-local-avatars/security/advisories/GHSA-wfjh-m788-w2c5)).
* **Security:** Bump `axios` from 1.6.7 to 1.7.4 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#298](https://github.com/10up/simple-local-avatars/pull/298)).
* **Security:** Bump `webpack` from 5.90.0 to 5.94.0 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#303](https://github.com/10up/simple-local-avatars/pull/303)).
* **Security:** Bump `ws` from 7.5.10 to 8.18.0 and `@wordpress/scripts` from 27.1.0 to 30.4.0 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#305](https://github.com/10up/simple-local-avatars/pull/305), [#311](https://github.com/10up/simple-local-avatars/pull/311)).
* **Security:** Bump `body-parser` from 1.20.2 to 1.20.3, `express` from 4.19.2 to 4.21.0, `send` from 0.18.0 to 0.19.0 and `serve-static` from 1.15.0 to 1.16.2 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#306](https://github.com/10up/simple-local-avatars/pull/306)).

[View historical changelog details here](https://github.com/10up/simple-local-avatars/blob/develop/CHANGELOG.md).

== Upgrade Notice ==

= 2.8.4 =
**Note that this release bumps the minimum required version of WordPress from 6.5 to 6.6.**

= 2.8.0 =
**Note that this release bumps the minimum required version of WordPress from 6.4 to 6.5.**

= 2.7.11 =
**Note that this release bumps the minimum required version of WordPress from 6.3 to 6.4.**

= 2.7.8 =
**Note that this release bumps the minimum required version of WordPress from 5.7 to 6.3.**

= 2.6.0 =
**Note that this release bumps the minimum required version of WordPress from 4.6 to 5.7 and PHP from 5.6 to 7.4.**

= 2.1 =
*Important note:* All avatar uploads now go into the media library. Don't worry - users without the ability to upload files cannot otherwise see the contents of your media library. This allows local avatars to respect other functionality your site may have around uploaded images, such as external hosting.

= 2.0 =
Upgraded to take advantage of *WordPress 3.5 and newer*. Does not support older versions! This has also *not* been tested with front end profile plug-ins - feedback welcome. Note that several language strings have been added or modified - revised translations would be welcome!

= 1.3.1 =
Like WordPress 3.2, now *REQUIRES* PHP 5.2 or newer.
