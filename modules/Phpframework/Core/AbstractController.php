<?php

declare(strict_types=1);

namespace Phpframework\Core;

abstract class AbstractController
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var string
     */
    protected $layout = 'default';

    /**
     * @var LayoutHandler
     */
    private $layoutHandler;

    /**
     * @param LayoutHandler $layoutHandler
     */
    public function __construct(
        LayoutHandler $layoutHandler
    ) {
        $this->layoutHandler = $layoutHandler;
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function getHtml(): string
    {
        $layoutHandler = new LayoutHandler();
        $layoutHandler->getCombinedLayoutByName($this->layout);
        return '';
    }
}