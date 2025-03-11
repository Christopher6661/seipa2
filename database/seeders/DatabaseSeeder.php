<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
        $user = new User;
        $user->name = 'Admin'; 
        $user->email = 'admin@test.com'; 
        $user->password = '1234';
        $user->role = 'admin';

        $user->save();

        $user2 = new User;
        $user2->name = 'pedro';
        $user2->email = 'Personal@gmail.com';
        $user2->password = '12345';
        $user2->role = 'personal';

        $user2->save();

        $user3 = new User;
        $user3->name = 'Angela';
        $user3->email = 'Angela11@gmail.com';
        $user3->password = '12345';
        $user3->role = 'pescador fisico';

        $user3->save();

        $user4 = new User;
        $user4->name = 'Julian';
        $user4->email = 'Julio28@gmail.com';
        $user4->password = '12345';
        $user4->role = 'pescador moral';

        $user4->save();

        $user5 = new User;
        $user5->name = 'Sebastian';
        $user5->email = 'Cr7bastian@gmail.com';
        $user5->password = '12345';
        $user5->role = 'acuicultor fisico';

        $user5->save();

        $user6 = new User;
        $user6->name = 'Ana';
        $user6->email = 'Anatorroja@gmail.com';
        $user6->password = '12345';
        $user6->role = 'acuicultor moral';

        $user6->save();
    }
}
