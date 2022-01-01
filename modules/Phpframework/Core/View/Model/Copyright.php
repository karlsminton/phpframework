<?php

declare(strict_types=1);

namespace Phpframework\Core\View\Model;

use Phpframework\Core\NodeInterface;

class Copyright implements NodeInterface
{
    /**
     * @return string
     */
    public function getCopyrightText(): string
    {
        return sprintf(
            'Copyright© %s www.phpframework.com All rights reserved.',
            date('Y')
        );
    }
}