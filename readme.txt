=== Simple Local Avatars ===
Contributors:      jakemgold, 10up, thinkoomph, jeffpaul, faisal03
Donate link:       https://10up.com/plugins/simple-local-avatars-wordpress/
Tags:              avatar, gravatar, user photos, users, profile
Tested up to:      6.7
Stable tag:        2.8.0
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

= 2.8.0 - 2024-11-12 =
**Note that this release bumps the minimum required version of WordPress from 6.4 to 6.5.**

* **Added:** Support for the WordPress.org plugin preview (props [@faisal-alvi](https://github.com/faisal-alvi), [@jeffpaul](https://github.com/jeffpaul) via [#297](https://github.com/10up/simple-local-avatars/pull/297)).
* **Changed:** Update PHP compatibility check to use `10up/wp-compat-validation-tool` (props [@Sidsector9](https://github.com/Sidsector9), [@jeffpaul](https://github.com/jeffpaul), [@faisal-alvi](https://github.com/faisal-alvi) via [#291](https://github.com/10up/simple-local-avatars/pull/291)).
* **Changed:** Bump Wordpress "tested up to" version 6.7 (props [@sudip-md](https://github.com/sudip-md), [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#310](https://github.com/10up/simple-local-avatars/pull/310), [#312](https://github.com/10up/simple-local-avatars/pull/312)).
* **Changed:** Bump WordPress minimum supported version to 6.5 (props [@sudip-md](https://github.com/sudip-md), [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#310](https://github.com/10up/simple-local-avatars/pull/310), [#312](https://github.com/10up/simple-local-avatars/pull/312)).
* **Fixed:** Ensure all strings are properly translated (props [@pedro-mendonca](https://github.com/pedro-mendonca), [@dkotter](https://github.com/dkotter) via [#295](https://github.com/10up/simple-local-avatars/pull/295)).
* **Fixed:** Properly handle malformed `simple_local_avatar` user data (props [@adekbadek](https://github.com/adekbadek), [@dkotter](https://github.com/dkotter), [@faisal-alvi](https://github.com/faisal-alvi) via [#302](https://github.com/10up/simple-local-avatars/pull/302)).
* **Security:** Run a user capability check before we clear the avatar cache (props [@dkotter](https://github.com/dkotter), [@truonghuuphuc](https://github.com/truonghuuphuc), [@Sidsector9](https://github.com/Sidsector9) via [#309](https://github.com/10up/simple-local-avatars/pull/309)).
* **Security:** Ensure REST API requests to set an avatar only allow existing attachment IDs to be used (props [@dkotter](https://github.com/dkotter), Justus Böhme, [@faisal-alvi](https://github.com/faisal-alvi) via [GHSA-wfjh-m788-w2c5](https://github.com/10up/simple-local-avatars/security/advisories/GHSA-wfjh-m788-w2c5)).
* **Security:** Bump `axios` from 1.6.7 to 1.7.4 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#298](https://github.com/10up/simple-local-avatars/pull/298)).
* **Security:** Bump `webpack` from 5.90.0 to 5.94.0 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#303](https://github.com/10up/simple-local-avatars/pull/303)).
* **Security:** Bump `ws` from 7.5.10 to 8.18.0 and `@wordpress/scripts` from 27.1.0 to 30.4.0 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#305](https://github.com/10up/simple-local-avatars/pull/305), [#311](https://github.com/10up/simple-local-avatars/pull/311)).
* **Security:** Bump `body-parser` from 1.20.2 to 1.20.3, `express` from 4.19.2 to 4.21.0, `send` from 0.18.0 to 0.19.0 and `serve-static` from 1.15.0 to 1.16.2 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#306](https://github.com/10up/simple-local-avatars/pull/306)).

= 2.7.11 - 2024-07-18 =
**Note that this release bumps the minimum required version of WordPress from 6.3 to 6.4.**

* **Changed:** Bumped WordPress "tested up to" version 6.6 and minimum version to 6.4 (props [@sudip-md](https://github.com/sudip-md), [@ankitguptaindia](https://github.com/ankitguptaindia), [@jeffpaul](https://github.com/jeffpaul) via [#289](https://github.com/10up/simple-local-avatars/pull/289), [#290](https://github.com/10up/simple-local-avatars/pull/290)).
* **Security:** Add nonce check when saving the default avatar ID (props [@faisal-alvi](https://github.com/faisal-alvi), [@aaemnnosttv](https://github.com/aaemnnosttv), [@rafiem](https://github.com/rafiem), [@dkotter](https://github.com/dkotter) via [GHSA-46pw-6m35-9m7x](https://github.com/10up/simple-local-avatars/security/advisories/GHSA-46pw-6m35-9m7x)).
* **Security:** Bump `braces` from 3.0.2 to 3.0.3, `pac-resolver` from 7.0.0 to 7.0.1, `socks` from 2.7.1 to 2.8.3 and removes `ip` (props [@dependabot](https://github.com/apps/dependabot), [@Sidsector9](https://github.com/Sidsector9) via [#286](https://github.com/10up/simple-local-avatars/pull/286)).
* **Security:** Bump `ws` from 7.5.9 to 7.5.10 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#287](https://github.com/10up/simple-local-avatars/pull/287)).

= 2.7.10 - 2024-05-24 =
* **Fixed:** Fix Default Avatar Fallback (props [@amirhossein7](https://profiles.wordpress.org/amirhossein7/), [@faisal-alvi](https://github.com/faisal-alvi), [@dkotter](https://github.com/dkotter), [@qasumitbagthariya](https://github.com/qasumitbagthariya/) via [#281](https://github.com/10up/simple-local-avatars/pull/281)).
* **Security:** Bump `express` from 4.18.2 to 4.19.2 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#269](https://github.com/10up/simple-local-avatars/pull/269)).
* **Security:** Bump `follow-redirects` from 1.15.5 to 1.15.6 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#269](https://github.com/10up/simple-local-avatars/pull/269)).
* **Security:** Bump `ip` from 1.1.8 to 1.1.9 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#269](https://github.com/10up/simple-local-avatars/pull/269)).
* **Security:** Bump `webpack-dev-middleware` from 5.3.3 to 5.3.4 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#269](https://github.com/10up/simple-local-avatars/pull/269)).

= 2.7.9 - 2024-05-14 =
* **Fixed:** Ensure default Gravatar avatars are shown correctly (props [@faisal-alvi](https://github.com/faisal-alvi), [@dkotter](https://github.com/dkotter), [@horrormoviesgr](https://profiles.wordpress.org/horrormoviesgr/), [@inpeaks](https://profiles.wordpress.org/inpeaks/), [@lillylark](https://profiles.wordpress.org/lillylark/), [@rafaucau](https://github.com/rafaucau), [@janrenn](https://profiles.wordpress.org/janrenn/) via [#278](https://github.com/10up/simple-local-avatars/pull/278)).

= 2.7.8 - 2024-05-08 =
**Note that this release bumps the minimum required version of WordPress from 5.7 to 6.3.**

* **Added:** "Testing" section in the `CONTRIBUTING.md` file (props [@kmgalanakis](https://github.com/kmgalanakis), [@jeffpaul](https://github.com/jeffpaul) via [#274](https://github.com/10up/simple-local-avatars/pull/274)).
* **Changed:** Bumped WordPress "tested up to" version 6.5 (props [@sudip-md](https://github.com/sudip-md), [@dkotter](https://github.com/dkotter), [@jeffpaul](https://github.com/jeffpaul) via [#270](https://github.com/10up/simple-local-avatars/pull/270)).
* **Changed:** Move `simple_local_avatar_deleted` action to `avatar_delete` (props [@lllopo](https://github.com/lllopo), [@faisal-alvi](https://github.com/faisal-alvi), [@dkotter](https://github.com/dkotter) via [#255](https://github.com/10up/simple-local-avatars/pull/255)).
* **Changed:** Clean up NPM dependencies and update node to `v20` (props [@Sidsector9](https://github.com/Sidsector9), [@dkotter](https://github.com/dkotter) via [#257](https://github.com/10up/simple-local-avatars/pull/257)).
* **Changed:** Update `CODEOWNERS` of the plugin (props [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#253](https://github.com/10up/simple-local-avatars/pull/253)).
* **Changed:** Disabled auto sync pull requests with target branch (props [@iamdharmesh](https://github.com/iamdharmesh), [@jeffpaul](https://github.com/jeffpaul) via [#263](https://github.com/10up/simple-local-avatars/pull/263)).
* **Changed:** Upgrade `download-artifact` from v3 to v4 (props [@iamdharmesh](https://github.com/iamdharmesh), [@jeffpaul](https://github.com/jeffpaul) via [#265](https://github.com/10up/simple-local-avatars/pull/265)).
* **Changed:** Replaced `lee-dohm/no-response` with `actions/stale` to help with closing `no-response/stale` issues (props [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#266](https://github.com/10up/simple-local-avatars/pull/266)).
* **Fixed:** Broken default avatar when `Local Avatars Only` is unchecked (props [@faisal-alvi](https://github.com/faisal-alvi), [@ankitguptaindia](https://github.com/ankitguptaindia), [@qasumitbagthariya](https://github.com/qasumitbagthariya) via [#260](https://github.com/10up/simple-local-avatars/pull/260)).
* **Fixed:** Ensure high-quality avatar preview on profile edit screen (props [@ocean90](https://github.com/ocean90), [@dkotter](https://github.com/dkotter) via [#273](https://github.com/10up/simple-local-avatars/pull/273)).
* **Fixed:** Possible PHP warning (props [@BhargavBhandari90](https://github.com/BhargavBhandari90), [@dkotter](https://github.com/dkotter) via [#261](https://github.com/10up/simple-local-avatars/pull/261)).
* **Fixed:** Fixed typos (props [@szepeviktor](https://github.com/szepeviktor), [@dkotter](https://github.com/dkotter) via [#268](https://github.com/10up/simple-local-avatars/pull/268)).

= 2.7.7 - 2023-12-13 =
* **Fixed:** Revert the Host/Domain support for local avatar URL (props [@faisal-alvi](https://github.com/faisal-alvi), [@jakejackson1](https://github.com/jakejackson1), [@leogermani](https://github.com/leogermani), [@dkotter](https://github.com/dkotter) via [#247](https://github.com/10up/simple-local-avatars/pull/247)).
* **Security:** Bump `axios` from 0.25.0 to 1.6.2 and `@wordpress/scripts` from 23.7.2 to 26.18.0 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#250](https://github.com/10up/simple-local-avatars/pull/250)).

= 2.7.6 - 2023-11-30 =
* **Added:** Check for minimum required PHP version before loading the plugin (props [@kmgalanakis](https://github.com/kmgalanakis), [@faisal-alvi](https://github.com/faisal-alvi) via [#226](https://github.com/10up/simple-local-avatars/pull/226)).
* **Added:** `pre_simple_local_avatar_url` filter to allow an avatar image to be short-circuited before Simple Local Avatars processes it (props [@johnbillion](https://github.com/johnbillion), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#237](https://github.com/10up/simple-local-avatars/pull/237)).
* **Added:** Repo Automator GitHub Action (props [@iamdharmesh](https://github.com/iamdharmesh), [@faisal-alvi](https://github.com/faisal-alvi) via [#228](https://github.com/10up/simple-local-avatars/pull/228)).
* **Added:** E2E test for checking the front end of avatars (props [@Firestorm980](https://github.com/Firestorm980), [@iamdharmesh](https://github.com/iamdharmesh) via [#219](https://github.com/10up/simple-local-avatars/pull/219)).
* **Changed:** Bumped WordPress "tested up to" version 6.4 (props [@zamanq](https://github.com/zamanq), [@ankitguptaindia](https://github.com/ankitguptaindia), [@faisal-alvi](https://github.com/faisal-alvi), [@qasumitbagthariya](https://github.com/qasumitbagthariya) via [#230](https://github.com/10up/simple-local-avatars/pull/230), [#244](https://github.com/10up/simple-local-avatars/pull/244)).
* **Changed:** Update the Dependency Review GitHub Action to leverage our org-wide config file to check for GPL-compatible licenses (props [@jeffpaul](https://github.com/jeffpaul), [@faisal-alvi](https://github.com/faisal-alvi) via [#215](https://github.com/10up/simple-local-avatars/pull/215)).
* **Changed:** Documentation updates (props [@jeffpaul](https://github.com/jeffpaul), [@faisal-alvi](https://github.com/faisal-alvi) via [#242](https://github.com/10up/simple-local-avatars/pull/242)).
* **Fixed:** Address conflicts with other plugins and loading the media API (props [@EHLOVader](https://github.com/EHLOVader), [@dkotter](https://github.com/dkotter) via [#218](https://github.com/10up/simple-local-avatars/pull/218)).
* **Fixed:** Prevent PHP fatal error when switching from a multisite to single site installation (props [@ocean90](https://github.com/ocean90), [@ravinderk](https://github.com/ravinderk), [@faisal-alvi](https://github.com/faisal-alvi) via [#222](https://github.com/10up/simple-local-avatars/pull/222)).
* **Fixed:** Local avatar urls remain old after domain/host change (props [@jayedul](https://github.com/jayedul), [@ravinderk](https://github.com/ravinderk), [@jeffpaul](https://github.com/jeffpaul), [@faisal-alvi](https://github.com/faisal-alvi) via [#216](https://github.com/10up/simple-local-avatars/pull/216)).
* **Security:** Bump `word-wrap` from 1.2.3 to 1.2.4 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#223](https://github.com/10up/simple-local-avatars/pull/223)).
* **Security:** Bump `tough-cookie` from 4.1.2 to 4.1.3 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#225](https://github.com/10up/simple-local-avatars/pull/225)).
* **Security:** Bump `@cypress/request` from 2.88.10 to 3.0.0 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#225](https://github.com/10up/simple-local-avatars/pull/225), [#234](https://github.com/10up/simple-local-avatars/pull/234)).
* **Security:** Bump `cypress` from 11.2.0 to 13.2.0 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi), [@iamdharmesh](https://github.com/iamdharmesh) via [#234](https://github.com/10up/simple-local-avatars/pull/234), [#236](https://github.com/10up/simple-local-avatars/pull/236)).
* **Security:** Bump `postcss` from 8.4.21 to 8.4.31 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#238](https://github.com/10up/simple-local-avatars/pull/238)).
* **Security:** Bump `@babel/traverse` from 7.20.12 to 7.23.2 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#240](https://github.com/10up/simple-local-avatars/pull/240)).
* **Security:** Bump `@10up/cypress-wp-utils` version to 0.2.0 (props [@iamdharmesh](https://github.com/iamdharmesh), [@faisal-alvi](https://github.com/faisal-alvi) via [#236](https://github.com/10up/simple-local-avatars/pull/236)).
* **Security:** Bump `@wordpress/env` version from 5.2.0 to 8.7.0 (props [@iamdharmesh](https://github.com/iamdharmesh), [@faisal-alvi](https://github.com/faisal-alvi) via [#236](https://github.com/10up/simple-local-avatars/pull/236)).
* **Security:** Bump `cypress-mochawesome-reporter` version from 3.0.1 to 3.6.0 (props [@iamdharmesh](https://github.com/iamdharmesh), [@faisal-alvi](https://github.com/faisal-alvi) via [#236](https://github.com/10up/simple-local-avatars/pull/236)).

[View historical changelog details here](https://github.com/10up/simple-local-avatars/blob/develop/CHANGELOG.md).

== Upgrade Notice ==

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
