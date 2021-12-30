<?php

declare(strict_types=1);

namespace Phpframework\Pages;

use Phpframework\Core\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @param string $route
     * @return bool
     */
    public function match(string $route): bool
    {
        return strpos($route, 'page') !== false;
    }
}