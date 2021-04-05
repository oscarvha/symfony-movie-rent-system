<?php

namespace App\Mail;

class Header
{
    /**
     * @var string
     */
    private $to;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $cc;

    /**
     * @var string
     */
    private $bcc;

    /**
     * @var string
     */
    private $replyTo;

    /**
     * Header constructor.
     *
     * @param string      $to
     * @param string      $from
     * @param string      $subject
     * @param string|null $cc
     * @param string|null $bcc
     * @param string|null $replyTo
     */
    public function __construct(string $to, string $from, string $subject, string $cc = null, string $bcc = null, string $replyTo = null)
    {
        $this->to = $to;
        $this->from = $from;
        $this->subject = $subject;
        $this->cc = $cc;
        $this->bcc = $bcc;
        $this->replyTo = (empty($replyTo)) ? $from : $replyTo;
    }

    /**
     * @return string
     */
    public function to(): string
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function from(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function subject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function cc(): ?string
    {
        return $this->cc;
    }

    /**
     * @return string
     */
    public function bcc(): ?string
    {
        return $this->bcc;
    }

    /**
     * @return string
     */
    public function replyTo(): string
    {
        return $this->replyTo;
    }

    /**
     * @param string $cc
     */
    public function setCc(string $cc): void
    {
        $this->cc = $cc;
    }

    /**
     * @param string $bcc
     */
    public function setBcc(string $bcc): void
    {
        $this->bcc = $bcc;
    }

    /**
     * @param string $replyTo
     */
    public function setReplyTo(string $replyTo): void
    {
        $this->replyTo = $replyTo;
    }
}
