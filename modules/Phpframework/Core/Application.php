<?php

declare(strict_types=1);

namespace Phpframework\Core;

class Application
{
    /**
     * @var array
     */
    private $requestData;

    /**
     * @var RouterPool
     */
    private $routerPool;

    /**
     * init Application
     */
    public function __construct()
    {
        $routers = [
            new \Phpframework\Pages\Router()
        ];

        $routerPool = new RouterPool($routers);
        $this->routerPool = $routerPool;
    }

    /**
     * @param array $requestData
     * @return $this
     */
    public function setRequestData(array $requestData): self
    {
        $this->requestData = $requestData;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponse(): AbstractResponse
    {
        $route = $this->getRequestString();
        $router = $this->routerPool->match($route);
//        if ($router instanceof \Phpframework\Pages\Router) {
//            return "Page Router";
//        }
//        return "404";
        $response = new \Phpframework\Core\HtmlResponse('404 Not Found', 404);
        return $response;
    }

    /**
     * @return string
     */
    private function getRequestString(): string
    {
        return $this->requestData['REQUEST_URI'] ?? '';
    }
}