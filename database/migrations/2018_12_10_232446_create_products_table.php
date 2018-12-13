<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('make_id')->nullable();
            $table->unsignedInteger('model_id')->nullable();
            $table->unsignedInteger('supplier_id')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->decimal('price', 20, 2)->default(0)->comment('Price is the amount a customer is willing to pay for a product or service.');
            $table->decimal('cost', 20, 2)->default(0)->comment('Cost is typically the expense incurred for a product or service being sold by a company.');
            $table->integer('qty')->default(0);
            $table->integer('year')->nullable()->comment('To track product year');
            $table->string('import_from')->nullable();
            $table->date('date_import')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('make_id')
                ->references('id')->on('makes')
                ->onDelete('cascade');

            $table->foreign('model_id')
                ->references('id')->on('models')
                ->onDelete('cascade');

            $table->foreign('supplier_id')
                ->references('id')->on('suppliers')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');
        });

        Schema::create('product_color', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('color_id')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('plate_number')->default(null)->comment('If motorbike is second hand');
            $table->string('frame_number')->default(null);
            $table->string('status')->default('new')->comment('Is new or second hand');
            $table->string('code')->default(null);
            $table->dateTime('sole_on')->nullable();
            $table->integer('qty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_color');
    }
}
