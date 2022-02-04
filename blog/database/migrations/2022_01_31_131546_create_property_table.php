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
            $table->foreignId('id_property_type')->nullable()->constrained('property_type');
            $table->foreignId('id_kitchen')->nullable()->constrained('kitchen');
            $table->foreignId('id_heater')->nullable()->constrained('heater');
            $table->foreignId('id_energy_audit')->nullable()->constrained('energy_audit');
            $table->string('name');
            $table->integer('price');
            $table->integer('number');
            $table->string('address');
            $table->string('addition_address');
            $table->integer('zipcode');
            $table->text('description');
            $table->integer('surface');
            $table->string('floor');
            $table->boolean('is_furnished');
            $table->boolean('is_available');
            $table->boolean('is_prospect');
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
