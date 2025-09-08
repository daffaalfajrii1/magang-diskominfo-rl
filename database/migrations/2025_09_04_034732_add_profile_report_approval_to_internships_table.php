<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('internships', function (Blueprint $table) {
      // status: awaiting_letter -> waiting_confirmation -> active | rejected
      if (!Schema::hasColumn('internships','status')) {
        $table->string('status')->default('awaiting_letter');
      }

      // surat pemohon
      if (!Schema::hasColumn('internships','letter_path')) {
        $table->string('letter_path')->nullable();
        $table->timestamp('letter_uploaded_at')->nullable();
      }

      // persetujuan
      if (!Schema::hasColumn('internships','confirmed_at')) {
        $table->timestamp('confirmed_at')->nullable(); // waktu menjadi ACTIVE
      }
      if (!Schema::hasColumn('internships','approved_by')) {
        $table->unsignedBigInteger('approved_by')->nullable();
        $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
      }

      // surat balasan admin
      if (!Schema::hasColumn('internships','approval_letter_path')) {
        $table->string('approval_letter_path')->nullable();
      }

      // Biodata
      if (!Schema::hasColumn('internships','full_name')) {
        $table->string('full_name')->nullable()->after('user_id');
        $table->string('whatsapp')->nullable();
        $table->string('school')->nullable();
        $table->string('major')->nullable();
        $table->string('student_id')->nullable();
        $table->text('address')->nullable();
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->timestamp('profile_completed_at')->nullable();
      }

      // Laporan
      if (!Schema::hasColumn('internships','final_report_path')) {
        $table->string('final_report_path')->nullable();
        $table->timestamp('final_report_uploaded_at')->nullable();
        $table->timestamp('completed_at')->nullable();
      }
    });
  }

  public function down(): void {
    Schema::table('internships', function (Blueprint $table) {
      $drop = [
        'letter_path','letter_uploaded_at','confirmed_at','approved_by',
        'approval_letter_path','full_name','whatsapp','school','major',
        'student_id','address','start_date','end_date','profile_completed_at',
        'final_report_path','final_report_uploaded_at','completed_at'
      ];
      foreach ($drop as $col) {
        if (Schema::hasColumn('internships', $col)) $table->dropColumn($col);
      }
      if (Schema::hasColumn('internships','approved_by')) $table->dropForeign(['approved_by']);
    });
  }
};
