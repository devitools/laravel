<?php

declare(strict_types=1);

namespace App\Database\Migration;

use App\Database\Migration;
use App\Database\Schema;
use App\Database\Table;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class TableAlter
 * @package App\Database\Migration
 */
abstract class TableAlter extends Migration
{
    /**
     * @return string
     */
    abstract protected function table(): string;

    /**
     * @param Table $table
     * @return void
     */
    abstract protected function onUp(Table $table);

    /**
     * @param Table $table
     * @return void
     */
    abstract protected function onDown(Table $table);

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::alter($this->table(), function (Blueprint $blueprint) {
            $this->onUp(Table::make($blueprint));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::alter($this->table(), function (Blueprint $blueprint) {
            $this->onDown(Table::make($blueprint));
        });
    }
}
