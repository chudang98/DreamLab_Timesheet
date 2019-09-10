<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');

            /*
                M : đi làm muộn.
                V : vắng cả buổi
                S : về sớm
                X : buổi đó đi làm đầy đủ
            */
            $table->enum('morning_shift', ['M', 'V', 'X'])->default('V');
            $table->enum('afternoon_shift', ['S', 'V', 'X', 'M'])->default('V');
            $table->unsignedBigInteger('user_id');
            $table->unique(['date', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('timesheets');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
