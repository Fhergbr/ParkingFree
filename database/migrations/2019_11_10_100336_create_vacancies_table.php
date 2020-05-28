<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacanciesTable extends Migration
{

    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer("order");
            $table->string("status",10)->default("livre");
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('vacancies');
    }
}
