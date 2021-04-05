<?php

namespace App\Mail;

class Body
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $contentType;

    /**
     * Body constructor.
     *
     * @param string $template
     * @param array  $data
     * @param string $contentType
     */
    public function __construct(string $template, array $data = [], string $contentType = 'text/html')
    {
        $this->template = $template;
        $this->data = $data;
        $this->contentType = $contentType;
    }

    public function template(): string
    {
        return $this->template;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function contentType(): string
    {
        return $this->contentType;
    }
}
