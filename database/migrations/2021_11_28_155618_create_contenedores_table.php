<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContenedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenedores', function (Blueprint $table) {
            $table->id();
            $table->string("identificacion");
            $table->integer("cantidad");
            $table->date("fechaArribo");
            $table->string("lugarArribo");
            $table->string("aeropuertodestino");
            // FORANEAS
            $table->foreignId('productoid')->constrained('id')->on("productos")->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('contenedores');
    }
}
