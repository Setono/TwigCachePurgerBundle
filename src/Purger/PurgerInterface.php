<?php

declare(strict_types=1);

namespace Setono\TwigCachePurgerBundle\Purger;

interface PurgerInterface
{
    /**
     * @param string $name the logical template name
     */
    public function purge(string $name): void;
}
