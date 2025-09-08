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
        $base = Internship::whereHas('user', fn($q) => $q->where('role','user'));

        $newSubmissions = (clone $base)->where('status','waiting_confirmation')->count();
        $active         = (clone $base)->where('status','active')->count();
        $completed      = (clone $base)->where('status','completed')->count();

        // Disetujui = yang sudah DISETUJUI & MASIH BERJALAN (active saja, tidak termasuk completed)
        $approved       = $active;

        $usersCount     = User::where('role','user')->count();
        $totalInt       = (clone $base)->count();

        return view('admin.dashboard', compact(
            'newSubmissions','approved','active','completed','usersCount','totalInt'
        ));
    }
}
