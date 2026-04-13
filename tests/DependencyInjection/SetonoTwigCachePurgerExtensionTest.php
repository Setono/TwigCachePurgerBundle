<?php

declare(strict_types=1);

namespace Setono\TwigCachePurgerBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Setono\TwigCachePurgerBundle\DependencyInjection\SetonoTwigCachePurgerExtension;
use Setono\TwigCachePurgerBundle\Purger\PurgerInterface;

#[CoversClass(SetonoTwigCachePurgerExtension::class)]
final class SetonoTwigCachePurgerExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new SetonoTwigCachePurgerExtension(),
        ];
    }

    #[Test]
    public function it_registers_services(): void
    {
        $this->load();

        // purger.xml
        $this->assertContainerBuilderHasService('setono_twig_cache_purger.purger.default');
        $this->assertContainerBuilderHasAlias(PurgerInterface::class, 'setono_twig_cache_purger.purger.default');
    }
}
