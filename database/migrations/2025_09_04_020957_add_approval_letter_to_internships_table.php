<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('internships', function (Blueprint $table) {
      $table->string('approval_letter_path')->nullable()->after('letter_path'); // surat balasan admin
      $table->unsignedBigInteger('approved_by')->nullable()->after('confirmed_at'); // id admin
      $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
    });
  }
  public function down(): void {
    Schema::table('internships', function (Blueprint $table) {
      $table->dropForeign(['approved_by']);
      $table->dropColumn(['approval_letter_path','approved_by']);
    });
  }
};
