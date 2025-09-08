<?php

namespace App\Http\Controllers;

use App\Models\Internship;

class PublicPageController extends Controller
{
    public function completed()
    {
        $interns = Internship::with('user')
            ->where('status', 'completed')
            ->whereHas('user', fn($q) => $q->where('role','user'))
            ->orderByDesc('completed_at')
            ->paginate(8);

        return view('public.completed', compact('interns'));
    }
}
