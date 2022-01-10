<?php

declare(strict_types=1);

namespace Phpframework\Core;

class HtmlResponse extends AbstractResponse
{
    /**
     * @param string $content
     * @param int $responseCode
     */
    public function __construct(
        string $content = '',
        int $responseCode = 200
    ) {
        parent::__construct(
            $content,
            $responseCode
        );
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    public function executeAction()
    {
        // TODO: Implement executeAction() method.
    }
}