<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{

    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->decimal('price',3,2);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
