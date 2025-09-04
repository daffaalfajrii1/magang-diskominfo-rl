<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function show(Request $request) {
        // Pastikan setiap user punya 1 record internship
        $internship = Internship::firstOrCreate(
            ['user_id' => $request->user()->id],
            ['status' => 'awaiting_letter']
        );

        return view('dashboard', [
            'user'        => $request->user(),
            'internship'  => $internship,
        ]);
    }
}
