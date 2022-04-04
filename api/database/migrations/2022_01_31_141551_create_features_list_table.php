<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturesListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features_list', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_hygiene')->nullable()->constrained('hygiene');
            $table->foreignId('id_outdoor')->nullable()->constrained('outdoor');
            $table->foreignId('id_property')->constrained('property');
            $table->foreignId('id_annexe')->nullable()->constrained('annexe');
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
        Schema::dropIfExists('features_list');
    }
}
