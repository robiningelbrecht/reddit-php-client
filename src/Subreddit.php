<?php


namespace Reddit;

class Subreddit
{

    protected string $id;
    protected array $queries;
    protected string $flairId;

    public function __construct(string $id, array $queries, string $flair_id)
    {
        $this->id = $id;
        $this->queries = $queries;
        $this->flairId = $flair_id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getQueries(): array
    {
        return $this->queries;
    }

    public function getFlairId(): string
    {
        return $this->flairId;
    }

}