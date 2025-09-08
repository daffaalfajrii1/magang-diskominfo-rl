<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminInternshipController extends Controller
{
    // daftar pengajuan/peserta
    public function index(Request $request)
    {
        $status = $request->query('status','waiting_confirmation');
        $q = Internship::with('user')->whereHas('user', fn($qq) => $qq->where('role','user'));
        if ($status !== 'all') $q->where('status',$status);
        $internships = $q->orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('admin.internships.index', compact('internships','status'));
    }

    public function show(Internship $internship)
    {
        $internship->load(['user','messages.admin']);
        return view('admin.internships.show', compact('internship'));
    }

    // setujui -> jadi ACTIVE (+ optional upload surat balasan)
    public function approve(Request $request, Internship $internship)
    {
        if (!in_array($internship->status, ['waiting_confirmation','awaiting_letter'])) {
            return back()->withErrors('Pengajuan ini sudah diproses.');
        }

        $request->validate([
            'approval_letter' => ['nullable','file','mimes:pdf','max:5120'],
        ]);

        $path = $internship->approval_letter_path;
        if ($request->hasFile('approval_letter')) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $path = $request->file('approval_letter')->store('internship/approval_letters', 'public');
        }

        $internship->update([
            'status'               => 'active',
            'confirmed_at'         => now(),
            'approved_by'          => $request->user()->id,
            'approval_letter_path' => $path,
        ]);

        return redirect()->route('admin.internships.show', $internship)->with('success','Peserta disetujui & menjadi AKTIF.');
    }

    // unggah/replace surat balasan (waiting_confirmation | active)
    public function uploadApprovalLetter(Request $request, Internship $internship)
    {
        if (!in_array($internship->status, ['waiting_confirmation','active'])) {
            return back()->withErrors('Tidak dapat unggah surat balasan pada status ini.');
        }

        $request->validate([
            'approval_letter' => ['required','file','mimes:pdf','max:5120'],
        ]);

        if ($internship->approval_letter_path && Storage::disk('public')->exists($internship->approval_letter_path)) {
            Storage::disk('public')->delete($internship->approval_letter_path);
        }
        $path = $request->file('approval_letter')->store('internship/approval_letters', 'public');

        $internship->update([
            'approval_letter_path' => $path,
            'approved_by'          => $request->user()->id,
            'confirmed_at'         => $internship->confirmed_at ?: now(),
            'status'               => $internship->status === 'waiting_confirmation' ? 'active' : $internship->status,
        ]);

        return back()->with('success','Surat balasan tersimpan.');
    }

    // kirim pesan (notifikasi) ke user
    public function sendMessage(Request $request, Internship $internship)
    {
        $data = $request->validate([
            'subject' => ['nullable','string','max:150'],
            'body'    => ['required','string','max:5000'],
        ]);

        Message::create([
            'internship_id' => $internship->id,
            'admin_id'      => $request->user()->id,
            'subject'       => $data['subject'] ?? null,
            'body'          => $data['body'],
        ]);

        return back()->with('success','Pesan terkirim ke peserta.');
    }

    // tolak (hanya jika belum aktif)
    public function reject(Request $request, Internship $internship)
    {
        if ($internship->status === 'active') {
            return back()->withErrors('Peserta sudah AKTIF dan tidak dapat ditolak.');
        }
        if (!in_array($internship->status, ['waiting_confirmation','awaiting_letter'])) {
            return back()->withErrors('Pengajuan ini sudah diproses.');
        }

        $data = $request->validate([
            'reason' => ['nullable','string','max:1000'],
        ]);

        $internship->update(['status' => 'rejected']);

        if (!empty($data['reason'])) {
            Message::create([
                'internship_id' => $internship->id,
                'admin_id'      => $request->user()->id,
                'subject'       => 'Pengajuan Ditolak',
                'body'          => $data['reason'],
            ]);
        }

        return redirect()->route('admin.internships.show', $internship)->with('success','Pengajuan ditolak.');
    }
}
