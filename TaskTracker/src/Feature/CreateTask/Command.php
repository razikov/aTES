<?php

namespace Razikov\AtesTaskTracker\Feature\CreateTask;

use Webmozart\Assert\Assert;

class Command
{
    private ?string $userId;
    private string $description;
    private string $title;
    private string $jira_id;

    public function __construct(
        string $description,
        string $title,
        string $jiraId,
        ?string $userId = null
    ) {
        $this->userId = $userId;
        Assert::notContains('[]', $title);
        $this->title = $title;
        $this->jira_id = $jiraId;
        $this->description = $description;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getJiraId(): string
    {
        return $this->jira_id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
