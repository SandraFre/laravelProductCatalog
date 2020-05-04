<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('title');
            $table->string('slug')->unique();
            $table->boolean('active')->default(false);
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->bigInteger('category_id')->unsigned();

            $table->unique(['product_id', 'category_id']);

            $table->foreign('product_id')
            ->references('id')
            ->on('products')
            ->onUpdate('CASCADE')
            ->onDelete('CASCADE');

            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onUpdate('CASCADE')
            ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('categories');
    }
}
