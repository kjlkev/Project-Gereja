<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AlatAVL;
use App\Models\AudioVisual;
use App\Models\Instrument;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'fullname' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'is_admin' => true,
        ]);

        User::create([
            'fullname' => 'User',
            'username' => 'user',
            'password' => bcrypt('user'),
            'is_admin' => false,
        ]);

        User::create([
            'fullname' => 'User2',
            'username' => 'user2',
            'password' => bcrypt('user2'),
            'is_admin' => false,
        ]);

        User::create([
            'fullname' => 'User3',
            'username' => 'user3',
            'password' => bcrypt('user3'),
            'is_admin' => false,
        ]);

        Instrument::create([
            'nama' => 'Gitar',
        ]);

        Instrument::create([
            'nama' => 'Keyboard',
        ]);

        Instrument::create([
            'nama' => 'Bass',
        ]);

        Instrument::create([
            'nama' => 'Drum',
        ]);

        Instrument::create([
            'nama' => 'Worship Leader',
        ]);

        AlatAVL::create([
            'nama' => 'Soundman',
        ]);
        AlatAVL::create([
            'nama' => 'Setup',
        ]);
        AlatAVL::create([
            'nama' => 'Camera',
        ]);
        AlatAVL::create([
            'nama' => 'Slide',
        ]);
    }
}
