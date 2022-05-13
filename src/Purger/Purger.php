<?php

declare(strict_types=1);

namespace Setono\TwigCachePurgerBundle\Purger;

use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;

final class Purger implements PurgerInterface
{
    private Environment $twig;

    private Filesystem $filesystem;

    public function __construct(Environment $twig, Filesystem $filesystem)
    {
        $this->twig = $twig;
        $this->filesystem = $filesystem;
    }

    public function purge(string $name): void
    {
        /** @psalm-suppress InternalMethod */
        $cls = new \ReflectionClass($this->twig->load($name)->unwrap());
        $filename = $cls->getFileName();
        if (false === $filename) {
            return;
        }

        // this bytecode invalidation has been taken from \Twig\Cache\FilesystemCache
        if (\function_exists('opcache_invalidate') && filter_var(ini_get('opcache.enable'), \FILTER_VALIDATE_BOOLEAN)) {
            @opcache_invalidate($filename, true);
        }

        $this->filesystem->remove($filename);
    }
}
