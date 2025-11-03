<?php

namespace App\Http\Controllers;

use App\Models\WarshAyah;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WarshAyahController extends Controller
{
    public function index(Request $request)
    {
        $warshAyahs = WarshAyah::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('aya_text', 'like', '%' . $request->search . '%')
                      ->orWhere('sura_name_ar', 'like', '%' . $request->search . '%')
                      ->orWhere('sura_name_en', 'like', '%' . $request->search . '%');
            })
            ->when($request->sura_no, function ($query) use ($request) {
                $query->where('sura_no', $request->sura_no);
            })
            ->when($request->jozz, function ($query) use ($request) {
                $query->where('jozz', $request->jozz);
            })
            ->paginate(20);

        return Inertia::render('WarshAyahs/Index', [
            'warshAyahs' => $warshAyahs,
            'filters' => $request->only(['search', 'sura_no', 'jozz'])
        ]);
    }
}
