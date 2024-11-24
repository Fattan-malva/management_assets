<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_history', function (Blueprint $table) {
            $table->id(); // Kolom id sebagai primary key
            $table->unsignedBigInteger('assets_id'); // Kolom assets_id
            $table->string('code', 200); // Kolom code
            $table->date('last_maintenance'); // Kolom last_maintenance
            $table->string('condition', 200); // Kolom condition
            $table->string('note_maintenance', 200); // Kolom note_maintenance
            $table->timestamp('created_at')->useCurrent(); // Kolom created_at dengan default current_timestamp

            // Foreign key ke tabel assets
            $table->foreign('assets_id')->references('id')->on('assets')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_history');
    }
}
