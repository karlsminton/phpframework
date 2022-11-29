<?php

declare(strict_types=1);

namespace Phpframework\Core\View\Model;

use Phpframework\Core\NodeInterface;
use Phpframework\Pages\Model\PageRepository;

class Main implements NodeInterface
{
    /**
     * @param PageRepository $pageRepository
     */
    public function __construct(
        PageRepository $pageRepository
    ) {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        $page = $this->pageRepository->getPageById(1);
        $content = $page->getContent();
        return $content;
    }
}