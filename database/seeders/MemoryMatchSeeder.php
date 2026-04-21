<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\User;

class MemoryMatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@admin.com')->first();

        if ($admin) {
            Game::create([
                'title' => 'Memory Match',
                'description' => 'Encuentra las parejas de símbolos espaciales en este clásico juego de memoria.',
                'status' => 'active',
                'path' => '/games/memory-match/index.html',
                'user_id' => $admin->id,
            ]);
        }
    }
}
