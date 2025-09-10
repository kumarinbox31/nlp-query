<?php
namespace NlpQuery\Drivers;

interface AiDriverInterface {
    public function convert(string $query): ?string;
}
