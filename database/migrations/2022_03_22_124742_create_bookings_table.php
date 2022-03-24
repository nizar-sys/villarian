<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('villa_id');
            $table->foreign('villa_id')->references('id')->on('villas')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama_pemesan');
            $table->string('no_hp');
            $table->date('tanggal_checkin');
            $table->date('tanggal_checkout');
            $table->enum('status_pembayaran', ['belum bayar', 'sudah bayar'])->default('belum bayar');
            $table->integer('total_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
