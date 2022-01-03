<?php

declare(strict_types=1);

namespace Phpframework\Pages;

use phpDocumentor\Reflection\Utils;
use Phpframework\Core\AbstractController;
use Phpframework\Core\ResponseInterface;
use Phpframework\Core\RouterInterface;
use Phpframework\Pages\Controller\PageActionController;

class Router implements RouterInterface
{
    const ROUTE = 'page';

    /**
     * @var PageActionController
     */
    private $pageActionController;

    /**
     * @param Controller\PageActionController $pageActionController
     */
    public function __construct(
        PageActionController $pageActionController
    ) {
        $this->pageActionController = $pageActionController;
    }

    /**
     * @param string $route
     * @param string $controller
     * @param string $action
     * @param string $params
     * @return AbstractController|null
     */
    public function match(
        string $route,
        string $controller,
        string $action,
        string $params = ''
    ): ?ResponseInterface {
        if (!$route === self::ROUTE) {
            return null;
        }

        switch ($controller) {
            case PageActionController::CONTROLLER:
                return $this->executeAction(
                    $this->pageActionController,
                    $action,
                    $params
                );

        }
    }

    /**
     * @param AbstractController $controller
     * @param string $action
     * @param string $params
     * @return ResponseInterface|null
     */
    protected function executeAction(
        AbstractController $controller,
        string $action,
        string $params
    ): ?ResponseInterface {
        if (method_exists($controller, $action)) {
            return $controller->{$action}($params);
        }
        return null;
    }
}