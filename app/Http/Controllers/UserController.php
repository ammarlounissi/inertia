<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Users/Index', [
            // 'users' => User::paginate(10)->through(fn($user) => [
            //     'id' => $user->id,
            //     'name' => $user->name
            // ])
            'users' => User::query()
                ->when(request()->input('search'), function ($query, $search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orderByDesc('created_at')
                ->paginate(10)
                ->withQueryString()
                ->through(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'can' => [
                        'update' => Auth::user()->can('update', $user),
                        'delete' => Auth::user()->can('delete', $user)
                    ]
                ]),
            'filters' => request()->only(['search']),
            'can' => [
                'createUser' => Auth::user()->can('create', User::class)
            ],
            'testAttr' => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(8)],
        ]);

        $attributes['remember_token'] = Str::random(10);

        User::create($attributes);

        return redirect('/users');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $attributes = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
        ]);

        $user->update($attributes);

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect('/users');
    }

}
