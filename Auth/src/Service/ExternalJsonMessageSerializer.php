<?php

namespace Razikov\AtesAuth\Service;

use Razikov\AtesAuth\Model\BaseEventCommand;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class ExternalJsonMessageSerializer implements SerializerInterface
{
    private $commandMap = [];

    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];

        $data = json_decode($body, true);

        $message = null;
        foreach ($this->commandMap as $commandClass) {
            /** @var BaseEventCommand $commandClass */
            $message = $commandClass::createFromMessage($data);
            if ($message instanceof BaseEventCommand) {
                break;
            }
        }

        if (!$message) {
            $message = new \stdClass();
        }

        $stamps = [];
        if (isset($headers['stamps'])) {
            $stamps = unserialize($headers['stamps']);
        }

        return new Envelope($message, $stamps);
    }
    public function encode(Envelope $envelope): array
    {
        $message = $envelope->getMessage();
        if ($message instanceof BaseEventCommand) {
            $data = $message->toMessage();
        } else {
            throw new \DomainException("Unexpected event");
        }

        $allStamps = [];
        foreach ($envelope->all() as $stamps) {
            $allStamps = array_merge($allStamps, $stamps);
        }

        return [
            'body' => json_encode($data),
            'headers' => [
                'stamps' => serialize($allStamps)
            ],
        ];
    }
}
