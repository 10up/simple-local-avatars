=== Simple Local Avatars ===
Contributors:      jakemgold, 10up, thinkoomph, jeffpaul, faisal03
Donate link:       https://10up.com/plugins/simple-local-avatars-wordpress/
Tags:              avatar, gravatar, user photos, users, profile
Requires at least: 5.7
Tested up to:      6.4
Requires PHP:      7.4
Stable tag:        2.7.6
License:           GPLv2 or later
License URI:       http://www.gnu.org/licenses/gpl-2.0.html

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

You can also use `get_simple_local_avatar()` (with the same arguments) to retreive local avatars a bit faster, but this will make your theme dependent on this plug-in.

== Frequently Asked Questions ==

= Does Simple Local Avatars collect personal data of website visitors? =

No.  Simple Local Avatars neither collects, stores, nor sends any PII data of visitors or avatar users on the host site or to 10up or other services.

== Screenshots ==

1. Avatar upload field on a user profile page

== Changelog ==

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

= 2.6.0 - 2022-09-13 =
**Note that this release bumps the minimum required version of WordPress from 4.6 to 5.7 and PHP from 5.6 to 7.4.**

* **Added:** If a default avatar image is used, ensure that outputs alt text. This will either be default text (Avatar photo) or the alt text from the uploaded default image (props [@dkotter](https://github.com/dkotter), [@faisal-alvi](https://github.com/faisal-alvi) via [#147](https://github.com/10up/simple-local-avatars/pull/147))
* **Added:** Two hooks, `simple_local_avatar_updated` and `simple_local_avatar_deleted`,  (props [@t-lock](https://github.com/t-lock), [@faisal-alvi](https://github.com/faisal-alvi), [@dkotter](https://github.com/dkotter) via [#149](https://github.com/10up/simple-local-avatars/pull/149))
* **Changed:** Bump minimum required version of WordPress from 4.6 to 5.7 (props [@vikrampm1](https://github.com/vikrampm1), [@faisal-alvi](https://github.com/faisal-alvi), [@cadic](https://github.com/cadic) via [#143](https://github.com/10up/simple-local-avatars/pull/143)).
* **Changed:** Bump minimum required version of PHP from 5.6 to 7.4 (props [@vikrampm1](https://github.com/vikrampm1), [@faisal-alvi](https://github.com/faisal-alvi), [@cadic](https://github.com/cadic) via [#143](https://github.com/10up/simple-local-avatars/pull/143)).
* **Changed:**The plugin is now available via Composer without any additional steps required (props [@faisal-alvi](https://github.com/faisal-alvi), [@kovshenin](https://github.com/kovshenin), [@jeffpaul](https://github.com/jeffpaul) via [#145](https://github.com/10up/simple-local-avatars/pull/145))
* **Security:** Bump `terser` from 5.14.1 to 5.14.2 (props [@dependabot](https://github.com/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#142](https://github.com/10up/simple-local-avatars/pull/142))

= 2.5.0 - 2022-06-24 =
* **Added:** Skip cropping button (props [@dkotter](https://github.com/dkotter), [@faisal-alvi](https://github.com/faisal-alvi), [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul), [@dinhtungdu](https://github.com/dinhtungdu) via [#130](https://github.com/10up/simple-local-avatars/pull/130))!
* **Added:** Updated the button name from "Skip Crop" to "Default Crop" only on the edit profile page (props [@faisal-alvi](https://github.com/faisal-alvi), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#136](https://github.com/10up/simple-local-avatars/pull/136)).
* **Added:** If an image used for a local avatar has alt text assigned, ensure that alt text is used when rendering the image (props [@dkotter](https://github.com/dkotter), [@pixelloop](https://github.com/pixelloop), [@faisal-alvi](https://github.com/faisal-alvi) via [#127](https://github.com/10up/simple-local-avatars/pull/127)).
* **Added:** Support for bbPress by loading the JS at FE on the profile edit page (props [@foliovision](https://github.com/foliovision), [@faisal-alvi](https://github.com/faisal-alvi), [@iamdharmesh](https://github.com/iamdharmesh) via [#134](https://github.com/10up/simple-local-avatars/pull/134)).
* **Added:** Cypress E2E tests (props [@faisal-alvi](https://github.com/faisal-alvi), [@vikrampm1](https://github.com/vikrampm1), [@Sidsector9](https://github.com/Sidsector9) via [#115](https://github.com/10up/simple-local-avatars/pull/115)).
* **Fixed:** Broken avatar URLs for network-configured shared avatars with non-standard thumbnail sizes (props [@vladolaru](https://github.com/vladolaru), [@faisal-alvi](https://github.com/faisal-alvi) via [#125](https://github.com/10up/simple-local-avatars/pull/125)).
* **Fixed:** `HTTP_REFERER` is null and causing PHP warning (props [@alireza-salehi](https://github.com/alireza-salehi), [@faisal-alvi](https://github.com/faisal-alvi), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#129](https://github.com/10up/simple-local-avatars/pull/129)).

= 2.4.0 - 2022-05-10 =
* **Added:** Ability to set a default avatar. (props [@mehulkaklotar](https://github.com/mehulkaklotar), [@jeffpaul](https://github.com/jeffpaul), [@dinhtungdu](https://github.com/dinhtungdu), [@faisal-alvi](https://github.com/faisal-alvi) via [#96](https://github.com/10up/simple-local-avatars/pull/96)).
* **Fixed:** Correct plugin name in changelog. (props [@grappler](https://github.com/grappler), [@jeffpaul](https://github.com/jeffpaul) via [#117](https://github.com/10up/simple-local-avatars/pull/117)).
* **Fixed:** Avatar cache not being cleared. (props [@thefrosty](https://github.com/thefrosty), [@jeffpaul](https://github.com/jeffpaul), [@faisal-alvi](https://github.com/faisal-alvi), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#118](https://github.com/10up/simple-local-avatars/pull/118) & [#120](https://github.com/10up/simple-local-avatars/pull/120)).
* **Security:** Dev dependency `@wordpress/scripts` upgraded to resolve deeper level dependency security issues. (props [@jeffpaul](https://github.com/jeffpaul), [@faisal-alvi](https://github.com/faisal-alvi), [@cadic](https://github.com/cadic) via [#119](https://github.com/10up/simple-local-avatars/pull/119)).

= 2.3.0 - 2022-04-25 =
* **Added:** Crop screen (props [@jeffpaul](https://github.com/jeffpaul), [@helen](https://github.com/helen), [@ajmaurya99](https://github.com/ajmaurya99), [@Antonio-Laguna](https://github.com/Antonio-Laguna), [@faisal-alvi](https://github.com/faisal-alvi)).
* **Added:** Avatar preview for Subscribers (props [@ankitguptaindia](https://github.com/ankitguptaindia), [@dinhtungdu](https://github.com/dinhtungdu), [@dkotter](https://github.com/dkotter)).
* **Added:** More robust multisite support and shared avatar setting (props [@adamsilverstein](https://github.com/adamsilverstein), [@helen](https://github.com/helen), [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter), [@faisal-alvi](https://github.com/faisal-alvi), [@holle75](https://github.com/holle75)).
* **Added:** Settings link to plugin action links (props [@rahulsprajapati](https://github.com/rahulsprajapati), [@jeffpaul](https://github.com/jeffpaul), [@iamdharmesh](https://github.com/iamdharmesh)).
* **Added:** Dashboard setting and WP-CLI command to migrate avatars from [WP User Avatar](https://wordpress.org/plugins/wp-user-avatar/) (props [@jeffpaul](https://github.com/jeffpaul), [@claytoncollie](https://github.com/claytoncollie), [@helen](https://github.com/helen), [@faisal-alvi](https://github.com/faisal-alvi)).
* **Added:** Option to clear cache of user meta to remove image sizes that do not exist (props [@jeffpaul](https://github.com/jeffpaul), [@ituk](https://github.com/ituk), [@dinhtungdu](https://github.com/dinhtungdu), [@sparkbold](https://github.com/sparkbold), [@thrijith](https://github.com/thrijith)).
* **Added:** Package file (props [@faisal-alvi](https://github.com/faisal-alvi), [@jeffpaul](https://github.com/jeffpaul), [@claytoncollie](https://github.com/claytoncollie), [@cadic](https://github.com/cadic)).
* **Added:** PHP Unit Tests (props [@faisal-alvi](https://github.com/faisal-alvi), [@iamdharmesh](https://github.com/iamdharmesh)).
* **Added:** "No Response" GitHub Action (props [@jeffpaul](https://github.com/jeffpaul)).
* **Changed:** Bump WordPress "tested up to" version to 5.9 (props [@jeffpaul](https://github.com/jeffpaul), [@ankitguptaindia](https://github.com/ankitguptaindia), [@dinhtungdu](https://github.com/dinhtungdu), [@phpbits](https://github.com/phpbits)).
* **Changed:** Bump WordPress "tested up to" version to 6.0 (props [@ajmaurya99](https://github.com/ajmaurya99) via [#110](https://github.com/10up/simple-local-avatars/pull/110)).
* **Changed:** Format admin script (props [@thrijith](https://github.com/thrijith), [@dinhtungdu](https://github.com/dinhtungdu)).
* **Fixed:** Media ID as string in REST API (props [@diodoe](https://github.com/diodoe), [@dinhtungdu](https://github.com/dinhtungdu), [@dkotter](https://github.com/dkotter)).
* **Fixed:**  Avatar rating text is not translated properly if a user has a custom language Set (props [@ActuallyConnor](https://github.com/ActuallyConnor), [@faisal-alvi](https://github.com/faisal-alvi)).
* **Security:** PHP 8 compatibility (props [@faisal-alvi](https://github.com/faisal-alvi), [@dkotter](https://github.com/dkotter), [@Sidsector9](https://github.com/Sidsector9)).
* **Security:** Bump `rmccue/requests` from 1.7.0 to 1.8.0 (props [dependabot@](https://github.com/dependabot)).
* **Security:** Bump `nanoid` from 3.1.28 to 3.2.0 (props [dependabot@](https://github.com/dependabot)).
* **Security:** Bump `minimist` from 1.2.5 to 1.2.6 (props [dependabot@](https://github.com/dependabot)).

= 2.2.0 - 2020-10-27 =
* **Added:** `$args` parameter to `get_simple_local_avatar` function (props [@dinhtungdu](https://profiles.wordpress.org/dinhtungdu/), [@heyjones](https://github.com/heyjones), [@dkotter](https://profiles.wordpress.org/dkotter/), [@sumnercreations](https://github.com/sumnercreations), [@dshanske](https://profiles.wordpress.org/dshanske/)).
* **Added:**  `Simple_Local_Avatars::get_avatar_data()`, `Simple_Local_Avatars::get_simple_local_avatar_url()`, and `Simple_Local_Avatars::get_default_avatar_url()` methods (props [@dinhtungdu](https://profiles.wordpress.org/dinhtungdu/), [@heyjones](https://github.com/heyjones), [@dkotter](https://profiles.wordpress.org/dkotter/), [@sumnercreations](https://github.com/sumnercreations), [@dshanske](https://profiles.wordpress.org/dshanske/)).
* **Added:** Ability to retrieve avatar with `WP_Post` object (props [@oscarssanchez](https://profiles.wordpress.org/oscarssanchez), [@blobaugh](https://profiles.wordpress.org/blobaugh)).
* **Added:** class and ID to Avatar section on Profile Page to allow easier styling (props [@dinhtungdu](https://profiles.wordpress.org/dinhtungdu/)).
* **Added:**  [WP Acceptance](https://github.com/10up/wpacceptance/) test coverage (props [@dinhtungdu](https://profiles.wordpress.org/dinhtungdu/)).
* **Changed:** Switched to `pre_get_avatar_data` filter (props [@dinhtungdu](https://profiles.wordpress.org/dinhtungdu/), [@heyjones](https://github.com/heyjones), [@dkotter](https://profiles.wordpress.org/dkotter/), [@sumnercreations](https://github.com/sumnercreations), [@dshanske](https://profiles.wordpress.org/dshanske/)).
* **Changed:** `assign_new_user_avatar` function to public (props [@tripflex](https://profiles.wordpress.org/tripflex/)).
* **Changed:** Split the main class into its own file, added unit tests, and set up testing GitHub action (props [@dinhtungdu](https://profiles.wordpress.org/dinhtungdu/), [@helen](https://profiles.wordpress.org/helen/), [@stevegrunwell](https://profiles.wordpress.org/stevegrunwell/)).
* **Changed:** New plugin banner and icon (props [@JackieKjome](https://profiles.wordpress.org/jackiekjome/)).
* **Changed:** Bump WordPress version "tested up to" 5.5 (props [@Waka867](https://github.com/Waka867), [@tmoorewp](https://profiles.wordpress.org/tmoorewp), [@jeffpaul](https://profiles.wordpress.org/jeffpaul), [@dinhtungdu](https://profiles.wordpress.org/dinhtungdu/)).
* **Changed:** GitHub Actions from HCL to YAML workflow syntax (props [@jeffpaul](https://profiles.wordpress.org/jeffpaul)).
* **Changed:** Documentation updates (props [@jeffpaul](https://profiles.wordpress.org/jeffpaul)).
* **Fixed:** Initialize `Simple_Local_Avatars` on the `$simple_local_avatars` global, enabling bundling plugin with composer (props [@pauldewouters](https://profiles.wordpress.org/pauldewouters/), [@adamsilverstein](https://profiles.wordpress.org/adamsilverstein)).
* **Removed:** `get_avatar` function that overrides the core function (props [@dinhtungdu](https://profiles.wordpress.org/dinhtungdu/), [@heyjones](https://github.com/heyjones), [@dkotter](https://profiles.wordpress.org/dkotter/), [@sumnercreations](https://github.com/sumnercreations), [@dshanske](https://profiles.wordpress.org/dshanske/)).

= 2.1.1 - 2019-05-07 =
* Fixed: Do not delete avatars just because they don't exist on the local filesystem. This was occasionally dumping avatars when WordPress uploads were stored elsewhere, e.g. a cloud service.

= 2.1 - 2018-10-24 =
* *New:* All avatar uploads now go into the media library. Don't worry - users without the ability to upload files cannot otherwise see the contents of your media library. This allows local avatars to respect other functionality your site may have around uploaded images, such as external hosting.
* *New:* REST API support for getting and updating.
* *New:* Use .org language packs rather than bundling translations.
* *Fixed:* Avoid an `ArgumentCountError`.
* *Fixed:* A couple of internationalization issues.

= 2.0 - 2013-06-02 =
* Choose or upload an avatar from the media library (for users with appropriate capabilities)!
* Local avatars are rated for appropriateness, just like Gravatar
* A new setting under Discussion enables administrators to turn off Gravatar (only use local avatars)
* Delete the local avatar with a single button click (like everywhere else in WordPress)
* Uploaded avatar file names are appended with the timestamp, addressing browser image caching issues
* New developer filter for preventing automatic rescaling: simple_local_avatars_dynamic_resize
* New developer filter for limiting upload size: simple_local_avatars_upload_limit
* Upgraded functions deprecated since WordPress 3.5
* Fixed translations not working on front end (although translations are now a bit out of date...)
* Hungarian translation added (needs further updating again with new version)
* Assorted refactoring / improvements under the hood

= 1.3.1 - 2011-12-29 =
* Brazilian Portuguese and Belarusian translations
* Bug fixes (most notably correct naming of image files based on user display name)
* Optimization for WordPress 3.2 / 3.3 (substitutes deprecated function)

= 1.3 - 2011-09-22 =
* Avatar file name saved as "user-display-name_avatar" (or other image extension)
* Russian localization added
* Assorted minor code optimizations

= 1.2.4 - 2011-07-02 =
* Support for front end avatar uploads (e.g. Theme My Profile)

= 1.2.3 - 2011-04-04 =
* Russian localization

= 1.2.2 - 2011-03-25 =
* Fix for avatars uploaded pre-1.2.1 having a broken path after upgrade

= 1.2.1 - 2011-01-26 =
* French localization
* Simplify uninstall code

= 1.2 - 2011-01-26 =
* Fix path issues on some IIS servers (resulting in missing avatar images)
* Fix rare uninstall issues related to deleted avatars
* Spanish localization
* Other minor under the hood optimizations

= 1.1.3 - 2011-01-20 =
* Properly deletes old avatars upon changing avatar
* Fixes "foreach" warning in debug mode when updating avatar image

= 1.1.2 - 2011-01-18 =
* Norwegian localization

= 1.1.1 - 2011-01-18 =
* Italian localization

= 1.1 - 2011-01-18 =
* All users (regardless of capabilities) can upload avatars by default. To limit avatar uploading to users with upload files capabilities (Authors and above), check the applicable option under Settings > Discussion. This was the default behavior in 1.0.
* Localization support; German included

= 1.0 - 2011-01-18 =
* Initial release.

== Upgrade Notice ==

= 2.6.0 =
**Note that this release bumps the minimum required version of WordPress from 4.6 to 5.7 and PHP from 5.6 to 7.4.**

= 2.1 =
*Important note:* All avatar uploads now go into the media library. Don't worry - users without the ability to upload files cannot otherwise see the contents of your media library. This allows local avatars to respect other functionality your site may have around uploaded images, such as external hosting.

= 2.0 =
Upgraded to take advantage of *WordPress 3.5 and newer*. Does not support older versions! This has also *not* been tested with front end profile plug-ins - feedback welcome. Note that several language strings have been added or modified - revised translations would be welcome!

= 1.3.1 =
Like WordPress 3.2, now *REQUIRES* PHP 5.2 or newer.
