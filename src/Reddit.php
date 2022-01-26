<?php


namespace Reddit;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;

class Reddit
{

    protected string $username;
    protected string $password;
    protected string $clientId;
    protected string $clientSecret;

    private const ACCESS_TOKEN_URL = 'https://www.reddit.com/api/v1/access_token';
    private const API_BASE_URL = 'https://oauth.reddit.com';

    protected ClientInterface $client;
    protected string $token;

    public function __construct(string $username, string $password, string $client_id, string $client_secret)
    {
        $this->username = $username;
        $this->password = $password;
        $this->clientId = $client_id;
        $this->clientSecret = $client_secret;

        $this->client = new Client(['base_uri' => self::API_BASE_URL]);
    }

    public function getSubmissions(array $ids): array
    {
        $json = $this->request('GET', '/api/info', [RequestOptions::QUERY => ['id' => implode(',', $ids)]]);

        if (empty($json['data']['children'])) {
            return [];
        }

        $submissions = [];
        foreach ($json['data']['children'] as $submission) {
            if (!$s = Submission::createFromJson($submission)) {
                continue;
            }

            $submissions[] = $s;
        }

        return $submissions;
    }

    public function search(string $path, array $query_params = []): array
    {
        $json = $this->request('GET', $path, [RequestOptions::QUERY => $query_params]);

        if (empty($json['data']['children'])) {
            return [];
        }

        $submissions = [];
        foreach ($json['data']['children'] as $submission) {
            if (!$s = Submission::createFromJson($submission)) {
                continue;
            }
            $submissions[] = $s;
        }

        return $submissions;
    }

    public function crossPost(string $to_subreddit, string $title, string $submission_id, string $flair_id = null): array
    {
        $payload = [
            RequestOptions::FORM_PARAMS => [
                'api_type' => 'json',
                'sr' => $to_subreddit,
                'title' => $title,
                'kind' => 'crosspost',
                'crosspost_fullname' => $submission_id,
                'flair_id' => $flair_id,
            ],
        ];
        return $this->request('POST', 'api/submit', $payload);
    }

    public function moderateApprove(array $ids): array
    {
        $payload = [
            RequestOptions::QUERY => ['raw_json' => 1, 'gilding_detail' => 1],
            RequestOptions::JSON => ['ids' => $ids],
        ];
        return $this->request('POST', 'api/v1/modactions/approve', $payload);
    }

    public function moderateRemove(array $ids): array
    {
        $payload = [
            RequestOptions::QUERY => ['raw_json' => 1, 'gilding_detail' => 1],
            RequestOptions::JSON => ['ids' => $ids],
        ];
        return $this->request('POST', 'api/v1/modactions/remove', $payload);
    }

    public function editSubmission($submission_id, array $text): array
    {
        $payload = [
            RequestOptions::FORM_PARAMS => [
                'api_type' => 'json',
                'text' => join("\n", $text),
                'thing_id' => $submission_id,
            ],
        ];
        return $this->request('POST', '/api/editusertext', $payload);
    }

    protected function request($method, $path, $options = []): array
    {
        if (!isset($this->token)) {
            $client = new Client();
            $response = $client->post(self::ACCESS_TOKEN_URL, [
                RequestOptions::AUTH => [
                    $this->clientId,
                    $this->clientSecret,
                ],
                RequestOptions::FORM_PARAMS => [
                    'grant_type' => 'password',
                    'username' => $this->username,
                    'password' => $this->password,
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Authentication failed');
            }

            if (!$json = json_decode($response->getBody()->getContents(), true)) {
                throw new \Exception('Authentication failed');
            }

            if (empty($json['access_token'])) {
                throw new \Exception('Authentication failed');
            }

            $this->token = $json['access_token'];
        }

        $options[RequestOptions::HEADERS]['Authorization'] = 'Bearer ' . $this->token;
        $options[RequestOptions::HEADERS]['User-Agent'] = 'php.GamePhotoModePorn:v1.0 (by /u/GamePhotoModePorn2)';
        try {
            $response = $this->client->request($method, $path, $options);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return [];
        }
    }
}