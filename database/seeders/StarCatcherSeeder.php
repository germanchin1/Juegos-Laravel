<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\User;

class StarCatcherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@admin.com')->first();

        if ($admin) {
            Game::create([
                'title' => 'Star Catcher',
                'description' => 'Un juego simple de atrapar estrellas que caen del cielo. ¡No dejes que se escapen!',
                'status' => 'active',
                'path' => '/games/star-catcher/index.html',
                'user_id' => $admin->id,
            ]);
        }
    }
}
