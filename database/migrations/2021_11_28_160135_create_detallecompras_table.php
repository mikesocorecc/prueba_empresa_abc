<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallecomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallecompras', function (Blueprint $table) {
            $table->id();
            $table->integer("cantidad");
            $table->decimal("precio");
            // Foraneas
            $table->foreignId('compraid')->constrained('id')->on("compras")->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('productoid')->constrained('id')->on("productos")->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('proveedorid')->constrained('id')->on("proveedores")->onDelete('cascade')->onUpdate('cascade');
            $table->decimal("subtotal");
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
        Schema::dropIfExists('detallecompras');
    }
}
