<?php
/**
 * User: Oscar Sanchez
 * Date: 7/3/21
 */

namespace App\Mail;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MailSender
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $templating;


    /**
     * @var string
     */
    private $fromName;

    /**
     * MailSender constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $templating
     * @param string $fromName
     */
    public function __construct(\Swift_Mailer $mailer, Environment $templating, string $fromName)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->fromName = $fromName;
    }

    /**
     * @param Message $message
     *
     * @return int
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function send(Message $message): int
    {
        $body = $this->templating->render($message->template(), $message->templateData());

        $subject = $message->subject();

        $message = $this->createMessage()
            ->setSubject($subject)
            ->setFrom($message->from(), $this->fromName)
            ->setTo($message->to())
            ->setCc($message->cc())
            ->setBcc($message->bcc())
            ->setReplyTo($message->replyTo())
            ->setBody($body, $message->contentType())
        ;

        return $this->mailer->send($message);
    }

    /**
     * @return \Swift_Message
     */
    private function createMessage(): \Swift_Message
    {
        return new \Swift_Message();
    }

}