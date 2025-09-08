<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin (SB Admin 2) dengan angka ringkas.
     * - waiting: status waiting_confirmation
     * - approved: status confirmed
     * - active: sementara = confirmed (nanti bisa ganti dengan range tanggal)
     * - users: total pengguna
     * - all_internships: total pengajuan
     */
    public function index()
    {
        $counts = [
        'waiting'  => \App\Models\Internship::where('status','waiting_confirmation')
                        ->whereHas('user', fn($q) => $q->where('role','user')) // ⬅️ exclude admin
                        ->count(),
        'approved' => \App\Models\Internship::where('status','confirmed')
                        ->whereHas('user', fn($q) => $q->where('role','user'))
                        ->count(),
        'active'   => \App\Models\Internship::where('status','confirmed')
                        ->whereHas('user', fn($q) => $q->where('role','user'))
                        ->count(), // (sementara = confirmed)
        'users'    => \App\Models\User::where('role','user')->count(), // ⬅️ hanya user
        'all_internships' => \App\Models\Internship::whereHas('user', fn($q) => $q->where('role','user'))->count(),
        ];

        return view('admin.dashboard', compact('counts'));
    }
}
