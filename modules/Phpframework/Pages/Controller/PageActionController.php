<?php

declare(strict_types=1);

namespace Phpframework\Pages\Controller;

use Phpframework\Core\AbstractController;
use Phpframework\Core\HtmlResponse;
use Phpframework\Core\ResponseInterface;

class PageActionController extends AbstractController
{
    /**
     * @param string $urlkey
     * @return ResponseInterface
     */
    public function view(string $urlkey): ResponseInterface
    {
        $this->layout = 'page_view';
        $html = $this->getHtml();
        return new HtmlResponse($html);
    }
}