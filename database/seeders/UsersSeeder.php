<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::Create([
            'email'                => env('ADMIN_EMAIL', 'manager@sms.to'),
            'name'                 => env('ADMIN_NAME', 'Manager'),
            'password'             => bcrypt(env('ADMIN_PASSWORD', ':ZkiErz99dHKv4M')),
            'created_at'           => date('Y-m-d H:i:s'),
        ]);

    }
}
