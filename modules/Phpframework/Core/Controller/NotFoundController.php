<?php

declare(strict_types=1);

namespace Phpframework\Core\Controller;

use Phpframework\Core\AbstractController;
use Phpframework\Core\HtmlResponse;
use Phpframework\Core\LayoutHandler;
use Phpframework\Core\ResponseInterface;

class NotFoundController extends AbstractController
{
    /**
     * @param LayoutHandler $layoutHandler
     * @param HtmlResponse $response
     */
    public function __construct(
        LayoutHandler $layoutHandler,
        HtmlResponse $response
    ) {
        parent::__construct($layoutHandler);
        $this->response = $response;
    }

    /**
     * @param array $params
     * @return ResponseInterface
     * @throws \Exception
     */
    public function view(array $params): ResponseInterface
    {
        $this->layout = 'noroute';
        $html = $this->getHtml();
        return $this->response->setContent($html);
    }
}