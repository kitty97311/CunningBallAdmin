<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CunningUser;
use App\Models\Admin;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Admin::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@kitty.com',
            'password' => ('123'),
            'role' => 'admin',
            'state' => 'accepted',
       ]);
    //     Admin::factory()->count(10)->create([
    //        'password' => ('123'),
    //    ]);
        // CunningUser::factory()->count(30)->create([
        //     'password' => ('123'),
        //     'photo' => 'default_user.jpg',
        //     'last_ping_time' => now(),
        // ]);
}
}
