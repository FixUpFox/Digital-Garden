# Developer README

## Test Suite Overview

This plugin uses WordPress integration tests via PHPUnit.

Current integration coverage lives in `tests/test-plugin-integration.php` and verifies:

1. Plugin constants are defined (`DIGITAL_GARDEN_VERSION`, URL, and path).
2. The `note` custom post type is registered and REST-enabled.
3. The `note_tag` taxonomy is registered for `note` and REST-enabled.
4. Key blocks are registered (`digital-garden/container`, `digital-garden/note-block`, `digital-garden/search`).
5. Plugin activation creates the Digital Garden page and stores `digital_garden_page_id`.

## Prerequisites

1. PHP (8.1+ recommended).
2. Composer.
3. MySQL/MariaDB running locally.
4. `svn` (used by the WP test installer script).

## First-Time Setup

Run from the plugin root:

```bash
composer install
```

Install WordPress test libraries and create a dedicated test DB:

```bash
bash bin/install-wp-tests.sh dg_tests <db-user> <db-pass> 127.0.0.1 latest
```

Notes:

1. `dg_tests` is a disposable database for tests only.
2. The script downloads WordPress test files into your system temp directory.

## Run Tests

Run the full integration suite:

```bash
./vendor/bin/phpunit -c phpunit.xml.dist
```

Alternative:

```bash
composer test
```

## Troubleshooting

1. `Could not find .../wordpress-tests-lib/includes/functions.php`
Run the installer script again (`bin/install-wp-tests.sh`).

2. `Error establishing a database connection`
Verify DB user/password/host and ensure MySQL is running.

3. `The PHPUnit Polyfills library is a requirement`
Run `composer install` to install dev dependencies.
