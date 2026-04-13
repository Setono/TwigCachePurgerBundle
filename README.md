# Twig Cache Purger Bundle

[![Latest Version][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![build](https://github.com/Setono/TwigCachePurgerBundle/actions/workflows/build.yaml/badge.svg)](https://github.com/Setono/TwigCachePurgerBundle/actions/workflows/build.yaml)
[![codecov](https://codecov.io/gh/Setono/TwigCachePurgerBundle/graph/badge.svg?token=6kWPwiAlBK)](https://codecov.io/gh/Setono/TwigCachePurgerBundle)

Purge the cache for individual Twig template files instead of removing the whole cache directory.

## Requirements

- PHP 8.2+
- Symfony 6.0/7.0/8.0
- Twig 2.x or 3.x

## Installation

```shell
composer require setono/twig-cache-purger-bundle
```

This will install the bundle and enable it if you're using Symfony Flex. If you're not using Flex, add the bundle
manually to `bundles.php`:

```php
Setono\TwigCachePurgerBundle\SetonoTwigCachePurgerBundle::class => ['all' => true],
```

## Usage

The bundle provides a `PurgerInterface` service that you can inject into your services to purge individual Twig
template cache files by their logical template name:

```php
use Setono\TwigCachePurgerBundle\Purger\PurgerInterface;

final class YourService
{
    public function __construct(private readonly PurgerInterface $purger)
    {
    }

    public function updateTemplate(): void
    {
        // Purge the cached compiled version of a specific template
        $this->purger->purge('emails/welcome.html.twig');
    }
}
```

The purger resolves the logical template name to its compiled cache file, invalidates the opcache/APC bytecode cache,
and deletes the file. The next time the template is rendered, Twig will recompile it from the source.

[ico-version]: https://poser.pugx.org/setono/twig-cache-purger-bundle/v/stable
[ico-license]: https://poser.pugx.org/setono/twig-cache-purger-bundle/license

[link-packagist]: https://packagist.org/packages/setono/twig-cache-purger-bundle
