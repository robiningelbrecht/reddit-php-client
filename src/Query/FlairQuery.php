<?php


namespace Reddit\Query;

use Reddit\Subreddit;

class FlairQuery implements QueryInterface
{

    protected string $string;
    protected string $time;

    public function __construct(string $string, string $time = QueryInterface::T_DAY)
    {
        $this->string = $string;
        $this->time = $time;
    }

    public function getString(): string
    {
        return 'flair:"' . $this->string . '"';
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function getEndpoint(): string
    {
        return 'search.json';
    }

    public function getQueryParams(): array
    {
        return [
            'q' => $this->getString(),
            'restrict_sr' => 1,
            'limit' => 100,
            't' => $this->getTime(),
            'sort' => 'new',
        ];
    }

    public function filterSubmissions(array &$submissions): void
    {
        // All submissions allowed.
    }

    public function getRedditUISearchString(Subreddit $subreddit): string
    {
        return '/r/' . $subreddit->getId() . '/new/?' . http_build_query([
                'f' => 'flair_name:"' . $this->string . '"',
            ]);
    }

}