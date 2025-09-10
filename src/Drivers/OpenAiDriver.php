<?php
namespace NlpQuery\Drivers;

class OpenAiDriver implements AiDriverInterface {
    protected $apiKey;
    public function __construct(string $apiKey) {
        $this->apiKey = $apiKey;
    }

    public function convert(string $query): ?string {
        $url = "https://api.openai.com/v1/chat/completions";

        $data = [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                ["role" => "system", "content" => "Convert natural language queries into SQL"],
                ["role" => "user", "content" => $query]
            ],
            "max_tokens" => 150
        ];

        $options = [
            "http" => [
                "header"  => "Authorization: Bearer {$this->apiKey}\r\nContent-Type: application/json\r\n",
                "method"  => "POST",
                "content" => json_encode($data),
                "timeout" => 30
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            return null;
        }

        $json = json_decode($response, true);
        return $json['choices'][0]['message']['content'] ?? null;
    }
}
