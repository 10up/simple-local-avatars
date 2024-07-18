=== Simple Local Avatars ===
Contributors:      jakemgold, 10up, thinkoomph, jeffpaul, faisal03
Donate link:       https://10up.com/plugins/simple-local-avatars-wordpress/
Tags:              avatar, gravatar, user photos, users, profile
Tested up to:      6.6
Stable tag:        2.7.11
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

= 2.7.5 - 2023-05-15 =
* **Added:** Ajax loading animation during process of uploading and deleting local avatars (props [@lllopo](https://github.com/lllopo), [@BhargavBhandari90](https://github.com/BhargavBhandari90), [@faisal-alvi](https://github.com/faisal-alvi) via [#204](https://github.com/10up/simple-local-avatars/pull/204)).
* **Changed:** Avatar removal button text (props [@jayedul](https://github.com/jayedul), [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter), [@faisal-alvi](https://github.com/faisal-alvi) via [#208](https://github.com/10up/simple-local-avatars/pull/208)).
* **Changed:** WordPress "tested up to" version 6.2 (props [@jayedul](https://github.com/jayedul), [@faisal-alvi](https://github.com/faisal-alvi) via [#210](https://github.com/10up/simple-local-avatars/pull/210)).
* **Changed:** Run E2E tests on the zip generated by "Build release zip" action (props [@jayedul](https://github.com/jayedul), [@iamdharmesh](https://github.com/iamdharmesh), [@faisal-alvi](https://github.com/faisal-alvi) via [#205](https://github.com/10up/simple-local-avatars/pull/205)).
* **Security:** Bump `webpack` from 5.75.0 to 5.76.1 (props [@dependabot](https://github.com/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#207](https://github.com/10up/simple-local-avatars/pull/207)).

= 2.7.4 - 2023-02-23 =
* **Fixed:** Support passing `WP_User` to `get_avatar()` (props [@mattheu](https://github.com/mattheu), [@faisal-alvi](https://github.com/faisal-alvi) via [#193](https://github.com/10up/simple-local-avatars/pull/193)).
* **Fixed:** Remove trailing commas in function calls (props [@patrixer](https://github.com/patrixer), [@dkotter](https://github.com/dkotter), [@sekra24](https://github.com/sekra24), [@faisal-alvi](https://github.com/faisal-alvi) via [#196](https://github.com/10up/simple-local-avatars/pull/196)).
* **Security:** Bump `simple-git` from 3.15.1 to 3.16.0 (props [@dependabot](https://github.com/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#191](https://github.com/10up/simple-local-avatars/pull/191)).
* **Security:** Bump `http-cache-semantics` from 4.1.0 to 4.1.1 (props [@dependabot](https://github.com/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#197](https://github.com/10up/simple-local-avatars/pull/197)).

= 2.7.3 - 2023-01-16 =
* **Fixed:** Issue causing fatal errors when avatars used on front end of site (props [@Rottinator](https://github.com/Rottinator), [@peterwilsoncc](https://github.com/peterwilsoncc), [@ravinderk](https://github.com/ravinderk), [@faisal-alvi](https://github.com/faisal-alvi) via [#187](https://github.com/10up/simple-local-avatars/pull/187)).
* **Fixed:** Deprecation error in admin on PHP 8.0 and later (props [@Rottinator](https://github.com/Rottinator), [@peterwilsoncc](https://github.com/peterwilsoncc), [@ravinderk](https://github.com/ravinderk), [@faisal-alvi](https://github.com/faisal-alvi) via [#187](https://github.com/10up/simple-local-avatars/pull/187)).

= 2.7.2 - 2023-01-13 =
* **Added:** Filter hook `simple_local_avatars_upload_limit` to restrict image upload size & image file checking enhanced (props [@Shirkit](https://github.com/Shirkit), [@jayedul](https://github.com/jayedul), [@faisal-alvi](https://github.com/faisal-alvi), [@jeffpaul](https://github.com/jeffpaul) via [#171](https://github.com/10up/simple-local-avatars/pull/171)).
* **Added:** GitHub Actions summary on Cypress e2e test runs (props [@faisal-alvi](https://github.com/faisal-alvi), [@jeffpaul](https://github.com/jeffpaul), [@iamdharmesh](https://github.com/iamdharmesh) via [#174](https://github.com/10up/simple-local-avatars/pull/174)).
* **Changed:** Cypress integration migrated from 9.5.4 to 11.2.0 (props [@iamdharmesh](https://github.com/iamdharmesh), [@jayedul](https://github.com/jayedul), [@faisal-alvi](https://github.com/faisal-alvi) via [#172](https://github.com/10up/simple-local-avatars/pull/172)).
* **Fixed:** PHP8 support for `assign_new_user_avatar` (props [@lllopo](https://github.com/lllopo), [@mattwatsoncodes](https://github.com/mattwatsoncodes), [@faisal-alvi](https://github.com/faisal-alvi) via [#183](https://github.com/10up/simple-local-avatars/pull/183)).
* **Fixed:** Fixed the user profile language not respected issue (props [@dkotter](https://github.com/dkotter), [@lllopo](https://github.com/lllopo), [@faisal-alvi](https://github.com/faisal-alvi), [@jeffpaul](https://github.com/jeffpaul) via [#175](https://github.com/10up/simple-local-avatars/pull/175)).
* **Removed:** textdomain from the core strings and the function `update_avatar_ratings` as it's not required anymore (props [@dkotter](https://github.com/dkotter), [@lllopo](https://github.com/lllopo), [@faisal-alvi](https://github.com/faisal-alvi), [@jeffpaul](https://github.com/jeffpaul) via [#175](https://github.com/10up/simple-local-avatars/pull/175)).
* **Security:** Bump `json5` from 1.0.1 to 1.0.2  (props [@dependabot](https://github.com/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#182](https://github.com/10up/simple-local-avatars/pull/182)).

= 2.7.1 - 2022-12-08 =
* **Added:** Added missing files from the last release and changed the readme file to fix the bullet points and added fullstops.

= 2.7.0 - 2022-12-08 =
* **Added:** Added `Build release zip` GitHub Action (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@faisal-alvi](https://github.com/faisal-alvi) via [#168](https://github.com/10up/simple-local-avatars/pull/168)).
* **Changed:** Set plugin defaults on `wp_initialize_site` instead of deprecated action `wpmu_new_blog` (props [@kadamwhite](https://github.com/kadamwhite), [@faisal-alvi](https://github.com/faisal-alvi) via [#156](https://github.com/10up/simple-local-avatars/pull/156)).
* **Changed:** Support Level from Active to Stable (props [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#159](https://github.com/10up/simple-local-avatars/pull/159)).
* **Changed:** Build tools: Allow PHPCS installer plugin to run without prompting user (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@jeffpaul](https://github.com/jeffpaul) via [#164](https://github.com/10up/simple-local-avatars/pull/164)).
* **Changed:** WP tested up to version bump to 6.1 (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@faisal-alvi](https://github.com/faisal-alvi) via [#165](https://github.com/10up/simple-local-avatars/pull/165)).
* **Fixed:** Non admin users can not crop avatar (props [@jayedul](https://github.com/jayedul), [@faisal-alvi](https://github.com/faisal-alvi), [@zamanq](https://github.com/zamanq), [@dkotter](https://github.com/dkotter), [@jeffpaul](https://github.com/jeffpaul) via [#155](https://github.com/10up/simple-local-avatars/pull/155)).
* **Security:** Bump `@wordpress/env` from 4.9.0 to 5.2.0 and `got` from 10.7.0 to 11.8.5 (props [@dependabot](https://github.com/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#153](https://github.com/10up/simple-local-avatars/pull/153)).
* **Security:** Bump `loader-utils` from 2.0.2 to 2.0.3 (props [@dependabot](https://github.com/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#160](https://github.com/10up/simple-local-avatars/pull/160)).
* **Security:** Bump `loader-utils` from 2.0.3 to 2.0.4 (props [@dependabot](https://github.com/dependabot), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#162](https://github.com/10up/simple-local-avatars/pull/162)).
* **Security:** Bump `simple-git` from 3.9.0 to 3.15.1 (props [@dependabot](https://github.com/dependabot) via [#176](https://github.com/10up/simple-local-avatars/pull/176)).

[View historical changelog details here](https://github.com/10up/simple-local-avatars/blob/develop/CHANGELOG.md).

== Upgrade Notice ==

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
