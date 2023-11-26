<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('store_house_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('storehouse_id')->comment('ID склада');
            $table->unsignedBigInteger('product_id')->comment('ID продукта');
            $table->integer('quantity')->comment('Количество товара на складе');
            $table->integer('reserved_quantity')->default(0)
                ->comment('Количество зарезервированного товара');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('store_house_products');
    }
};
