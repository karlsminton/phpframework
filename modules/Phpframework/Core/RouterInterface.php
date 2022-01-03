<?php

declare(strict_types=1);

namespace Phpframework\Core;

interface RouterInterface
{
    /**
     * @param string $route
     * @param string $controller
     * @param string $action
     * @param string $params
     * @return ResponseInterface|null
     */
    public function match(
        string $route,
        string $controller,
        string $action,
        string $params
    ): ?ResponseInterface;
}