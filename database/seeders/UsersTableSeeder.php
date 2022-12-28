<?php

namespace Database\Seeders;

use App\models\User;
    use Illuminate\Database\Seeder;
 
    class UsersTableSeeder extends Seeder
    {
        public function run()
        {
            $user = new User;
            $user->name = "Admin";
            $user->email = "admin@nimishair.com";
            $user->password = bcrypt('nimishair');
            $user->is_admin = true;
            $user->save();
        }
    }