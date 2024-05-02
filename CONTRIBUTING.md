# Contributing and Maintaining

First, thank you for taking the time to contribute!

The following is a set of guidelines for contributors as well as information and instructions around our maintenance process. The two are closely tied together in terms of how we all work together and set expectations, so while you may not need to know everything in here to submit an issue or pull request, it's best to keep them in the same document.

## Ways to contribute

Contributing isn't just writing code - it's anything that improves the project. All contributions for Simple Local Avatars are managed right here on GitHub. Here are some ways you can help:

### Reporting bugs

If you're running into an issue with the plugin, please take a look through [existing issues](https://github.com/10up/simple-local-avatars/issues) and [open a new one](https://github.com/10up/simple-local-avatars/issues/new) if needed. If you're able, include steps to reproduce, environment information, and screenshots/screencasts as relevant.

### Suggesting enhancements

New features and enhancements are also managed via [issues](https://github.com/10up/simple-local-avatars/issues).

### Pull requests

Pull requests represent a proposed solution to a specified problem. They should always reference an issue that describes the problem and contains discussion about the problem itself. Discussion on pull requests should be limited to the pull request itself, i.e. code review.

For more on how 10up writes and manages code, check out our [10up Engineering Best Practices](https://10up.github.io/Engineering-Best-Practices/).

### Testing

Helping to test an open source project and provide feedback on success or failure of those tests is also a helpful contribution.  You can find details on the Critical Flows and Test Cases in [this project's GitHub Wiki](https://github.com/10up/simple-local-avatars/wiki) as well as details on our overall approach to [Critical Flows and Test Cases in our Open Source Best Practices](https://10up.github.io/Open-Source-Best-Practices/testing/#critial-flows).  Submitting the results of testing via our Critical Flows as a comment on a Pull Request of a specific feature or as an Issue when testing the entire project is the best approach for providing testing results.

## Workflow

The `develop` branch is the development branch which means it contains the next version to be released. `stable` contains the current latest release and `trunk` contains the corresponding stable development version. Always work on the `develop` branch and open up PRs against `develop`.

## Release instructions

- [ ] Branch: Starting from `develop`, cut a release branch named `release/X.Y.Z` for your changes.
- [ ] Version bump: Bump the version number in `package.json`, `package-lock.json`, `readme.txt`, and `simple-local-avatars.php` if it does not already reflect the version being released.  Update both the plugin "Version:" property and the plugin `SLA_VERSION` constant in `simple-local-avatars.php`.
- [ ] Changelog: Add/update the changelog in both `CHANGELOG.md` and `readme.txt`. (Recommendation to use: https://github.com/10up/changelog-generator)
- [ ] Props: update `CREDITS.md` with any new contributors, and confirm maintainers are accurate. (Recommendation to use: https://github.com/10up/credits-generator)
- [ ] New files: Check to be sure any new files/paths that are unnecessary in the production version are included in [.distignore](https://github.com/10up/simple-local-avatars/blob/develop/.distignore).
- [ ] Readme updates: Make any other readme changes as necessary. `README.md` is geared toward GitHub and `readme.txt` contains WordPress.org-specific content. The two are slightly different.
- [ ] Make sure the release date is added in the `CHANGELOG.md`.
- [ ] Merge: Make a non-fast-forward merge from your release branch to `develop` (or merge the pull request), then do the same for `develop` into `trunk`, ensuring you pull the most recent changes into `develop` first (`git checkout develop && git pull origin develop && git checkout trunk && git merge --no-ff develop`). `trunk` contains the latest stable release.
- [ ] Push: Push your `trunk` branch to GitHub (e.g. `git push origin trunk`).
- [ ] [Compare](https://github.com/10up/simple-local-avatars/compare/trunk...develop) `trunk` to `develop` to ensure no additional changes were missed. Visit https://github.com/10up/simple-local-avatars/compare/trunk...develop
- [ ] Test the pre-release ZIP locally by [downloading](https://github.com/10up/simple-local-avatars/actions/workflows/build-release-zip.yml) it from the **Build release zip** action artifact to ensure the plugin doesn't break after release.
- [ ] Release: Create a [new release](https://github.com/10up/simple-local-avatars/releases/new), naming the tag and the release with the new version number, and targeting the `trunk` branch.  Paste the changelog from `CHANGELOG.md` into the body of the release and include a link to the [closed issues on the milestone](https://github.com/10up/simple-local-avatars/milestone/#?closed=1).
- [ ] SVN: Wait for the [GitHub Action](https://github.com/10up/simple-local-avatars/actions/workflows/push-deploy.yml) to finish deploying to the WordPress.org repository.  If all goes well, users with SVN commit access for that plugin will receive an emailed diff of changes.
- [ ] Check WordPress.org: Ensure that the changes are live on https://wordpress.org/plugins/simple-local-avatars/. This may take a few minutes.
- [ ] Close the milestone: Edit the [milestone](https://github.com/10up/simple-local-avatars/milestone/#) with the release date (in the `Due date (optional)` field) and link to the GitHub release (in the `Description` field), then close the milestone.
- [ ] Punt incomplete items: If any open issues or PRs which were milestoned for `X.Y.Z` do not make it into the release, update their milestone to `X.Y.Z+1`, `X.Y+1.0`, `X+1.0.0` or `Future Release`.
