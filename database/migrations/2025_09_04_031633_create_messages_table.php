<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('messages', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('internship_id');       // ke pengajuan
      $table->unsignedBigInteger('admin_id');            // pengirim (user role=admin)
      $table->string('subject')->nullable();
      $table->text('body');
      $table->timestamps();

      $table->foreign('internship_id')->references('id')->on('internships')->cascadeOnDelete();
      $table->foreign('admin_id')->references('id')->on('users')->cascadeOnDelete();
    });
  }
  public function down(): void {
    Schema::dropIfExists('messages');
  }
};
