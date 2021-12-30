<?php

declare(strict_types=1);

namespace Phpframework\Core;

class RouterPool
{
    /**
     * @var array
     */
    private $pool;

    /**
     * @param RouterInterface[] $pool
     */
    public function __construct(
        array $pool = []
    ) {
        $this->pool = $pool;
    }

    /**
     * @param string $route
     * @return RouterInterface
     */
    public function match(string $route)
    {
        /** @var RouterInterface $router */
        foreach ($this->pool as $router) {
            if ($router->match($route)) {
                return $router;
            }
        }
    }
}