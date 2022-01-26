<?php

namespace Reddit;

use Carbon\Carbon;

class Submission
{

    protected string $id;
    protected string $title;
    protected string $author;
    protected string $permalink;
    protected Subreddit $subreddit;
    protected string $created;
    protected int $score;
    protected int $comments;
    protected string $postHint;
    protected array $data;

    public function __construct(string $id, string $title, string $author, string $permalink, Subreddit $subreddit, string $created, int $score, int $comments, $post_hint = null, array $data = [])
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->permalink = $permalink;
        $this->subreddit = $subreddit;
        $this->created = $created;
        $this->score = $score;
        $this->comments = $comments;
        $this->postHint = $post_hint;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getPermalink(): string
    {
        return $this->permalink;
    }

    public function getSubreddit(): Subreddit
    {
        return $this->subreddit;
    }

    public function getCreated(): Carbon
    {
        return Carbon::createFromTimestamp($this->created);
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getComments(): int
    {
        return $this->comments;
    }

    public function getPostHint(): string
    {
        return $this->postHint;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getFirstOriginalImageUri(): ?string
    {
        $data = $this->getData();

        if (isset($data['domain']) && $data['domain'] == 'postimg.cc') {
            // Image is hosted elsewhere.
            return null;
        }

        if (isset($data['media']['oembed']['thumbnail_url'])) {
            // Probably an embed like imgur.com
            return $data['media']['oembed']['thumbnail_url'];
        }

        if (isset($data['media_metadata'])) {
            // Probably post with multiple images.
            $metadata = reset($data['media_metadata']);
            if (isset($metadata['s']['u'])) {
                return $metadata['s']['u'];
            }
        }

        if (isset($data['preview']['images'])) {
            // Probably post with one image.
            $image = reset($data['preview']['images']);
            if (isset($image['source']['url'])) {
                return $image['source']['url'];
            }
        }

        // Submission has no images...
        return null;
    }

    public function getFirstThumbnailUri(): ?string
    {
        $data = $this->getData();

        if (isset($data['media']['oembed']['thumbnail_url'])) {
            // Probably an embed like imgur.com
            return $data['media']['oembed']['thumbnail_url'];
        }

        if (isset($data['media_metadata'])) {
            // Probably post with multiple images.
            $metadata = reset($data['media_metadata']);
            if (empty($metadata['p'])) {
                // Submission has no thumbnails.
                return null;
            }

            foreach ($metadata['p'] as $p) {
                if (empty($p['x']) || $p['x'] < 400) {
                    // We need a thumbnail with a width of at least 400px.
                    continue;
                }

                return $p['u'];
            }
        }

        if (isset($data['preview']['images'])) {
            // Probably post with one image.
            $image = reset($data['preview']['images']);
            if (empty($image['resolutions'])) {
                // Submission has no thumbnails.
                return null;
            }

            foreach ($image['resolutions'] as $resolution) {
                if (empty($resolution['width']) || $resolution['width'] < 400) {
                    // We need a thumbnail with a width of at least 400px.
                    continue;
                }

                return $resolution['url'];
            }
        }

        // Submission has no thumbnail...
        return null;
    }

    public static function createFromJson(array $json): ?self
    {
        if (!$subreddit = Subreddits::get($json['data']['subreddit'])) {
            return null;
        }

        return new static(
            $json['data']['name'],
            $json['data']['title'],
            $json['data']['author'],
            $json['data']['permalink'],
            $subreddit,
            $json['data']['created'],
            $json['data']['score'],
            $json['data']['num_comments'],
            $json['data']['post_hint'] ?? null,
            $json['data']
        );
    }

}