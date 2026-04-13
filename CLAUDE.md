# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Symfony bundle (`setono/twig-cache-purger-bundle`) that purges individual Twig template cache files instead of clearing the entire cache directory. Supports PHP >=8.1 with Symfony 6.0/7.0/8.0 and Twig 2/3.

## Commands

```bash
# Install dependencies
composer install

# Run tests
composer phpunit

# Run a single test
vendor/bin/phpunit tests/Purger/PurgerTest.php
vendor/bin/phpunit --filter it_purges

# Static analysis (PHPStan at max level)
composer analyse

# Coding standards check (ECS with Sylius coding standard)
composer check-style
composer fix-style
```

## Architecture

The bundle has a single core service: `Purger` implements `PurgerInterface` with one method `purge(string $name)` that takes a logical Twig template name (e.g., `template.html.twig`), resolves it to the compiled cache file via Twig's `Environment::load()` and reflection, invalidates opcache/APC bytecode, then deletes the file.

Service wiring is XML-based in `src/Resources/config/services/purger.xml`. The purger is registered as `setono_twig_cache_purger.purger.default` with `PurgerInterface` as an alias for autowiring.

## Code Conventions

- All PHP files use `declare(strict_types=1)`
- Tests use `#[Test]` attribute (not `test` prefix) and follow `it_does_something` naming
- Tests use real Twig environments (filesystem loader + cache), not mocks
- DI extension test uses `matthiasnoback/symfony-dependency-injection-test`
- Coding standard: Sylius coding standard via ECS
