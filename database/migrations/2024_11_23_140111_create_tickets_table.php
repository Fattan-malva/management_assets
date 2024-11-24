<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // Kolom id dengan AUTO_INCREMENT
            $table->unsignedBigInteger('user_id'); // Kolom user_id
            $table->string('subject', 255); // Kolom subject
            $table->enum('status', ['Open', 'Closed', 'In Progress'])->default('Open')->nullable(); // Kolom status
            $table->boolean('is_read')->default(0); // Kolom is_read
            $table->timestamp('created_at')->useCurrent(); // Kolom created_at dengan default CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // Kolom updated_at dengan ON UPDATE CURRENT_TIMESTAMP

            // Foreign key jika diperlukan
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
