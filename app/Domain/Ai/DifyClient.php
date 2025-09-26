<?php

namespace App\Domain\Ai;

class DifyClient
{
    private string $endpoint;
    private string $apiKey;
    private int $timeout;

    public function __construct()
    {
        $this->endpoint = config('dify.endpoint');
        $this->apiKey = config('dify.api_key');
        $this->timeout = config('dify.timeout');
    }

    public function runWorkflow(array $inputs): array
    {
        try {
            $client = new \GuzzleHttp\Client(['timeout' => $this->timeout]);
            
            $response = $client->post($this->endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'inputs' => $inputs,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            
            return $data['data'] ?? [];
        } catch (\Exception $e) {
            \Log::error('Dify API Error: ' . $e->getMessage());
            return [];
        }
    }
}
