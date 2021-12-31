<?php

declare(strict_types=1);

namespace Phpframework\Core;

abstract class AbstractController
{
    /**
     * @var string
     */
    protected $layout = 'default';

    /**
     * @return string
     */
    protected function getHtml(): string
    {
        $layoutHandler = new LayoutHandler();
        $layoutHandler->getCombinedLayoutByName($this->layout);
        return '';
    }
}