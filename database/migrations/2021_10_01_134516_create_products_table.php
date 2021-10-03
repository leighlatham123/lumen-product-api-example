<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     * `product_id` int(11) NOT NULL,
     * `product_name` varchar(255) DEFAULT NULL,
     * `product_desc` text DEFAULT NULL,
     * `product_category` varchar(20) DEFAULT NULL,
     * `product_price` float DEFAULT NULL,
     */
    public function up()
    {
        Schema::create(
            'products', function (Blueprint $table) {
                $table->id()->nullable(false);
                $table->string('product_name', 255)->nullable();
                $table->text('product_desc')->nullable();
                $table->string('product_category', 20)->nullable();
                $table->float('product_price')->nullable();
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
        Schema::dropIfExists('products');
    }
}
