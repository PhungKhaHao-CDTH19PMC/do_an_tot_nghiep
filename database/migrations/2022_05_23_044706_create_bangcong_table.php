<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBangcongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bangcong', function (Blueprint $table) {
            $table->id();
            $table->dateTime('giovao')->nullable();
            $table->dateTime('giora')->nullable();
            $table->string('noidung')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('loaicong_id')->nullable();
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
        Schema::dropIfExists('bangcong');
    }
}
