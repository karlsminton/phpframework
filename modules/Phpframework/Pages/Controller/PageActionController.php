<?php

declare(strict_types=1);

namespace Phpframework\Pages\Controller;

use Phpframework\Core\AbstractController;
use Phpframework\Core\HtmlResponse;
use Phpframework\Core\LayoutHandler;
use Phpframework\Core\ResponseInterface;

class PageActionController extends AbstractController
{
    const CONTROLLER = 'something';

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
     * @param string $params
     * @return ResponseInterface
     * @throws \Exception
     */
    public function view(string $params): ResponseInterface
    {
        $this->layout = 'default';
        $html = $this->getHtml();
        return $this->response->setContent($html);
    }
}