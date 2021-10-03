<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'translations', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('language_id')->unsigned()->nullable(false);
                $table->bigInteger('product_id')->unsigned()->nullable(false);
                $table->string('product_name_translation', 255)->nullable(false);
                $table->string('product_desc_translation', 255)->nullable(false);
                $table->string('product_category_translation', 255)->nullable(false);
                $table->float('product_price_translation')->nullable();
                $table->foreign('product_id')->references('id')->on('products');
                $table->foreign('language_id')->references('id')->on('languages');
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
        Schema::dropIfExists('translations');
    }
}
