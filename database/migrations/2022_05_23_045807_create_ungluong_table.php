<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUngluongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ungluong', function (Blueprint $table) {
            $table->id();
            $table->double('sotien')->nullable();
            $table->dateTime('ngay')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('trangthai')->nullable();
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
        Schema::dropIfExists('ungluong');
    }
}
