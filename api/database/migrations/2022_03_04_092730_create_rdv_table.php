<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRdvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rdv', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_employee')->constrained('employee');
            $table->foreignId('id_property')->nullable()->constrained('property');
            $table->foreignId('id_client')->nullable()->constrained('client')->onDelete('cascade');
            $table->foreignId('id_label')->constrained('label');
            $table->foreignId('id_agency')->constrained('agency');
            $table->dateTime('beginning');
            $table->dateTime('end');
            $table->text('description')->nullable();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('mail')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_visit');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->integer('zipcode')->nullable();
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
        Schema::dropIfExists('rdv');
    }
}
