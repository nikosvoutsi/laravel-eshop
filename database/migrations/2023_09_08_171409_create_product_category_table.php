<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('product_category', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->string('title', 45);
            $table->primary('category_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_category');
    }
}
