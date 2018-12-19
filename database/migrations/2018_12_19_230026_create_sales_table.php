<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->nullable();
            $table->unsignedInteger('customer_id')->nullable()->comment('Customer info when selected a customer.');
            $table->unsignedInteger('user_id')->nullable()->comment('Who sole this product.');
            $table->boolean('is_in_lack')->default(false);
            $table->integer('in_lack_amount')->nullable()->comment('Required when is in lack field is true.');
            $table->decimal('total', 20, 2)->nullable();
            $table->integer('tax')->nullable()->comment('If needed, can input number percentage of tax will be charged.');
            $table->integer('tax_amount')->nullable()->comment('Auto calculate if tax input.');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::create('sale_product', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sale_id')->nullable();
            $table->unsignedInteger('product_id')->nullable();
            $table->decimal('additional_price', 20, 2)->nullable()->comment('If price will be sale different from product.');
            $table->integer('qty')->nullable()->comment('Quantity of product when customer buy.');
            $table->decimal('discount', 20, 2)->nullable()->comment('Discount amount only to apply for this product.');
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');

            $table->foreign('sale_id')
                ->references('id')->on('sales')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_product');
        Schema::dropIfExists('sales');
    }
}
