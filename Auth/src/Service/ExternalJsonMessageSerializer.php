<?php

namespace Razikov\AtesAuth\Service;

use Razikov\AtesAuth\Feature\CreateUser\UserCreatedEvent;
use Razikov\AtesAuth\Feature\Dummy\Command as DummyCommand;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class ExternalJsonMessageSerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];

        $data = json_decode($body, true);
        switch ($data['event']) {
            case 'UserCreated':
                if ($data['version'] != 1) {
                    throw new \DomainException("unsupported UserCreatedEvent version [1]. Version={$data['version']}");
                }
                $payload = $data['payload'];
                $message = new UserCreatedEvent(
                    $payload['id'],
                    $payload['role'],
                );
                break;
            default:
                $message = new DummyCommand();
                break;
        }

        // in case of redelivery, unserialize any stamps
        $stamps = [];
        if (isset($headers['stamps'])) {
            $stamps = unserialize($headers['stamps']);
        }
        return new Envelope($message, $stamps);
    }
    public function encode(Envelope $envelope): array
    {
//        throw new \Exception('Transport & serializer not meant for sending messages');

        // this is called if a message is redelivered for "retry"
        $message = $envelope->getMessage();
        // expand this logic later if you handle more than
        // just one message class
        if ($message instanceof UserCreatedEvent) {
            // recreate what the data originally looked like
            $data = [
                "event" => "UserCreated",
                "version" => 1,
                "payload" => [
                    "id" => $message->getId(),
                    "role" => $message->getRole(),
                ],
            ];
        } else {
            throw new \Exception('Unsupported message class');
        }

        $allStamps = [];
        foreach ($envelope->all() as $stamps) {
            $allStamps = array_merge($allStamps, $stamps);
        }

        return [
            'body' => json_encode($data),
            'headers' => [
                // store stamps as a header - to be read in decode()
                'stamps' => serialize($allStamps)
            ],
        ];
    }
}
