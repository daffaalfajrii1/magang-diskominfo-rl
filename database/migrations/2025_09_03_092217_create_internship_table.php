<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('internships', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();

      // status alur: awaiting_letter -> waiting_confirmation -> (nanti) confirmed -> ...
      $table->string('status')->default('awaiting_letter');

      // surat magang
      $table->string('letter_path')->nullable();
      $table->timestamp('letter_uploaded_at')->nullable();

      // (nanti) konfirmasi admin
      $table->timestamp('confirmed_at')->nullable();

      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('internships');
  }
};
