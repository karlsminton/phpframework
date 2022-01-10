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
     * @param string $controller
     * @param string $action
     * @param string $params
     * @return ResponseInterface|void|null
     */
    public function match(
        string $route,
        string $controller,
        string $action,
        string $params = ''
    ) {
        /** @var RouterInterface $router */
        foreach ($this->pool as $router) {
            if ($response = $router->match($route, $controller, $action, $params)) {
                return $response;
            }
        }
    }

    /**
     * @param RouterInterface[] $routers
     */
    public function addRouter(array $routers)
    {
        $this->pool = array_merge($this->pool, $routers);
    }
}