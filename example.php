<?php

use Reddit\Reddit;
use Reddit\Subreddits;
use Reddit\Query\QueryInterface;

// This is the actual "bot" code that I used to fetch data from Reddit.
// Feel free to do your own thing here :).

$cross_submissions = [];
$reddit = new Reddit('username', 'password', 'client_id', 'client_secret');

foreach (Subreddits::all() as $subreddit) {
    foreach ($subreddit->getQueries() as $query) {
        if (!$submissions = $reddit->search('r/' . $subreddit->getId() . '/' . $query->getEndpoint(), $query->getQueryParams())) {
            continue;
        }

        // Filter submissions to make sure only screenshots and images are included.
        $query->filterSubmissions($submissions);
        if (empty($submissions)) {
            continue;
        }

        // Add submissions to array that need cross post.
        $cross_submissions = array_merge($cross_submissions, $submissions);
    }
}

if (!$cross_submissions) {
    return;
}

// Randomize the array.
shuffle($cross_submissions);

// Only post 5 screenshots at a time to avoid being banned.
$cross_submissions = array_slice($cross_submissions, 0, 5);

foreach ($cross_submissions as $submission) {
    try {
        $subreddit = $submission->getSubreddit();
        $title = 'Posted by u/' . $submission->getAuthor() . ' in r/' . $subreddit->getId();

        // Mark submission as cross posted.
        $cross_post = [
            'id' => $submission->getId(),
            'cross_post_id' => null,
            'title' => $title,
            'subreddit' => $subreddit->getId(),
            'permalink' => $submission->getPermalink(),
            'author' => $submission->getAuthor(),
            'submission_date' => $submission->getCreated() ? $submission->getCreated()
                ->format('Y-m-d H:i') : null,
            'post_type' => $submission->getPostHint(),
            'original_title' => $submission->getTitle(),
            'score' => $submission->getScore(),
            'comments' => $submission->getComments(),
            'image_uri' => $submission->getFirstOriginalImageUri(),
            'thumbnail_uri' => $submission->getFirstThumbnailUri(),
            'flair' => $subreddit->getFlairId(),
            'created' => date('Y-m-d H:i:s'),
            'moderation_status' => 0,
        ];

        // Left out the actual code that saves cross post to my database.

        // Do not overload API.
        sleep(10);
    } catch (\Exception $e) {

    }
}

// Update text of welcome post.
$text[] = 'Intro text';

$text[] = '| Subreddit | Search queries |';
$text[] = '|:-|:-:|';
foreach (Subreddits::all() as $subreddit) {
    $text[] = '| /r/' . $subreddit->getId() . ' | ' .
        implode(', ', array_map(function (QueryInterface $query) use ($subreddit) {
            return '[' . $query->getString() . '](' . $query->getRedditUISearchString($subreddit) . ')';
        }, $subreddit->getQueries())) . ' |';
}
$text = array_merge($text, ['Outro text']);
$reddit->editSubmission('submission-id', $text);