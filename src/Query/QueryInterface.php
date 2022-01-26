<?php

namespace Reddit\Query;

use Reddit\Subreddit;

interface QueryInterface
{

    const T_HOUR = 'hour';
    const T_DAY = 'day';
    const T_WEEK = 'week';
    const T_MONTH = 'month';
    const T_YEAR = 'year';
    const T_ALL = 'all';

    public function getString(): ?string;

    public function getTime(): ?string;

    public function getEndpoint(): string;

    public function getQueryParams(): array;

    public function filterSubmissions(array &$submissions): void;

    public function getRedditUISearchString(Subreddit $subreddit): string;

}