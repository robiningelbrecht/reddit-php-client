<?php


namespace Reddit\Query;

use Reddit\Subreddit;

class NewestQuery implements QueryInterface
{

    public function getString(): ?string
    {
        return 'new';
    }

    public function getTime(): ?string
    {
        return QueryInterface::T_ALL;
    }

    public function getEndpoint(): string
    {
        return 'new.json';
    }

    public function getQueryParams(): array
    {
        return [
            'limit' => 100,
        ];
    }

    public function filterSubmissions(array &$submissions): void
    {
        // All submissions allowed.
    }

    public function getRedditUISearchString(Subreddit $subreddit): string
    {
        return '/r/' . $subreddit->getId() . '/new/';
    }

}