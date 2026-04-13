<?php

declare(strict_types=1);

namespace Setono\TwigCachePurgerBundle\Tests\Purger;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Setono\TwigCachePurgerBundle\Purger\Purger;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Cache\FilesystemCache;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

#[CoversClass(Purger::class)]
final class PurgerTest extends TestCase
{
    #[Test]
    public function it_purges(): void
    {
        $templateName = 'template.html.twig';

        $loader = new FilesystemLoader([__DIR__ . '/templates']);
        $cache = new FilesystemCache(__DIR__ . '/templates/cache');
        $twig = new Environment($loader, ['cache' => $cache]);

        $cachedTemplateFile = (new \ReflectionClass($twig->load($templateName)->unwrap()))->getFileName();
        self::assertIsString($cachedTemplateFile);

        self::assertFileExists($cachedTemplateFile);
        self::assertSame('hej', trim($twig->render($templateName)));

        $purger = new Purger($twig, new Filesystem());
        $purger->purge($templateName);

        self::assertFileDoesNotExist($cachedTemplateFile);
    }
}
