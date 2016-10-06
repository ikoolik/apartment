<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('queue')->unsigned();
            $table->integer('building')->unsigned();
            $table->integer('floor')->unsigned();
            $table->integer('door')->unsigned();
            $table->string('state');
            $table->integer('price');
            $table->timestamps();
        });

        for($floor = 3; $floor <= 26; $floor++) {
            $door = 17 + ($floor - 3) * 21;
            \App\Apartment::create([
                'queue' => 11,
                'building' => 4,
                'floor' => $floor,
                'door' => $door,
                'state' => 'свободна',
                'price' => 0
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
}
