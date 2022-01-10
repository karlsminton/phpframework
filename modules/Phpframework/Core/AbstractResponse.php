<?php

declare(strict_types=1);

namespace Phpframework\Core;

abstract class AbstractResponse implements ResponseInterface
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var int
     */
    protected $responseCode;

    /**
     * @param string $content
     * @param int $responseCode
     */
    public function __construct(
        string $content = '',
        int $responseCode = 200
    ) {
        $this->content = $content;
        $this->responseCode = $responseCode;
        $this->initialise();
    }

    /**
     * init
     */
    private function initialise()
    {
        http_response_code($this->responseCode);
    }

    /**
     * All response objects should implement this so controllers can just render the response
     * @return string
     */
    abstract public function __toString(): string;
}