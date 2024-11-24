<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepreciationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depreciation', function (Blueprint $table) {
            $table->id(); // Kolom id sebagai primary key
            $table->string('asset_code', 200); // Kolom asset_code
            $table->date('date'); // Kolom date
            $table->decimal('depreciation_price', 10, 0); // Kolom depreciation_price
            $table->timestamp('created_at')->useCurrent(); // Kolom created_at dengan default current_timestamp
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depreciation');
    }
}
