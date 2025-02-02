<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('category_id');
            $table->string('title', 45);
            $table->string('code', 10);
            $table->string('short_description', 250)->nullable();
            $table->text('long_description')->nullable();
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('stock');
            $table->string('image_url', 250)->nullable();
            $table->decimal('avg_review', 3, 2)->nullable();

            // Define foreign key constraints
            /* $table->foreign('business_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('category_id')
                ->references('category_id')
                ->on('product_category')
                ->onDelete('cascade')
                ->onUpdate('cascade'); */
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_business_id_foreign');
            $table->dropForeign('products_category_id_foreign');
            $table->dropColumn(['business_id', 'category_id', 'title', 'code', 'short_description', 'long_description', 'price', 'stock', 'image_url', 'avg_review']);
        });
    }
}

