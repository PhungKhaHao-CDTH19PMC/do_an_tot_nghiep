<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKhenthuongKiluatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khenthuong_kiluat', function (Blueprint $table) {
            $table->id();
            $table->double('soktkl')->nullable();
            $table->string('noidung')->nullable();
            $table->dateTime('ngay')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('loai')->nullable();
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
        Schema::dropIfExists('khenthuong_kiluat');
    }
}
