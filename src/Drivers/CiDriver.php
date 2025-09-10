<?php
namespace NlpQuery\Drivers;

class CiDriver {
    protected $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function execute($sql) {
        return $this->db->query($sql)->result();
    }
}
