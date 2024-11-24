<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->text('task'); // Kolom task
            $table->boolean('completed')->default(0); // Kolom completed, default 0
            $table->unsignedBigInteger('ticket_id')->nullable(); // Foreign key ke tickets
            $table->timestamps(); // Kolom created_at dan updated_at

            // Foreign key constraints
            $table->foreign('ticket_id')
                ->references('id')
                ->on('tickets')
                ->onDelete('cascade') // Hapus data pada todos jika tickets dihapus
                ->onUpdate('restrict'); // Larang update pada id tickets
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');
    }
}
