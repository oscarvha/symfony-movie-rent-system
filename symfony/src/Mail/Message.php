<?php
/**
 * User: Oscar Sanchez
 * Date: 7/3/21
 */

namespace App\Mail;

class Message
{
    /**
     * @var Header
     */
    private $header;

    /**
     * @var Body
     */
    private $body;

    /**
     * Message constructor.
     *
     * @param Header $header
     * @param Body $body
     */
    public function __construct(Header $header, Body $body)
    {
        $this->header = $header;
        $this->body = $body;
    }

    /**
     * @return Header
     */
    public function header(): Header
    {
        return $this->header;
    }

    /**
     * @return Body
     */
    public function body(): Body
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function subject(): string
    {
        return $this->header->subject();
    }

    /**
     * @return string
     */
    public function from(): string
    {
        return $this->header->from();
    }

    /**
     * @return string
     */
    public function to(): string
    {
        return $this->header->to();
    }

    /**
     * @return string
     */
    public function cc(): ?string
    {
        return $this->header->cc();
    }

    /**
     * @return string
     */
    public function bcc(): ?string
    {
        return $this->header->bcc();
    }

    /**
     * @return string
     */
    public function replyTo(): string
    {
        return $this->header->replyTo();
    }

    /**
     * @return string
     */
    public function template(): string
    {
        return $this->body->template();
    }

    /**
     * @return array
     */
    public function templateData(): array
    {
        return $this->body->data();
    }

    /**
     * @return string
     */
    public function contentType(): string
    {
        return $this->body->contentType();
    }

}