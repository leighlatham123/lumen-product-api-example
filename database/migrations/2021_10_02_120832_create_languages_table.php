<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'languages', function (Blueprint $table) {
                $table->id()->nullable(false);
                $table->string('locale', 20)->nullable(false);
                $table->string('name', 255)->nullable(false);
                $table->string('date_format', 255)->nullable(false);
                $table->string('currency', 255)->nullable(false);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
