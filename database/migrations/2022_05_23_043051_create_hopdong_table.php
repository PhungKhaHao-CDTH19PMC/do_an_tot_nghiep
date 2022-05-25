<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHopdongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hopdong', function (Blueprint $table) {

            $table->id();
            $table->string('sohd')->nullable();
            $table->dateTime('ngaybatdau')->nullable();
            $table->dateTime('ngayketthuc')->nullable();
            $table->dateTime('ngayki')->nullable();
            $table->string('noidung')->nullable();
            $table->string('lanky')->nullable();
            $table->string('thoigian')->nullable();
            $table->string('hsoluong')->nullable();
            $table->string('user_id')->nullable();
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
        Schema::dropIfExists('hopdong');
    }
}
