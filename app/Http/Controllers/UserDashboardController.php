<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Internship;

class UserDashboardController extends Controller
{
    public function show(Request $request) {
        $user = $request->user();

        if ($user->role !== 'user') {
            return redirect()->route('admin.dashboard');
        }

        $internship = Internship::with(['messages.admin'])
            ->firstOrCreate(
                ['user_id' => $user->id],
                ['status'  => 'awaiting_letter']
            );

        return view('dashboard', compact('user','internship'));
    }
}
