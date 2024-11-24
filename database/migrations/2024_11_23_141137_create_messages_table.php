<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id(); // Kolom id sebagai primary key
            $table->unsignedBigInteger('ticket_id'); // Kolom ticket_id
            $table->unsignedBigInteger('sender_id'); // Kolom sender_id
            $table->text('message'); // Kolom message
            $table->timestamp('created_at')->useCurrent(); // Kolom created_at dengan default CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // Kolom updated_at dengan ON UPDATE CURRENT_TIMESTAMP
            $table->boolean('is_read')->default(0)->nullable(); // Kolom is_read dengan default 0 dan bisa NULL

            // Definisi foreign key untuk ticket_id
            $table->foreign('ticket_id')
                ->references('id')
                ->on('tickets')
                ->onDelete('cascade') // Menghapus data terkait jika tiket dihapus
                ->onUpdate('restrict'); // Membatasi update pada tiket

            // Index untuk ticket_id
            $table->index('ticket_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
