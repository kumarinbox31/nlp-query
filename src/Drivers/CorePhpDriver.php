<?php
namespace NlpQuery\Drivers;

class CorePhpDriver {
    protected $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function execute($sql) {
        return $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }
}