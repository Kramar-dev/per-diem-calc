<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

abstract class Country
{
    public static function getCodes(): array
    {
        return DB::table('countries')->pluck('country')->toArray();
    }
}
