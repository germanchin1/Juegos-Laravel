<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Default Roles
        $adminRole = \App\Models\Role::create(['name' => 'Administrador', 'slug' => 'administrador']);
        $gestorRole = \App\Models\Role::create(['name' => 'Gestor', 'slug' => 'gestor']);
        $jugadorRole = \App\Models\Role::create(['name' => 'Jugador', 'slug' => 'jugador']);

        // Create Admin User
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        // Assign Admin Role
        $admin->roles()->attach($adminRole);

        // Create a Player User for testing
        $player = User::factory()->create([
            'name' => 'Player User',
            'email' => 'player@player.com',
            'password' => bcrypt('password'),
        ]);
        $player->roles()->attach($jugadorRole);
    }
}
