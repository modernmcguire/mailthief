<?php

namespace ModernMcGuire\MailThief;

use Illuminate\Support\Carbon;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mime\MessageConverter;
use Symfony\Component\Mailer\Transport\AbstractTransport;

class MailThiefTransport extends AbstractTransport
{
    /**
     * {@inheritDoc}
     */
    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        MailThief::create([
            'from' => collect($email->getFrom())->map(fn($email) => ['email' => $email->getAddress(), 'name' => $email->getName()]),
            'to' => collect($email->getTo())->map(fn($email) => ['email' => $email->getAddress(), 'name' => $email->getName()]),
            'cc' => collect($email->getCc())->map(fn($email) => ['email' => $email->getAddress(), 'name' => $email->getName()]),
            'bcc' => collect($email->getBcc())->map(fn($email) => ['email' => $email->getAddress(), 'name' => $email->getName()]),
            'subject' => $email->getSubject(),
            'text' => $email->getTextBody(),
            'html' => $email->getHtmlBody(),
            'attachments' => collect($email->getAttachments())->map(function($attachment){
                return $attachment->asDebugString();
            }),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * Get the string representation of the transport.
     *
     * @return string
     */
    public function __toString(): string
    {
        return 'mailthief';
    }
}
