<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_history', function (Blueprint $table) {
            $table->id(); // Kolom id sebagai primary key
            $table->unsignedBigInteger('asset_id')->nullable(); // Kolom asset_id (foreign key)
            $table->enum('action', ['INSERT', 'DELETE']); // Kolom action
            $table->string('code', 50)->nullable(); // Kolom code
            $table->string('category', 200)->nullable(); // Kolom category
            $table->unsignedBigInteger('merk')->nullable(); // Kolom merk (foreign key)
            $table->string('serial_number', 50)->nullable(); // Kolom serial_number
            $table->string('entry_date', 200)->nullable(); // Kolom entry_date
            $table->string('spesification', 50)->nullable(); // Kolom spesification
            $table->string('condition', 200)->nullable(); // Kolom condition
            $table->enum('status', ['Operation', 'Inventory'])->nullable(); // Kolom status
            $table->string('location', 255)->nullable(); // Kolom location
            $table->datetime('handover_date')->nullable(); // Kolom handover_date
            $table->timestamp('action_time')->useCurrent(); // Kolom action_time
            $table->string('documentation', 200)->nullable(); // Kolom documentation

            // Foreign key untuk asset_id
            $table->foreign('asset_id')
                ->references('id')
                ->on('assets')
                ->onDelete('set null') // Jika asset dihapus, history tetap disimpan dengan asset_id null
                ->onUpdate('cascade');

            // Foreign key untuk merk
            $table->foreign('merk')
                ->references('id')
                ->on('merk')
                ->onDelete('set null') // Jika merk dihapus, history tetap disimpan dengan merk null
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets_history');
    }
}
