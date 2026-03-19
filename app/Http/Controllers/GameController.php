<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Game;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Display a listing of the resource (Admin/Manager).
     */
    public function index()
    {
        $games = Game::with('user')->get();
        return Inertia::render('Games/Index', [
            'games' => $games
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Games/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:draft,published,private',
            'path' => 'required|string',
        ]);

        Auth::user()->games()->create($validated);

        return redirect()->route(Auth::user()->hasRole('administrador') ? 'admin.games.index' : 'manager.games.index')
            ->with('message', 'Juego creado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        return Inertia::render('Games/Edit', [
            'game' => $game
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:draft,published,private',
            'path' => 'required|string',
        ]);

        $game->update($validated);

        return redirect()->route(Auth::user()->hasRole('administrador') ? 'admin.games.index' : 'manager.games.index')
            ->with('message', 'Juego actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->back()->with('message', 'Juego eliminado correctamente.');
    }

    /**
     * Display a listing of published games for players.
     */
    public function playerIndex()
    {
        $games = Game::where('status', 'published')->get();
        return Inertia::render('Player/Index', [
            'games' => $games
        ]);
    }

    /**
     * Display the specified game in a viewer.
     */
    public function playerShow(Game $game)
    {
        if ($game->status !== 'published') {
            abort(403);
        }

        return Inertia::render('Player/Show', [
            'game' => $game
        ]);
    }
}
