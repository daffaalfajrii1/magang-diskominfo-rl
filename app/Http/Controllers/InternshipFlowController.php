<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipFlowController extends Controller
{
    // STEP 1: upload surat pemohon
    public function uploadLetter(Request $request)
    {
        $request->validate([
            'letter' => ['required','file','mimes:pdf','max:5120'],
        ], ['letter.mimes' => 'File surat harus PDF.']);

        $internship = Internship::firstOrCreate(
            ['user_id' => $request->user()->id],
            ['status'  => 'awaiting_letter']
        );

        $path = $request->file('letter')->store('internship/letters', 'public');

        $internship->update([
            'letter_path'        => $path,
            'letter_uploaded_at' => now(),
            // begitu upload, status jadi waiting_confirmation
            'status'             => 'waiting_confirmation',
        ]);

        return back()->with('success','Surat berhasil diunggah, menunggu konfirmasi admin.');
    }

    // STEP 3: simpan biodata (hanya saat ACTIVE)
    public function saveProfile(Request $request)
    {
    $internship = \App\Models\Internship::where('user_id', $request->user()->id)->firstOrFail();

    if ($internship->status !== 'active') {
        return back()->withErrors('Biodata hanya dapat diisi setelah kamu dinyatakan AKTIF.');
    }

    $data = $request->validate([
        'full_name'  => ['required','string','max:150'],
        'whatsapp'   => ['required','string','max:30'],
        'school'     => ['required','string','max:150'],
        'major'      => ['required','string','max:150'],
        'student_id' => ['nullable','string','max:50'],
        'address'    => ['required','string','max:1000'],
        'start_date' => ['required','date'],
        'end_date'   => ['required','date','after_or_equal:start_date'],
        // ⬇️ foto opsional
        'photo'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
    ]);

    // handle foto (opsional)
    if ($request->hasFile('photo')) {
        if ($internship->photo_path && \Storage::disk('public')->exists($internship->photo_path)) {
            \Storage::disk('public')->delete($internship->photo_path);
        }
        $photoPath = $request->file('photo')->store('internship/photos','public');
        $data['photo_path'] = $photoPath;
    }

    $internship->update($data + [
        'profile_completed_at' => now(),
    ]);

    return back()->with('success','Biodata tersimpan.');
    }

    // STEP 4: upload laporan akhir (maks 10 hari setelah selesai)
    public function uploadFinalReport(Request $request)
    {
    $internship = \App\Models\Internship::where('user_id', $request->user()->id)->firstOrFail();

    if ($internship->status !== 'active') {
        return back()->withErrors('Laporan hanya dapat diunggah untuk peserta AKTIF.');
    }
    if (!$internship->end_date) {
        return back()->withErrors('Lengkapi tanggal selesai magang pada biodata terlebih dahulu.');
    }

    $deadline = $internship->end_date->copy()->addDays(10);
    if (now()->greaterThan($deadline)) {
        return back()->withErrors('Batas waktu unggah laporan telah lewat (maksimal 10 hari setelah selesai).');
    }

    $request->validate([
        'final_report' => ['required','file','mimes:pdf','max:10240'],
    ]);

    $path = $request->file('final_report')->store('internship/final_reports', 'public');

    $internship->update([
        'final_report_path'        => $path,
        'final_report_uploaded_at' => now(),
        'completed_at'             => now(),
        'status'                   => 'completed',   // ⬅️ penting
    ]);

    return back()->with('success','Laporan akhir berhasil diunggah. Status kamu: Selesai Magang.');
    }
}
