<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_property_type')->constrained('property_type');
            $table->foreignId('id_property_category')->nullable()->constrained('property_category');
            $table->foreignId('id_property_transaction_type')->nullable()->constrained('property_transaction_type');
            $table->foreignId('id_kitchen')->nullable()->constrained('kitchen');
            $table->foreignId('id_heater')->nullable()->constrained('heater');
            $table->foreignId('id_energy_audit')->nullable()->constrained('energy_audit');
            $table->string('name');
            $table->integer('price');
            $table->string('address');
            $table->string('addition_address');
            $table->integer('zipcode');
            $table->string('city');
            $table->integer('surface');
            $table->text('description');
            $table->boolean('is_furnished');
            $table->boolean('is_available');
            $table->boolean('is_prospect')->default('1');;
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
        Schema::dropIfExists('property');
    }
}
