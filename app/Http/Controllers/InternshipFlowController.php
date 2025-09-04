<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipFlowController extends Controller
{
    public function uploadLetter(Request $request) {
        // Validasi file: hanya PDF, max 5MB
        $request->validate([
            'letter' => ['required','file','mimes:pdf','max:5120'],
        ], [
            'letter.mimes' => 'File harus PDF.',
        ]);

        // Cari/buat record internship milik user
        $internship = Internship::firstOrCreate(
            ['user_id' => $request->user()->id],
            ['status' => 'awaiting_letter']
        );

        // Cegah upload ulang saat sudah menunggu konfirmasi
        if ($internship->status !== 'awaiting_letter') {
            return back()->withErrors('Tahap upload surat sudah dilakukan atau menunggu konfirmasi admin.');
        }

        // Simpan file ke storage/app/public/internship/letters
        $path = $request->file('letter')->store('internship/letters', 'public');

        // Update status dan jejak waktu
        $internship->update([
            'letter_path'        => $path,
            'letter_uploaded_at' => now(),
            'status'             => 'waiting_confirmation',
        ]);

        return back()->with('success', 'Surat berhasil diunggah. Menunggu konfirmasi admin.');
    }
}

