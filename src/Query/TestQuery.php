<?php


namespace Reddit\Query;

use Reddit\Subreddit;

class TestQuery implements QueryInterface
{

    protected $query;

    public function __construct(QueryInterface $query)
    {
        $this->query = $query;
    }

    public function getString(): ?string
    {
        return $this->query->getString();
    }

    public function getTime(): ?string
    {
        return $this->query->getTime();
    }

    public function getEndpoint(): string
    {
        return $this->query->getEndpoint();
    }

    public function getQueryParams(): array
    {
        $params = $this->query->getQueryParams();

        // Make sure test query does not limit time.
        if (isset($params['t'])) {
            unset($params['t']);
        }

        return $params;
    }

    public function filterSubmissions(array &$submissions): void
    {
        $this->query->filterSubmissions($submissions);
        // Make sure only one result is returned for testing purposes.
        if (!empty($submissions)) {
            $submissions = [reset($submissions)];
        }
    }

    public function getRedditUISearchString(Subreddit $subreddit): string
    {
        return $this->query->getRedditUISearchString($subreddit);
    }

}