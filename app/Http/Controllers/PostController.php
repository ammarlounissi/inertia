<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->leftJoin('warsh_ayahs', function($join) {
                $join->on('posts.surah_id', '=', 'warsh_ayahs.sura_no')
                     ->whereRaw('warsh_ayahs.aya_no = 1'); // Get first ayah to get surah name
            })
            ->select('posts.*', 'warsh_ayahs.sura_name_ar')
            ->latest('posts.created_at')
            ->get();

        return Inertia::render('Posts/Index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        // Get unique surahs with their verse counts
        $surahs = \DB::table('warsh_ayahs')
            ->select('sura_no', 'sura_name_ar', \DB::raw('MAX(aya_no) as total_verses'))
            ->groupBy('sura_no', 'sura_name_ar')
            ->orderBy('sura_no')
            ->get()
            ->map(function ($surah) {
                $surah->sura_name_ar = trim($surah->sura_name_ar);
                return $surah;
            });

        return Inertia::render('Posts/Create', [
            'surahs' => $surahs,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'surah_id' => 'required|integer|min:1|max:114',
            'start_verse' => 'required|integer|min:1',
            'end_verse' => 'required|integer|min:1|gte:start_verse',
        ]);

        Post::create([
            'user_id' => auth()->id(),
            'surah_id' => $request->surah_id,
            'start_verse' => $request->start_verse,
            'end_verse' => $request->end_verse,
        ]);

        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        $post->load('user', 'ayahs');

        // Get the surah name
        $surahName = \DB::table('warsh_ayahs')
            ->where('sura_no', $post->surah_id)
            ->value('sura_name_ar');

        // Get the specific ayahs for this post range
        $ayahs = \DB::table('warsh_ayahs')
            ->where('sura_no', $post->surah_id)
            ->whereBetween('aya_no', [$post->start_verse, $post->end_verse])
            ->orderBy('aya_no')
            ->get();

        return Inertia::render('Posts/Show', [
            'post' => $post,
            'ayahs' => $ayahs,
            'surah_name' => $surahName,
        ]);
    }
}
