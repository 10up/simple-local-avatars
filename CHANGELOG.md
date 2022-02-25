# Changelog

All notable changes to this project will be documented in this file, per [the Keep a Changelog standard](http://keepachangelog.com/).

## [Unreleased] - TBD
### Changed
- Bump WordPress "tested up to" version to 5.8 (props [@phpbits](https://github.com/phpbits) via [#81](https://github.com/10up/simple-local-avatars/pull/81)).

## [2.2.0] - TBD
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

## [1.2.4]
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
