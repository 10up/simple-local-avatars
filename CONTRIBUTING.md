# Contributing to Simple Local Avatars

Thank you for taking an interest in contributing towards the development of Simple Local Avatars! We welcome input and contributions from the community, so here are some guidelines to help you get started:

## Git workflow

First, be sure you're *creating new branches off of `develop`, which is the base branch for this repository; new code should only be merged into `master` when we're making a new release!

For a full explanation of the Git workflow used in this project, please see [the 10up Engineering Best Practices](https://10up.github.io/Engineering-Best-Practices/version-control/#Plugins).


## Semantic versioning

This plugin follows [semantic versioning](http://semver.org/), where releases correspond to MAJOR.MINOR.PATCH versions. For example, version 2.0.0 introduced several large changes, which impacted backwards compatibility. Were we to simply add a new feature, 2.1.0 would be the next version, and a small patch on that would produce 2.1.1.

Any time there's a risk of a breaking change, the major version should be bumped and an appropriate Upgrade Notice added to the WordPress.org readme.txt file.
