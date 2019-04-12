# Changelog

All notable changes to this project will be documented in this file, per [the Keep a Changelog standard](http://keepachangelog.com/).

## [2.1] - 2018-10-24
### Added
* All avatar uploads now go into the media library. Don't worry - users without the ability to upload files cannot otherwise see the contents of your media library. This allows local avatars to respect other functionality your site may have around uploaded images, such as external hosting.
* REST API support for getting and updating.
* Use .org language packs rather than bundling translations.
### Fixed
* Avoid an `ArgumentCountError`.
* A couple of internationalization issues.

## [2.0] - 2013-06-02
### Added
* Choose or upload an avatar from the media library (for users with appropriate capabilities)!
* Local avatars are rated for appropriateness, just like Gravatar
* A new setting under Discussion enables administrators to turn off Gravatar (only use local avatars)
* Delete the local avatar with a single button click (like everywhere else in WordPress)
* Uploaded avatar file names are appended with the timestamp, addressing browser image caching issues
* New developer filter for preventing automatic rescaling: simple_local_avatars_dynamic_resize
* New developer filter for limiting upload size: simple_local_avatars_upload_limit
* Upgraded functions deprecated since WordPress 3.5
* Hungarian translation added (needs further updating again with new version)
### Fixed
* Fixed translations not working on front end (although translations are now a bit out of date...)
* Assorted refactoring / improvements under the hood

## [1.3.1] - 2011-12-29
### Added
* Brazilian Portuguese and Belarusian translations
### Fixed
* Bug fixes (most notably correct naming of image files based on user display name)
* Optimization for WordPress 3.2 / 3.3 (substitutes deprecated function)

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
### Fixed
- Fix path issues on some IIS servers (resulting in missing avatar images)
- Fix rare uninstall issues related to deleted avatars
### Added
- Spanish localization
- Other minor under the hood optimizations

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
