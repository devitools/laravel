<?php

namespace Simples\Database;

use Closure;
use Illuminate\Support\Facades\Schema as Base;

/**
 * Class Schema
 *
 * @method static boolean hasTable(string $table)
 * @method static boolean hasColumn(string $table, string $column)
 *
 * @package Simples\Database
 */
class Schema extends Base
{
    /**
     * @param string $table
     * @param Closure $callback
     */
    public static function alter(string $table, Closure $callback)
    {
        parent::table($table, $callback);
    }
}
