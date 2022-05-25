<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTangcaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tangca', function (Blueprint $table) {
            $table->id();
            $table->dateTime('ngay')->nullable();
            $table->double('sogio')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('loaica_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tangca');
    }
}
