<?php
namespace NlpQuery\Drivers;

class FreeAiDriver implements AiDriverInterface {
    public function convert(string $query): ?string {
        // Very simple keyword parser
        if (preg_match('/users.*age > (\d+).*city = (\w+)/i', $query, $m)) {
            return "SELECT * FROM users WHERE age > {$m[1]} AND city = '{$m[2]}'";
        }
        if (preg_match('/count users/i', $query)) {
            return "SELECT COUNT(*) as total FROM users";
        }
        return null;
    }
}
