# Changelog

All notable changes to this project will be documented in this file, per [the Keep a Changelog standard](http://keepachangelog.com/).

## [Unreleased] - TBD

## [2.8.1] - 2024-11-12
### Fixed
- Ensure dependencies are included properly in the release (props [@dkotter](https://github.com/dkotter) via [#315](https://github.com/10up/simple-local-avatars/pull/315)).

## [2.8.0] - 2024-11-12
**Note that this release bumps the minimum required version of WordPress from 6.4 to 6.5.**

### Added
- Support for the WordPress.org plugin preview (props [@faisal-alvi](https://github.com/faisal-alvi), [@jeffpaul](https://github.com/jeffpaul) via [#297](https://github.com/10up/simple-local-avatars/pull/297)).

### Changed
- Update PHP compatibility check to use `10up/wp-compat-validation-tool` (props [@Sidsector9](https://github.com/Sidsector9), [@jeffpaul](https://github.com/jeffpaul), [@faisal-alvi](https://github.com/faisal-alvi) via [#291](https://github.com/10up/simple-local-avatars/pull/291)).
- Bump Wordpress "tested up to" version 6.7 (props [@sudip-md](https://github.com/sudip-md), [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#310](https://github.com/10up/simple-local-avatars/pull/310), [#312](https://github.com/10up/simple-local-avatars/pull/312)).
- Bump WordPress minimum supported version to 6.5 (props [@sudip-md](https://github.com/sudip-md), [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#310](https://github.com/10up/simple-local-avatars/pull/310), [#312](https://github.com/10up/simple-local-avatars/pull/312)).

### Fixed
- Ensure all strings are properly translated (props [@pedro-mendonca](https://github.com/pedro-mendonca), [@dkotter](https://github.com/dkotter) via [#295](https://github.com/10up/simple-local-avatars/pull/295)).
- Properly handle malformed `simple_local_avatar` user data (props [@adekbadek](https://github.com/adekbadek), [@dkotter](https://github.com/dkotter), [@faisal-alvi](https://github.com/faisal-alvi) via [#302](https://github.com/10up/simple-local-avatars/pull/302)).

### Security
- Run a user capability check before we clear the avatar cache (props [@dkotter](https://github.com/dkotter), [@truonghuuphuc](https://github.com/truonghuuphuc), [@Sidsector9](https://github.com/Sidsector9) via [#309](https://github.com/10up/simple-local-avatars/pull/309)).
- Ensure REST API requests to set an avatar only allow existing attachment IDs to be used (props [@dkotter](https://github.com/dkotter), Justus Böhme, [@faisal-alvi](https://github.com/faisal-alvi) via [GHSA-wfjh-m788-w2c5](https://github.com/10up/simple-local-avatars/security/advisories/GHSA-wfjh-m788-w2c5)).
- Bump `axios` from 1.6.7 to 1.7.4 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#298](https://github.com/10up/simple-local-avatars/pull/298)).
- Bump `webpack` from 5.90.0 to 5.94.0 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#303](https://github.com/10up/simple-local-avatars/pull/303)).
- Bump `ws` from 7.5.10 to 8.18.0 and `@wordpress/scripts` from 27.1.0 to 30.4.0 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#305](https://github.com/10up/simple-local-avatars/pull/305), [#311](https://github.com/10up/simple-local-avatars/pull/311)).
- Bump `body-parser` from 1.20.2 to 1.20.3, `express` from 4.19.2 to 4.21.0, `send` from 0.18.0 to 0.19.0 and `serve-static` from 1.15.0 to 1.16.2 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#306](https://github.com/10up/simple-local-avatars/pull/306)).

### Developer
- Update repo badges, add WordPress Playground badge, add plugin banner image (props [@faisal-alvi](https://github.com/faisal-alvi), [@thrijith](https://github.com/thrijith), [@jeffpaul](https://github.com/jeffpaul) via [#297](https://github.com/10up/simple-local-avatars/pull/297), [#300](https://github.com/10up/simple-local-avatars/pull/300), [#304](https://github.com/10up/simple-local-avatars/pull/304), [#307](https://github.com/10up/simple-local-avatars/pull/307)).

## [2.7.11] - 2024-07-18
**Note that this release bumps the minimum required version of WordPress from 6.3 to 6.4.**

### Changed
- Bumped WordPress "tested up to" version 6.6 and minimum version to 6.4 (props [@sudip-md](https://github.com/sudip-md), [@ankitguptaindia](https://github.com/ankitguptaindia), [@jeffpaul](https://github.com/jeffpaul) via [#289](https://github.com/10up/simple-local-avatars/pull/289), [#290](https://github.com/10up/simple-local-avatars/pull/290)).

### Security
- Add nonce check when saving the default avatar ID (props [@faisal-alvi](https://github.com/faisal-alvi), [@aaemnnosttv](https://github.com/aaemnnosttv), [@rafiem](https://github.com/rafiem), [@dkotter](https://github.com/dkotter) via [GHSA-46pw-6m35-9m7x](https://github.com/10up/simple-local-avatars/security/advisories/GHSA-46pw-6m35-9m7x)).
- Bump `braces` from 3.0.2 to 3.0.3, `pac-resolver` from 7.0.0 to 7.0.1, `socks` from 2.7.1 to 2.8.3 and removes `ip` (props [@dependabot](https://github.com/apps/dependabot), [@Sidsector9](https://github.com/Sidsector9) via [#286](https://github.com/10up/simple-local-avatars/pull/286)).
- Bump `ws` from 7.5.9 to 7.5.10 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#287](https://github.com/10up/simple-local-avatars/pull/287)).

## [2.7.10] - 2024-05-24
### Fixed
- Fix Default Avatar Fallback (props [@amirhossein7](https://profiles.wordpress.org/amirhossein7/), [@faisal-alvi](https://github.com/faisal-alvi), [@dkotter](https://github.com/dkotter), [@qasumitbagthariya](https://github.com/qasumitbagthariya) via [#281](https://github.com/10up/simple-local-avatars/pull/281)).

### Security
- Bump `express` from 4.18.2 to 4.19.2 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#269](https://github.com/10up/simple-local-avatars/pull/269)).
- Bump `follow-redirects` from 1.15.5 to 1.15.6 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#269](https://github.com/10up/simple-local-avatars/pull/269)).
- Bump `ip` from 1.1.8 to 1.1.9 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#269](https://github.com/10up/simple-local-avatars/pull/269)).
- Bump `webpack-dev-middleware` from 5.3.3 to 5.3.4 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#269](https://github.com/10up/simple-local-avatars/pull/269)).

## [2.7.9] - 2024-05-14
### Fixed
- Ensure default Gravatar avatars are shown correctly (props [@faisal-alvi](https://github.com/faisal-alvi), [@dkotter](https://github.com/dkotter), [@horrormoviesgr](https://profiles.wordpress.org/horrormoviesgr/), [@inpeaks](https://profiles.wordpress.org/inpeaks/), [@lillylark](https://profiles.wordpress.org/lillylark/), [@rafaucau](https://github.com/rafaucau), [@janrenn](https://profiles.wordpress.org/janrenn/) via [#278](https://github.com/10up/simple-local-avatars/pull/278)).

## [2.7.8] - 2024-05-08
**Note that this release bumps the minimum required version of WordPress from 5.7 to 6.3.**

### Added
- "Testing" section in the `CONTRIBUTING.md` file (props [@kmgalanakis](https://github.com/kmgalanakis), [@jeffpaul](https://github.com/jeffpaul) via [#274](https://github.com/10up/simple-local-avatars/pull/274)).

### Changed
- Bumped WordPress "tested up to" version 6.5 (props [@sudip-md](https://github.com/sudip-md), [@dkotter](https://github.com/dkotter), [@jeffpaul](https://github.com/jeffpaul) via [#270](https://github.com/10up/simple-local-avatars/pull/270)).
- Move `simple_local_avatar_deleted` action to `avatar_delete` (props [@lllopo](https://github.com/lllopo), [@faisal-alvi](https://github.com/faisal-alvi), [@dkotter](https://github.com/dkotter) via [#255](https://github.com/10up/simple-local-avatars/pull/255)).
- Clean up NPM dependencies and update node to `v20` (props [@Sidsector9](https://github.com/Sidsector9), [@dkotter](https://github.com/dkotter) via [#257](https://github.com/10up/simple-local-avatars/pull/257)).
- Update `CODEOWNERS` of the plugin (props [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#253](https://github.com/10up/simple-local-avatars/pull/253)).
- Disabled auto sync pull requests with target branch (props [@iamdharmesh](https://github.com/iamdharmesh), [@jeffpaul](https://github.com/jeffpaul) via [#263](https://github.com/10up/simple-local-avatars/pull/263)).
- Upgrade `download-artifact` from v3 to v4 (props [@iamdharmesh](https://github.com/iamdharmesh), [@jeffpaul](https://github.com/jeffpaul) via [#265](https://github.com/10up/simple-local-avatars/pull/265)).
- Replaced `lee-dohm/no-response` with `actions/stale` to help with closing `no-response/stale` issues (props [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#266](https://github.com/10up/simple-local-avatars/pull/266)).

### Fixed
- Broken default avatar when `Local Avatars Only` is unchecked (props [@faisal-alvi](https://github.com/faisal-alvi), [@ankitguptaindia](https://github.com/ankitguptaindia), [@qasumitbagthariya](https://github.com/qasumitbagthariya) via [#260](https://github.com/10up/simple-local-avatars/pull/260)).
- Ensure high-quality avatar preview on profile edit screen (props [@ocean90](https://github.com/ocean90), [@dkotter](https://github.com/dkotter) via [#273](https://github.com/10up/simple-local-avatars/pull/273)).
- Possible PHP warning (props [@BhargavBhandari90](https://github.com/BhargavBhandari90), [@dkotter](https://github.com/dkotter) via [#261](https://github.com/10up/simple-local-avatars/pull/261)).
- Fixed typos (props [@szepeviktor](https://github.com/szepeviktor), [@dkotter](https://github.com/dkotter) via [#268](https://github.com/10up/simple-local-avatars/pull/268)).

## [2.7.7] - 2023-12-13
### Fixed
- Revert the Host/Domain support for local avatar URL (props [@faisal-alvi](https://github.com/faisal-alvi), [@jakejackson1](https://github.com/jakejackson1), [@leogermani](https://github.com/leogermani), [@dkotter](https://github.com/dkotter) via [#247](https://github.com/10up/simple-local-avatars/pull/247)).

### Security
- Bump `axios` from 0.25.0 to 1.6.2 and `@wordpress/scripts` from 23.7.2 to 26.18.0 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#250](https://github.com/10up/simple-local-avatars/pull/250)).

## [2.7.6] - 2023-11-30
### Added
- Check for minimum required PHP version before loading the plugin (props [@kmgalanakis](https://github.com/kmgalanakis), [@faisal-alvi](https://github.com/faisal-alvi) via [#226](https://github.com/10up/simple-local-avatars/pull/226)).
- `pre_simple_local_avatar_url` filter to allow an avatar image to be short-circuited before Simple Local Avatars processes it (props [@johnbillion](https://github.com/johnbillion), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#237](https://github.com/10up/simple-local-avatars/pull/237)).
- Repo Automator GitHub Action (props [@iamdharmesh](https://github.com/iamdharmesh), [@faisal-alvi](https://github.com/faisal-alvi) via [#228](https://github.com/10up/simple-local-avatars/pull/228)).
- E2E test for checking the front end of avatars (props [@Firestorm980](https://github.com/Firestorm980), [@iamdharmesh](https://github.com/iamdharmesh) via [#219](https://github.com/10up/simple-local-avatars/pull/219)).

### Changed
- Bumped WordPress "tested up to" version 6.4 (props [@zamanq](https://github.com/zamanq), [@ankitguptaindia](https://github.com/ankitguptaindia), [@faisal-alvi](https://github.com/faisal-alvi), [@qasumitbagthariya](https://github.com/qasumitbagthariya) via [#230](https://github.com/10up/simple-local-avatars/pull/230), [#244](https://github.com/10up/simple-local-avatars/pull/244)).
- Update the Dependency Review GitHub Action to leverage our org-wide config file to check for GPL-compatible licenses (props [@jeffpaul](https://github.com/jeffpaul), [@faisal-alvi](https://github.com/faisal-alvi) via [#215](https://github.com/10up/simple-local-avatars/pull/215)).
- Documentation updates (props [@jeffpaul](https://github.com/jeffpaul), [@faisal-alvi](https://github.com/faisal-alvi) via [#242](https://github.com/10up/simple-local-avatars/pull/242)).

### Fixed
- Address conflicts with other plugins and loading the media API (props [@EHLOVader](https://github.com/EHLOVader), [@dkotter](https://github.com/dkotter) via [#218](https://github.com/10up/simple-local-avatars/pull/218)).
- Prevent PHP fatal error when switching from a multisite to single site installation (props [@ocean90](https://github.com/ocean90), [@ravinderk](https://github.com/ravinderk), [@faisal-alvi](https://github.com/faisal-alvi) via [#222](https://github.com/10up/simple-local-avatars/pull/222)).
- Local avatar urls remain old after domain/host change (props [@jayedul](https://github.com/jayedul), [@ravinderk](https://github.com/ravinderk), [@jeffpaul](https://github.com/jeffpaul), [@faisal-alvi](https://github.com/faisal-alvi) via [#216](https://github.com/10up/simple-local-avatars/pull/216)).

### Security
- Bump `word-wrap` from 1.2.3 to 1.2.4 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#223](https://github.com/10up/simple-local-avatars/pull/223)).
- Bump `tough-cookie` from 4.1.2 to 4.1.3 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#225](https://github.com/10up/simple-local-avatars/pull/225)).
- Bump `@cypress/request` from 2.88.10 to 3.0.0 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#225](https://github.com/10up/simple-local-avatars/pull/225), [#234](https://github.com/10up/simple-local-avatars/pull/234)).
- Bump `cypress` from 11.2.0 to 13.2.0 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi), [@iamdharmesh](https://github.com/iamdharmesh) via [#234](https://github.com/10up/simple-local-avatars/pull/234), [#236](https://github.com/10up/simple-local-avatars/pull/236)).
- Bump `postcss` from 8.4.21 to 8.4.31 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#238](https://github.com/10up/simple-local-avatars/pull/238)).
- Bump `@babel/traverse` from 7.20.12 to 7.23.2 (props [@dependabot](https://github.com/apps/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#240](https://github.com/10up/simple-local-avatars/pull/240)).
- Bump `@10up/cypress-wp-utils` version to 0.2.0 (props [@iamdharmesh](https://github.com/iamdharmesh), [@faisal-alvi](https://github.com/faisal-alvi) via [#236](https://github.com/10up/simple-local-avatars/pull/236)).
- Bump `@wordpress/env` version from 5.2.0 to 8.7.0 (props [@iamdharmesh](https://github.com/iamdharmesh), [@faisal-alvi](https://github.com/faisal-alvi) via [#236](https://github.com/10up/simple-local-avatars/pull/236)).
- Bump `cypress-mochawesome-reporter` version from 3.0.1 to 3.6.0 (props [@iamdharmesh](https://github.com/iamdharmesh), [@faisal-alvi](https://github.com/faisal-alvi) via [#236](https://github.com/10up/simple-local-avatars/pull/236)).

## [2.7.5] - 2023-05-15
### Added
- Ajax loading animation during process of uploading and deleting local avatars (props [@lllopo](https://github.com/lllopo), [@BhargavBhandari90](https://github.com/BhargavBhandari90), [@faisal-alvi](https://github.com/faisal-alvi) via [#204](https://github.com/10up/simple-local-avatars/pull/204)).

### Changed
- Avatar removal button text (props [@jayedul](https://github.com/jayedul), [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter), [@faisal-alvi](https://github.com/faisal-alvi) via [#208](https://github.com/10up/simple-local-avatars/pull/208)).
- WordPress "tested up to" version 6.2 (props [@jayedul](https://github.com/jayedul), [@faisal-alvi](https://github.com/faisal-alvi) via [#210](https://github.com/10up/simple-local-avatars/pull/210)).
- Run E2E tests on the zip generated by "Build release zip" action (props [@jayedul](https://github.com/jayedul), [@iamdharmesh](https://github.com/iamdharmesh), [@faisal-alvi](https://github.com/faisal-alvi) via [#205](https://github.com/10up/simple-local-avatars/pull/205)).

### Security
- Bump `webpack` from 5.75.0 to 5.76.1 (props [@dependabot](https://github.com/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#207](https://github.com/10up/simple-local-avatars/pull/207)).

## [2.7.4] - 2023-02-23
### Fixed
- Support passing `WP_User` to `get_avatar()` (props [@mattheu](https://github.com/mattheu), [@faisal-alvi](https://github.com/faisal-alvi) via [#193](https://github.com/10up/simple-local-avatars/pull/193)).
- Remove trailing commas in function calls (props [@patrixer](https://github.com/patrixer), [@dkotter](https://github.com/dkotter), [@sekra24](https://github.com/sekra24), [@faisal-alvi](https://github.com/faisal-alvi) via [#196](https://github.com/10up/simple-local-avatars/pull/196)).

### Security
- Bump `simple-git` from 3.15.1 to 3.16.0 (props [@dependabot](https://github.com/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#191](https://github.com/10up/simple-local-avatars/pull/191)).
- Bump `http-cache-semantics` from 4.1.0 to 4.1.1 (props [@dependabot](https://github.com/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#197](https://github.com/10up/simple-local-avatars/pull/197)).

## [2.7.3] - 2023-01-16
### Fixed
- Issue causing fatal errors when avatars used on front end of site (props [@Rottinator](https://github.com/Rottinator), [@peterwilsoncc](https://github.com/peterwilsoncc), [@ravinderk](https://github.com/ravinderk), [@faisal-alvi](https://github.com/faisal-alvi) via [#187](https://github.com/10up/simple-local-avatars/pull/187)).
- Deprecation error in admin on PHP 8.0 and later (props [@Rottinator](https://github.com/Rottinator), [@peterwilsoncc](https://github.com/peterwilsoncc), [@ravinderk](https://github.com/ravinderk), [@faisal-alvi](https://github.com/faisal-alvi) via [#187](https://github.com/10up/simple-local-avatars/pull/187)).

## [2.7.2] - 2023-01-13
### Added
- Filter hook `simple_local_avatars_upload_limit` to restrict image upload size & image file checking enhanced (props [@Shirkit](https://github.com/Shirkit), [@jayedul](https://github.com/jayedul), [@faisal-alvi](https://github.com/faisal-alvi), [@jeffpaul](https://github.com/jeffpaul) via [#171](https://github.com/10up/simple-local-avatars/pull/171)).
- GitHub Actions summary on Cypress e2e test runs (props [@faisal-alvi](https://github.com/faisal-alvi), [@jeffpaul](https://github.com/jeffpaul), [@iamdharmesh](https://github.com/iamdharmesh) via [#174](https://github.com/10up/simple-local-avatars/pull/174)).

### Changed
- Cypress integration migrated from 9.5.4 to 11.2.0 (props [@iamdharmesh](https://github.com/iamdharmesh), [@jayedul](https://github.com/jayedul), [@faisal-alvi](https://github.com/faisal-alvi) via [#172](https://github.com/10up/simple-local-avatars/pull/172)).

### Fixed
- PHP8 support for `assign_new_user_avatar` (props [@lllopo](https://github.com/lllopo), [@mattwatsoncodes](https://github.com/mattwatsoncodes), [@faisal-alvi](https://github.com/faisal-alvi) via [#183](https://github.com/10up/simple-local-avatars/pull/183)).
- Fixed the user profile language not respected issue (props [@dkotter](https://github.com/dkotter), [@lllopo](https://github.com/lllopo), [@faisal-alvi](https://github.com/faisal-alvi), [@jeffpaul](https://github.com/jeffpaul) via [#175](https://github.com/10up/simple-local-avatars/pull/175)).

### Removed
- textdomain from the core strings and the function `update_avatar_ratings` as it's not required anymore (props [@dkotter](https://github.com/dkotter), [@lllopo](https://github.com/lllopo), [@faisal-alvi](https://github.com/faisal-alvi), [@jeffpaul](https://github.com/jeffpaul) via [#175](https://github.com/10up/simple-local-avatars/pull/175)).

### Security
- Bump `json5` from 1.0.1 to 1.0.2 (props [@dependabot](https://github.com/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#182](https://github.com/10up/simple-local-avatars/pull/182)).

## [2.7.1] - 2022-12-08
### Added
- Added missing files from the last release and changed the readme file to fix the bullet points and added fullstops.

## [2.7.0] - 2022-12-08
### Added
- Added `Build release zip` GitHub Action (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@faisal-alvi](https://github.com/faisal-alvi) via [#168](https://github.com/10up/simple-local-avatars/pull/168)).

### Changed
- Set plugin defaults on `wp_initialize_site` instead of deprecated action `wpmu_new_blog` (props [@kadamwhite](https://github.com/kadamwhite), [@faisal-alvi](https://github.com/faisal-alvi) via [#156](https://github.com/10up/simple-local-avatars/pull/156)).
- Support Level from Active to Stable (props [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter) via [#159](https://github.com/10up/simple-local-avatars/pull/159)).
- Build tools: Allow PHPCS installer plugin to run without prompting user (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@jeffpaul](https://github.com/jeffpaul) via [#164](https://github.com/10up/simple-local-avatars/pull/164)).
- WP tested up to version bump to 6.1 (props [@peterwilsoncc](https://github.com/peterwilsoncc), [@faisal-alvi](https://github.com/faisal-alvi) via [#165](https://github.com/10up/simple-local-avatars/pull/165)).

### Fixed
- Non admin users can not crop avatar (props [@jayedul](https://github.com/jayedul), [@faisal-alvi](https://github.com/faisal-alvi), [@zamanq](https://github.com/zamanq), [@dkotter](https://github.com/dkotter), [@jeffpaul](https://github.com/jeffpaul) via [#155](https://github.com/10up/simple-local-avatars/pull/155)).

### Security
- Bump `@wordpress/env` from 4.9.0 to 5.2.0 and `got` from 10.7.0 to 11.8.5 (props [@dependabot](https://github.com/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#153](https://github.com/10up/simple-local-avatars/pull/153)).
- Bump `loader-utils` from 2.0.2 to 2.0.3 (props [@dependabot](https://github.com/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#160](https://github.com/10up/simple-local-avatars/pull/160)).
- Bump `loader-utils` from 2.0.3 to 2.0.4 (props [@dependabot](https://github.com/dependabot), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#162](https://github.com/10up/simple-local-avatars/pull/162)).
- Bump `simple-git` from 3.9.0 to 3.15.1 (props [@dependabot](https://github.com/dependabot) via [#176](https://github.com/10up/simple-local-avatars/pull/176)).

## [2.6.0] - 2022-09-13
**Note that this release bumps the minimum required version of WordPress from 4.6 to 5.7 and PHP from 5.6 to 7.4.**

### Added
- If a default avatar image is used, ensure that outputs alt text. This will either be default text (Avatar photo) or the alt text from the uploaded default image (props [@dkotter](https://github.com/dkotter), [@faisal-alvi](https://github.com/faisal-alvi) via [#147](https://github.com/10up/simple-local-avatars/pull/147)).
- Two hooks, `simple_local_avatar_updated` and `simple_local_avatar_deleted`, to allow theme or plugin developers to react to changes in local avatars in a consistent and precise way (props [@t-lock](https://github.com/t-lock), [@faisal-alvi](https://github.com/faisal-alvi), [@dkotter](https://github.com/dkotter) via [#149](https://github.com/10up/simple-local-avatars/pull/149)).

### Changed
- Bump minimum required version of WordPress from 4.6 to 5.7 (props [@vikrampm1](https://github.com/vikrampm1), [@faisal-alvi](https://github.com/faisal-alvi), [@cadic](https://github.com/cadic) via [#143](https://github.com/10up/simple-local-avatars/pull/143)).
- Bump minimum required version of PHP from 5.6 to 7.4 (props [@vikrampm1](https://github.com/vikrampm1), [@faisal-alvi](https://github.com/faisal-alvi), [@cadic](https://github.com/cadic) via [#143](https://github.com/10up/simple-local-avatars/pull/143)).
- The plugin is now available via Composer without any additional steps required (props [@faisal-alvi](https://github.com/faisal-alvi), [@kovshenin](https://github.com/kovshenin), [@jeffpaul](https://github.com/jeffpaul) via [#145](https://github.com/10up/simple-local-avatars/pull/145)).

### Security
- Bump `terser` from 5.14.1 to 5.14.2 (props [@dependabot](https://github.com/dependabot), [@faisal-alvi](https://github.com/faisal-alvi) via [#142](https://github.com/10up/simple-local-avatars/pull/142)).

## [2.5.0] - 2022-06-24
### Added
- Skip cropping button (props [@dkotter](https://github.com/dkotter), [@faisal-alvi](https://github.com/faisal-alvi), [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul), [@dinhtungdu](https://github.com/dinhtungdu) via [#130](https://github.com/10up/simple-local-avatars/pull/130))!
- Updated the button name from "Skip Crop" to "Default Crop" only on the edit profile page (props [@faisal-alvi](https://github.com/faisal-alvi), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#136](https://github.com/10up/simple-local-avatars/pull/136)).
- If an image used for a local avatar has alt text assigned, ensure that alt text is used when rendering the image (props [@dkotter](https://github.com/dkotter), [@pixelloop](https://github.com/pixelloop), [@faisal-alvi](https://github.com/faisal-alvi) via [#127](https://github.com/10up/simple-local-avatars/pull/127)).
- Support for bbPress by loading the JS at FE on the profile edit page (props [@foliovision](https://github.com/foliovision), [@faisal-alvi](https://github.com/faisal-alvi), [@iamdharmesh](https://github.com/iamdharmesh) via [#134](https://github.com/10up/simple-local-avatars/pull/134)).
- Cypress E2E tests (props [@faisal-alvi](https://github.com/faisal-alvi), [@vikrampm1](https://github.com/vikrampm1), [@Sidsector9](https://github.com/Sidsector9) via [#115](https://github.com/10up/simple-local-avatars/pull/115)).

### Fixed
- Broken avatar URLs for network-configured shared avatars with non-standard thumbnail sizes (props [@vladolaru](https://github.com/vladolaru), [@faisal-alvi](https://github.com/faisal-alvi) via [#125](https://github.com/10up/simple-local-avatars/pull/125)).
- `HTTP_REFERER` is null and causing PHP warning (props [@alireza-salehi](https://github.com/alireza-salehi), [@faisal-alvi](https://github.com/faisal-alvi), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#129](https://github.com/10up/simple-local-avatars/pull/129)).

## [2.4.0] - 2022-05-10
### Added
- Ability to set a default avatar. (props [@mehulkaklotar](https://github.com/mehulkaklotar), [@jeffpaul](https://github.com/jeffpaul), [@dinhtungdu](https://github.com/dinhtungdu), [@faisal-alvi](https://github.com/faisal-alvi) via [#96](https://github.com/10up/simple-local-avatars/pull/96)).

### Fixed
- Correct plugin name in changelog. (props [@grappler](https://github.com/grappler), [@jeffpaul](https://github.com/jeffpaul) via [#117](https://github.com/10up/simple-local-avatars/pull/117)).
- Avatar cache not being cleared. (props [@thefrosty](https://github.com/thefrosty), [@jeffpaul](https://github.com/jeffpaul), [@faisal-alvi](https://github.com/faisal-alvi), [@peterwilsoncc](https://github.com/peterwilsoncc) via [#118](https://github.com/10up/simple-local-avatars/pull/118) & [#120](https://github.com/10up/simple-local-avatars/pull/120)).

### Security
- Dev dependency `@wordpress/scripts` upgraded to resolve deeper level dependency security issues. (props [@jeffpaul](https://github.com/jeffpaul), [@faisal-alvi](https://github.com/faisal-alvi), [@cadic](https://github.com/cadic) via [#119](https://github.com/10up/simple-local-avatars/pull/119)).

## [2.3.0] - 2022-04-25
### Added
- Crop screen (props [@jeffpaul](https://github.com/jeffpaul), [@helen](https://github.com/helen), [@ajmaurya99](https://github.com/ajmaurya99), [@Antonio-Laguna](https://github.com/Antonio-Laguna), [@faisal-alvi](https://github.com/faisal-alvi) via [#83](https://github.com/10up/simple-local-avatars/pull/83)).
- Avatar preview for Subscribers (props [@ankitguptaindia](https://github.com/ankitguptaindia), [@dinhtungdu](https://github.com/dinhtungdu), [@dkotter](https://github.com/dkotter) via [#74](https://github.com/10up/simple-local-avatars/pull/74)).
- More robust multisite support and shared avatar setting (props [@adamsilverstein](https://github.com/adamsilverstein), [@helen](https://github.com/helen), [@jeffpaul](https://github.com/jeffpaul), [@dkotter](https://github.com/dkotter), [@faisal-alvi](https://github.com/faisal-alvi), [@holle75](https://github.com/holle75) via [#72](https://github.com/10up/simple-local-avatars/pull/72)).
- Settings link to plugin action links (props [@rahulsprajapati](https://github.com/rahulsprajapati), [@jeffpaul](https://github.com/jeffpaul), [@iamdharmesh](https://github.com/iamdharmesh) via [#92](https://github.com/10up/simple-local-avatars/pull/92)).
- Dashboard setting and WP-CLI command to migrate avatars from [WP User Avatar](https://wordpress.org/plugins/wp-user-avatar/) (props [@jeffpaul](https://github.com/jeffpaul), [@claytoncollie](https://github.com/claytoncollie), [@helen](https://github.com/helen), [@faisal-alvi](https://github.com/faisal-alvi) via [#85](https://github.com/10up/simple-local-avatars/pull/85)).
- Option to clear cache of user meta to remove image sizes that do not exist (props [@jeffpaul](https://github.com/jeffpaul), [@ituk](https://github.com/ituk), [@dinhtungdu](https://github.com/dinhtungdu), [@sparkbold](https://github.com/sparkbold), [@thrijith](https://github.com/thrijith) via [#90](https://github.com/10up/simple-local-avatars/pull/90)).
- Package file (props [@faisal-alvi](https://github.com/faisal-alvi), [@jeffpaul](https://github.com/jeffpaul), [@claytoncollie](https://github.com/claytoncollie), [@cadic](https://github.com/cadic) via [#94](https://github.com/10up/simple-local-avatars/pull/94)).
- PHP Unit Tests (props [@faisal-alvi](https://github.com/faisal-alvi), [@iamdharmesh](https://github.com/iamdharmesh) via [#101](https://github.com/10up/simple-local-avatars/pull/101)).
- "No Response" GitHub Action (props [@jeffpaul](https://github.com/jeffpaul) via [#84](https://github.com/10up/simple-local-avatars/pull/84)).

### Changed
- Bump WordPress "tested up to" version to 5.9 (props [@jeffpaul](https://github.com/jeffpaul), [@ankitguptaindia](https://github.com/ankitguptaindia), [@dinhtungdu](https://github.com/dinhtungdu), [@phpbits](https://github.com/phpbits) via [#67](https://github.com/10up/simple-local-avatars/pull/67), [#75](https://github.com/10up/simple-local-avatars/pull/75), [#81](https://github.com/10up/simple-local-avatars/pull/81), [#97](https://github.com/10up/simple-local-avatars/pull/97)).
- Bump WordPress "tested up to" version to 6.0 (props [@ajmaurya99](https://github.com/ajmaurya99) via [#110](https://github.com/10up/simple-local-avatars/pull/110))
- Format admin script (props [@thrijith](https://github.com/thrijith), [@dinhtungdu](https://github.com/dinhtungdu) via [#91](https://github.com/10up/simple-local-avatars/pull/91)).

### Fixed
- Media ID as string in REST API (props [@diodoe](https://github.com/diodoe), [@dinhtungdu](https://github.com/dinhtungdu), [@dkotter](https://github.com/dkotter) via [#71](https://github.com/10up/simple-local-avatars/pull/71)).
- Avatar rating text is not translated properly if a user has a custom language Set (props [@ActuallyConnor](https://github.com/ActuallyConnor), [@faisal-alvi](https://github.com/faisal-alvi) via [#89](https://github.com/10up/simple-local-avatars/pull/89)).

### Security
- PHP 8 compatibility (props [@faisal-alvi](https://github.com/faisal-alvi), [@dkotter](https://github.com/dkotter), [@Sidsector9](https://github.com/Sidsector9) via [#103](https://github.com/10up/simple-local-avatars/pull/103)).
- Bump `rmccue/requests` from 1.7.0 to 1.8.0 (props [dependabot@](https://github.com/dependabot) via [#77](https://github.com/10up/simple-local-avatars/pull/77)).
- Bump `nanoid` from 3.1.28 to 3.2.0 (props [dependabot@](https://github.com/dependabot) via [#98](https://github.com/10up/simple-local-avatars/pull/98)).
- Bump `minimist` from 1.2.5 to 1.2.6 (props [dependabot@](https://github.com/dependabot) via [#105](https://github.com/10up/simple-local-avatars/pull/105)).

## [2.2.0] - 2020-10-27
### Added
- `$args` parameter to `get_simple_local_avatar` function (props [@dinhtungdu](https://github.com/dinhtungdu), [@heyjones](https://github.com/heyjones), [@dkotter](https://github.com/dkotter), [@sumnercreations](https://github.com/sumnercreations), [@dshanske](https://github.com/dshanske) via [#40](https://github.com/10up/simple-local-avatars/pull/40))
- `Simple_Local_Avatars::get_avatar_data()`, `Simple_Local_Avatars::get_simple_local_avatar_url()`, and `Simple_Local_Avatars::get_default_avatar_url()` methods (props [@dinhtungdu](https://github.com/dinhtungdu), [@heyjones](https://github.com/heyjones), [@dkotter](https://github.com/dkotter), [@sumnercreations](https://github.com/sumnercreations), [@dshanske](https://github.com/dshanske) via [#40](https://github.com/10up/simple-local-avatars/pull/40))
- Ability to retrieve avatar with `WP_Post` object (props [@oscarssanchez](https://github.com/oscarssanchez), [@blobaugh](https://github.com/blobaugh) via [#47](https://github.com/10up/simple-local-avatars/pull/47))
- Add class and ID to Avatar section on Profile Page to allow easier styling (props [@dinhtungdu](https://github.com/dinhtungdu) via [#54](https://github.com/10up/simple-local-avatars/pull/54))
- [WP Acceptance](https://github.com/10up/wpacceptance/) test coverage (props [@dinhtungdu](https://github.com/dinhtungdu) via [#53](https://github.com/10up/simple-local-avatars/pull/53))

### Changed
- Switched to `pre_get_avatar_data` filter (props [@dinhtungdu](https://github.com/dinhtungdu), [@heyjones](https://github.com/heyjones), [@dkotter](https://github.com/dkotter), [@sumnercreations](https://github.com/sumnercreations), [@dshanske](https://github.com/dshanske) via [#40](https://github.com/10up/simple-local-avatars/pull/40))
- Changed `assign_new_user_avatar` function to public (props [@tripflex](https://github.com/tripflex) via [#48](https://github.com/10up/simple-local-avatars/pull/48))
- Split the main class into its own file, added unit tests, and set up testing GitHub action (props [@dinhtungdu](https://github.com/dinhtungdu), [@helen](https://github.com/helen), [@stevegrunwell](https://github.com/stevegrunwell) via [#59](https://github.com/10up/simple-local-avatars/pull/59))
- New plugin banner and icon (props [@JackieKjome](https://github.com/JackieKjome) via [#52](https://github.com/10up/simple-local-avatars/pull/52))
- Bump WordPress version "tested up to" 5.5 (props [@Waka867](https://github.com/Waka867), [@tmoorewp](https://github.com/tmoorewp), [@jeffpaul](https://github.com/jeffpaul), [@dinhtungdu](https://github.com/dinhtungdu) via [#36](https://github.com/10up/simple-local-avatars/pull/36), [#43](https://github.com/10up/simple-local-avatars/pull/43), [#52](https://github.com/10up/simple-local-avatars/pull/52))
- GitHub Actions from HCL to YAML workflow syntax (props [@jeffpaul](https://github.com/jeffpaul) via [#37](https://github.com/10up/simple-local-avatars/pull/37))
- Documentation updates (props [@jeffpaul](https://github.com/jeffpaul) via [#29](https://github.com/10up/simple-local-avatars/pull/29), [#30](https://github.com/10up/simple-local-avatars/pull/30), [#33](https://github.com/10up/simple-local-avatars/pull/33), [#45](https://github.com/10up/simple-local-avatars/pull/45), [#50](https://github.com/10up/simple-local-avatars/pull/50), [#52](https://github.com/10up/simple-local-avatars/pull/52))

### Fixed
- Initialize `Simple_Local_Avatars` on the `$simple_local_avatars` global, enabling bundling plugin with composer (props [@pdewouters](https://github.com/pdewouters), [@adamsilverstein](https://github.com/adamsilverstein) via [#34](https://github.com/10up/simple-local-avatars/pull/34))

### Removed
- `get_avatar` function that overrides the core function (props [@dinhtungdu](https://github.com/dinhtungdu), [@heyjones](https://github.com/heyjones), [@dkotter](https://github.com/dkotter), [@sumnercreations](https://github.com/sumnercreations), [@dshanske](https://github.com/dshanske) via [#40](https://github.com/10up/simple-local-avatars/pull/40))

## [2.1.1] - 2019-05-07
### Fixed
- Do not delete avatars just because they don't exist on the local filesystem. This was occasionally dumping avatars when WordPress uploads were stored elsewhere, e.g. a cloud service.

## [2.1] - 2018-10-24
### Added
- All avatar uploads now go into the media library. Don't worry - users without the ability to upload files cannot otherwise see the contents of your media library. This allows local avatars to respect other functionality your site may have around uploaded images, such as external hosting.
- REST API support for getting and updating.
- Use .org language packs rather than bundling translations.

### Fixed
- Avoid an `ArgumentCountError`.
- A couple of internationalization issues.

## [2.0] - 2013-06-02
### Added
- Choose or upload an avatar from the media library (for users with appropriate capabilities)!
- Local avatars are rated for appropriateness, just like Gravatar
- A new setting under Discussion enables administrators to turn off Gravatar (only use local avatars)
- Delete the local avatar with a single button click (like everywhere else in WordPress)
- Uploaded avatar file names are appended with the timestamp, addressing browser image caching issues
- New developer filter for preventing automatic rescaling: simple_local_avatars_dynamic_resize
- New developer filter for limiting upload size: simple_local_avatars_upload_limit
- Upgraded functions deprecated since WordPress 3.5
- Hungarian translation added (needs further updating again with new version)

### Fixed
- Fixed translations not working on front end (although translations are now a bit out of date...)
- Assorted refactoring / improvements under the hood

## [1.3.1] - 2011-12-29
### Added
- Brazilian Portuguese and Belarusian translations

### Fixed
- Bug fixes (most notably correct naming of image files based on user display name)
- Optimization for WordPress 3.2 / 3.3 (substitutes deprecated function)

## [1.3] - 2011-09-22
### Added
- Avatar file name saved as "user-display-name_avatar" (or other image extension)
- Russian localization added

### Fixed
- Assorted minor code optimizations

## [1.2.4] - 2011-07-02
### Added
- Support for front end avatar uploads (e.g. Theme My Profile)

## [1.2.3] - 2011-04-04
### Added
- Russian localization

## [1.2.2] - 2011-03-25
### Fixed
- Fix for avatars uploaded pre-1.2.1 having a broken path after upgrade

## [1.2.1] - 2011-01-26
### Added
- French localization

### Fixed
- Simplify uninstall code

## [1.2] - 2011-01-26
### Added
- Spanish localization
- Other minor under the hood optimizations

### Fixed
- Fix path issues on some IIS servers (resulting in missing avatar images)
- Fix rare uninstall issues related to deleted avatars

## [1.1.3] - 2011-01-20
### Fixed
- Properly deletes old avatars upon changing avatar
- Fixes "foreach" warning in debug mode when updating avatar image

## [1.1.2] - 2011-01-18
### Added
- Norwegian localization

## [1.1.1] - 2011-01-18
### Added
- Italian localization

## [1.1] - 2011-01-18
### Added
- All users (regardless of capabilities) can upload avatars by default. To limit avatar uploading to users with upload files capabilities (Authors and above), check the applicable option under Settings > Discussion. This was the default behavior in 1.0.
- Localization support; German included

## [1.0] - 2011-01-18
- Initial release

[Unreleased]: https://github.com/10up/simple-local-avatars/compare/trunk...develop
[2.8.1]: https://github.com/10up/simple-local-avatars/compare/2.8.0...2.8.1
[2.8.0]: https://github.com/10up/simple-local-avatars/compare/2.7.11...2.8.0
[2.7.11]: https://github.com/10up/simple-local-avatars/compare/2.7.10...2.7.11
[2.7.10]: https://github.com/10up/simple-local-avatars/compare/2.7.9...2.7.10
[2.7.9]: https://github.com/10up/simple-local-avatars/compare/2.7.8...2.7.9
[2.7.8]: https://github.com/10up/simple-local-avatars/compare/2.7.7...2.7.8
[2.7.7]: https://github.com/10up/simple-local-avatars/compare/2.7.6...2.7.7
[2.7.6]: https://github.com/10up/simple-local-avatars/compare/2.7.5...2.7.6
[2.7.5]: https://github.com/10up/simple-local-avatars/compare/2.7.4...2.7.5
[2.7.4]: https://github.com/10up/simple-local-avatars/compare/2.7.3...2.7.4
[2.7.3]: https://github.com/10up/simple-local-avatars/compare/2.7.2...2.7.3
[2.7.2]: https://github.com/10up/simple-local-avatars/compare/2.7.1...2.7.2
[2.7.1]: https://github.com/10up/simple-local-avatars/compare/2.7.0...2.7.1
[2.7.0]: https://github.com/10up/simple-local-avatars/compare/2.6.0...2.7.0
[2.6.0]: https://github.com/10up/simple-local-avatars/compare/2.5.0...2.6.0
[2.5.0]: https://github.com/10up/simple-local-avatars/compare/2.4.0...2.5.0
[2.4.0]: https://github.com/10up/simple-local-avatars/compare/2.3.0...2.4.0
[2.3.0]: https://github.com/10up/simple-local-avatars/compare/2.2.0...2.3.0
[2.2.0]: https://github.com/10up/simple-local-avatars/compare/2.1.1...2.2.0
[2.1.1]: https://github.com/10up/simple-local-avatars/compare/2.1...2.1.1
[2.1]: https://github.com/10up/simple-local-avatars/compare/2.0...2.1
[2.0]: https://github.com/10up/simple-local-avatars/compare/1.3.1...2.0
[1.3.1]: https://github.com/10up/simple-local-avatars/compare/1.3...1.3.1
[1.3]: https://github.com/10up/simple-local-avatars/compare/1.2.4...1.3
[1.2.4]: https://github.com/10up/simple-local-avatars/compare/1.2.3...1.2.4
[1.2.3]: https://github.com/10up/simple-local-avatars/compare/1.2.2...1.2.3
[1.2.2]: https://github.com/10up/simple-local-avatars/compare/1.2.1...1.2.2
[1.2.1]: https://github.com/10up/simple-local-avatars/compare/1.2...1.2.1
[1.2]: https://github.com/10up/simple-local-avatars/compare/1.1.3...1.2
[1.1.3]: https://github.com/10up/simple-local-avatars/compare/1.1.2...1.1.3
[1.1.2]: https://github.com/10up/simple-local-avatars/compare/1.1.1...1.1.2
[1.1.1]: https://github.com/10up/simple-local-avatars/compare/1.1...1.1.1
[1.1]: https://github.com/10up/simple-local-avatars/compare/1.0...1.1
[1.0]: https://github.com/10up/simple-local-avatars/releases/tag/1.0
