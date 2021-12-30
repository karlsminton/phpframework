<?php

declare(strict_types=1);

namespace Phpframework\Core;

class NotFoundRouter implements RouterInterface
{
    /**
     * @param string $route
     * @return bool
     */
    public function match(string $route): bool
    {
        return true;
    }
}