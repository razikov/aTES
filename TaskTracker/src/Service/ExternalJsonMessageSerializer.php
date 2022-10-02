<?php

namespace Razikov\AtesTaskTracker\Service;

use Razikov\AtesTaskTracker\Feature\AssignTasks\TaskAssignedEvent;
use Razikov\AtesTaskTracker\Feature\CompleteTask\TaskCompletedEvent;
use Razikov\AtesTaskTracker\Feature\CreateTask\TaskCreatedEvent;
use Razikov\AtesTaskTracker\Feature\CreateUser\Command as CreateUserCommand;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Stamp\SentStamp;
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
                $message = new CreateUserCommand(
                    $payload['id'],
                    $payload['role'],
                );
                break;
            case 'TaskAssigned':
                if ($data['version'] != 1) {
                    throw new \DomainException("unsupported TaskAssignedEvent version [1]. Version={$data['version']}");
                }
                $payload = $data['payload'];
                $message = new TaskAssignedEvent(
                    $payload['userId'],
                    $payload['taskId'],
                );
                break;
            case 'TaskCompleted':
                if ($data['version'] != 1) {
                    throw new \DomainException("unsupported TaskCompletedEvent version [1]. Version={$data['version']}");
                }
                $payload = $data['payload'];
                $message = new TaskCompletedEvent(
                    $payload['userId'],
                    $payload['taskId'],
                );
                break;
            case 'TaskCreated':
                if ($data['version'] != 1) {
                    throw new \DomainException("unsupported TaskCreatedEvent version [1]. Version={$data['version']}");
                }
                $payload = $data['payload'];
                $message = new TaskCreatedEvent(
                    $payload['id'],
                    $payload['description'],
                    $payload['responsibleId'],
                );
                break;
            default:
                $message = new \stdClass();
                break;
        }

        // in case of redelivery, unserialize any stamps
        $stamps = [];
        if (isset($headers['stamps'])) {
            $rawStamps = unserialize($headers['stamps']);
            $stamps = array_filter($rawStamps, function ($stamp) {
                return !($stamp instanceof SentStamp);
            });
        }

        return new Envelope($message, $stamps);
    }

    public function encode(Envelope $envelope): array
    {
        // this is called if a message is redelivered for "retry"
        $message = $envelope->getMessage();
        // expand this logic later if you handle more than
        // just one message class
        if ($message instanceof TaskAssignedEvent) {
            $data = [
                "event" => "TaskAssigned",
                "version" => 1,
                "payload" => [
                    "userId" => $message->userId,
                    "taskId" => $message->taskId,
                ],
            ];
        } elseif ($message instanceof TaskCompletedEvent) {
            $data = [
                "event" => "TaskCompleted",
                "version" => 1,
                "payload" => [
                    "userId" => $message->userId,
                    "taskId" => $message->taskId,
                ],
            ];
        } elseif ($message instanceof TaskCreatedEvent) {
            $data = [
                "event" => "TaskCreated",
                "version" => 1,
                "payload" => [
                    "id" => $message->id,
                    "description" => $message->description,
                    "responsibleId" => $message->responsibleId,
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
