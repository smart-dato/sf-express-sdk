# Changelog

All notable changes to `sf-express-sdk` will be documented in this file.

## 0.0.7 - 2026-09-23

The client now fetches its access token on the first API call instead of in the constructor. Base URL and AES key can come from config (`SF_EXPRESS_BASE_URL`, `SF_EXPRESS_ENCODING_AES_KEY`), and the `SfExpress` facade is restored.

### What's Changed

* Bump stefanzweifel/git-auto-commit-action from 5 to 7 by @dependabot[bot] in https://github.com/smart-dato/sf-express-sdk/pull/9
* Bump ramsey/composer-install from 3 to 4 by @dependabot[bot] in https://github.com/smart-dato/sf-express-sdk/pull/12
* Bump dependabot/fetch-metadata from 2.5.0 to 3.1.0 by @dependabot[bot] in https://github.com/smart-dato/sf-express-sdk/pull/14
* Bump actions/checkout from 4 to 7 by @dependabot[bot] in https://github.com/smart-dato/sf-express-sdk/pull/15
* Bump actions/checkout from 7.0.0 to 7.0.1 by @dependabot[bot] in https://github.com/smart-dato/sf-express-sdk/pull/16
* fix(phpstan): silence the larastan env() false positive by @michael-tscholl in https://github.com/smart-dato/sf-express-sdk/pull/18
* fix(ci): drop the Laravel 10 leg from the test matrix by @michael-tscholl in https://github.com/smart-dato/sf-express-sdk/pull/17
* ci: check code style instead of auto-committing it by @michael-tscholl in https://github.com/smart-dato/sf-express-sdk/pull/19
* ci: commit the changelog through the API so it is signed by @michael-tscholl in https://github.com/smart-dato/sf-express-sdk/pull/20
* docs: update README and fix issues found while documenting by @michael-tscholl in https://github.com/smart-dato/sf-express-sdk/pull/21
* fix: authenticate lazily and read all settings from config by @michael-tscholl in https://github.com/smart-dato/sf-express-sdk/pull/22

### New Contributors

* @michael-tscholl made their first contribution in https://github.com/smart-dato/sf-express-sdk/pull/18

**Full Changelog**: https://github.com/smart-dato/sf-express-sdk/compare/0.0.6...0.0.7

## 0.0.5 - 2025-03-14

**Full Changelog**: https://github.com/smart-dato/sf-express-sdk/compare/0.0.4...0.0.5

## 0.0.4 - 2025-03-14

### What's Changed

* Bump dependabot/fetch-metadata from 2.2.0 to 2.3.0 by @dependabot in https://github.com/smart-dato/sf-express-sdk/pull/2
* Bump aglipanci/laravel-pint-action from 2.4 to 2.5 by @dependabot in https://github.com/smart-dato/sf-express-sdk/pull/3
* upgrade to Laravel 12 by @nahapet93 in https://github.com/smart-dato/sf-express-sdk/pull/4

### New Contributors

* @dependabot made their first contribution in https://github.com/smart-dato/sf-express-sdk/pull/2

**Full Changelog**: https://github.com/smart-dato/sf-express-sdk/compare/0.0.3...0.0.4

## 0.0.3 - 2025-01-14

**Full Changelog**: https://github.com/smart-dato/sf-express-sdk/compare/0.0.2...0.0.3

## 0.0.2 - 2025-01-14

**Full Changelog**: https://github.com/smart-dato/sf-express-sdk/compare/0.0.1...0.0.2

## 0.0.1 - 2025-01-14

### What's Changed

* Add Get shipment details by @nahapet93 in https://github.com/smart-dato/sf-express-sdk/pull/1

### New Contributors

* @nahapet93 made their first contribution in https://github.com/smart-dato/sf-express-sdk/pull/1

**Full Changelog**: https://github.com/smart-dato/sf-express-sdk/commits/0.0.1
