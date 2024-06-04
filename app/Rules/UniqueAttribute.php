<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueAttribute implements Rule
{
    private $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function passes($attribute, $value)
    {
        $query = DB::table($this->table)
            ->where($attribute, $value);

        return !$query->exists();
    }

    public function message()
    {
        return 'The :attribute must be unique';
    }
}
