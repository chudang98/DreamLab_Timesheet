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
            $table->enum('morning_shift', ['M', 'V', 'X']);
            $table->enum('afternoon_shift', ['S', 'V', 'X']);
            $table->unsignedBigInteger('users_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timesheets');
    }
}
