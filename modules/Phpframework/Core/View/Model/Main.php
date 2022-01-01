<?php

declare(strict_types=1);

namespace Phpframework\Core\View\Model;

use Phpframework\Core\NodeInterface;

class Main implements NodeInterface
{
    /**
     * @return string
     */
    public function getContent(): string
    {
        return 'This is where the main page content goes. Lorem ipsum sit dolor amet.';
    }
}