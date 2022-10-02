<?php

namespace Razikov\AtesBilling\Service;

use Razikov\AtesBilling\Feature\CreateAccount\Command as CreateAccountCommand;
use Razikov\AtesBilling\Feature\Deposit\Command as DepositCommand;
use Razikov\AtesBilling\Feature\Charge\Command as ChargeCommand;
use Razikov\AtesBilling\Feature\Dummy\Command as DummyCommand;
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
                $message = new CreateAccountCommand(
                    $payload['id']
                );
                break;
            case 'TaskAssigned':
                if ($data['version'] != 1) {
                    throw new \DomainException("unsupported TaskAssignedEvent version [1]. Version={$data['version']}");
                }
                $payload = $data['payload'];
                $message = new ChargeCommand(
                    $payload['userId'],
                    $payload['taskId']
                );
                break;
            case 'TaskCompleted':
                if ($data['version'] != 1) {
                    throw new \DomainException("unsupported TaskCompletedEvent version [1]. Version={$data['version']}");
                }
                $payload = $data['payload'];
                $message = new DepositCommand(
                    $payload['userId'],
                    $payload['taskId']
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
        // this is called if a message is redelivered for "retry"
        $message = $envelope->getMessage();
        // expand this logic later if you handle more than
        // just one message class
        if (false) {
            // @todo
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
