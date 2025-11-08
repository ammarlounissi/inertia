<?php

namespace App\Http\Controllers;

use App\Models\Verse;
use Inertia\Inertia;

class VerseController extends Controller
{
    public function index()
    {
        $verses = Verse::all();
        return Inertia::render('Verses/Index', [
            'verses' => $verses,
        ]);
    }
}