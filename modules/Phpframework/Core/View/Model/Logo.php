<?php

declare(strict_types=1);

namespace Phpframework\Core\View\Model;

use Phpframework\Core\NodeInterface;

class Logo implements NodeInterface
{
    /**
     * @return string
     */
    public function getText(): string
    {
        return 'A test string to show this node is working.';
    }
}