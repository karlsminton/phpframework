<?php

declare(strict_types=1);

namespace Phpframework\Core;

use DI\Container;

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
     * @var Container|null
     */
    private $di = null;

    /**
     * @param RouterPool $routerPool
     */
    public function __construct(
        RouterPool $routerPool
    ) {
        $this->routerPool = $routerPool;
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function buildRouterPool()
    {
        if ($this->di) {
            $this->routerPool->addRouter([
                $this->di->get(\Phpframework\Pages\Router::class)
            ]);
        }
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
        list($route, $controller, $action, $params) = $this->getRouteControllerAction();
        $response = $this->routerPool->match($route, $controller, $action, $params);

        //todo just for testing
        $layoutHanlder = new LayoutHandler();
        $layoutHanlder->getCombinedLayoutByName('default');

        // todo swap for real response
        $response = new \Phpframework\Core\HtmlResponse('404 Not Found', 404);
        return $response;
    }

    /**
     * @param Container $di
     * @return $this
     */
    public function setDiContainer(Container $di)
    {
        $this->di = $di;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequestedUrl(): string
    {
        $protocol = $this->requestData['REQUEST_SCHEME'];
        $hostname = $this->requestData['HTTP_HOST'];
        $request = $this->requestData['REQUEST_URI'];

        return sprintf(
            '%1$s://%2$s%3$s',
            $protocol,
            $hostname,
            $request
        );
    }

    /**
     * @return string[]
     */
    public function getRouteControllerAction(): array
    {
        $parsed = parse_url($this->getRequestedUrl());
        if (!isset($parsed['path'])) {
            return ['', '', '', ''];
        }

        $parts = explode('/', trim($parsed['path'], '/'));

        if (isset($parsed['query'])) {
            array_push($parts, $parsed['query']);
        } else {
            array_push($parts, '');
        }

        return $parts;
    }
}