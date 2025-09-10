<?php
namespace NlpQuery\Drivers;

class HuggingFaceDriver implements AiDriverInterface {
    protected $apiKey;
    protected $model;

    public function __construct(string $apiKey, string $model = "defog/sqlcoder-7b-2") {
        $this->apiKey = $apiKey;
        $this->model = $model;
    }

    public function convert(string $query): ?string {
        $url = "https://api-inference.huggingface.co/models/{$this->model}";
        $data = ["inputs" => "Convert to SQL: $query"];

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
        return $json[0]['generated_text'] ?? null;
    }
}
