<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_history', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('transaction_id')->nullable(); // Foreign key ke transactions
            $table->string('type_transactions', 100)->nullable(); // Kolom type_transactions
            $table->string('asset_code', 100)->nullable(); // Kolom asset_code
            $table->string('category_asset', 100)->nullable(); // Kolom category_asset
            $table->string('merk', 100)->nullable(); // Kolom merk
            $table->string('specification', 255)->nullable(); // Kolom specification
            $table->string('serial_number', 100)->nullable(); // Kolom serial_number
            $table->string('name_holder', 100)->nullable(); // Kolom name_holder
            $table->string('position', 100)->nullable(); // Kolom position
            $table->string('location', 100)->nullable(); // Kolom location
            $table->enum('status', ['Operation', 'Inventory'])->nullable(); // Kolom status
            $table->string('asset_condition', 100)->nullable(); // Kolom asset_condition
            $table->string('documentation', 255)->nullable(); // Kolom documentation
            $table->string('reason', 255)->nullable(); // Kolom reason
            $table->text('note')->nullable(); // Kolom note
            $table->timestamps(); // Kolom created_at dan updated_at

            // Foreign key constraints
            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('set null')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_history');
    }
}
