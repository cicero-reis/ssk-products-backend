<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    public function up()
    {
        Capsule::schema()->create('product', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->double('price', 10, 2);
            $table->integer('quantity');
            $table->string('image')->nullable();
            $table->integer('category_id');
            $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(Capsule::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('product');
    }
}
