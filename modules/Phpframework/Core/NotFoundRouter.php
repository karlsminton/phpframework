<?php

declare(strict_types=1);

namespace Phpframework\Core;

use Phpframework\Core\Controller\NotFoundController;

class NotFoundRouter implements RouterInterface
{
    const ROUTE = 'noroute';

    /**
     * @var NotFoundController
     */
    private $notFoundController;

    /**
     * @param NotFoundController $notFoundController
     */
    public function __construct(
        NotFoundController $notFoundController
    ) {
        $this->notFoundController = $notFoundController;
    }

    /**
     * @param string $route
     * @param string $controller
     * @param string $action
     * @param string $params
     * @return ResponseInterface|null
     * @throws \Exception
     */
    public function match(
        string $route,
        string $controller,
        string $action,
        string $params
    ): ?ResponseInterface {
        return $this->notFoundController->view([]);
    }
}