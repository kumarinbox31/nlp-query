<?php
namespace NlpQuery\Drivers;

use Illuminate\Support\Facades\DB;

class LaravelDriver {
    public function execute($sql) {
        return DB::select($sql);
    }
}
