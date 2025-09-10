<?php
namespace NlpQuery;

use NlpQuery\Drivers\AiDriverInterface;

class QueryEngine {
    protected $driver;
    protected $aiDriver;

    public function __construct($driver, AiDriverInterface $aiDriver = null) {
        $this->driver = $driver;
        $this->aiDriver = $aiDriver;
    }

    public function ask(string $query) {
        // Step 1: Use AI (if available) else fallback
        $sql = $this->aiDriver ? $this->aiDriver->convert($query) : $this->convertToSql($query);

        if (!$sql) {
            throw new \Exception("Could not convert query: $query");
        }

        // Step 2: Run SQL
        return $this->driver->execute($sql);
    }

    private function convertToSql(string $query): ?string {
        // Built-in fallback
        if (preg_match('/users.*age > (\d+).*city = (\w+)/i', $query, $m)) {
            return "SELECT * FROM users WHERE age > {$m[1]} AND city = '{$m[2]}'";
        }
        return null;
    }
}
