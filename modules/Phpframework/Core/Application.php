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
     * @return ResponseInterface
     * @throws \Exception
     */
    public function getResponse(): ResponseInterface
    {
        $route = $this->getRequestString();
        $router = $this->routerPool->match($route);

        //todo just for testing
        $layoutHanlder = new LayoutHandler();
        $layoutHanlder->getCombinedLayoutByName('default');

        // todo swap for real response
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