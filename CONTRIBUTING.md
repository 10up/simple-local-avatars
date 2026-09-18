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

Helping to test an open source project and provide feedback on success or failure of those tests is also a helpful contribution. You can find details on the Critical Flows and Test Cases in [this project's GitHub Wiki](https://github.com/10up/simple-local-avatars/wiki) as well as details on our overall approach to [Critical Flows and Test Cases in our Open Source Best Practices](https://10up.github.io/Open-Source-Best-Practices/testing/#critial-flows). Submitting testing results on a pull request or issue is the best approach for providing feedback.

## Workflow

The `develop` branch is the development branch which contains the next version to be released. `stable` contains the current latest release and `trunk` contains the corresponding stable development version. Always work on the `develop` branch and open PRs against `develop`.

## Release instructions

- [ ] Branch from `develop` using `release/X.Y.Z`.
- [ ] Update the version in `package.json`, `package-lock.json`, `readme.txt`, and `simple-local-avatars.php`, including the plugin version and `SLA_VERSION`.
- [ ] Update `CHANGELOG.md`, `readme.txt`, `CREDITS.md`, and [.distignore](https://github.com/10up/simple-local-avatars/blob/develop/.distignore) as needed.
- [ ] Merge the release branch to `develop`, then `develop` into `trunk` with a non-fast-forward merge and push `trunk`.
- [ ] Compare `trunk...develop`, test the pre-release ZIP, run the relevant Critical Flows or end-to-end tests, create the release, verify the WordPress.org deployment, close the milestone, and punt incomplete items.

## Local validation

Before opening a pull request, run the checks relevant to the change and include the
commands and results in the pull request description. Keep validation focused on the
affected plugin behavior so reviewers can reproduce it quickly.
