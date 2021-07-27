<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $data = [];
        $data[] = [
                'name' => 'welcome',
                'value' => 'Edit this setting to define the welcome page for your application.',
                'created_at' => $now,
                'updated_at' => $now
        ];

        DB::table('settings')->insert($data);

        $data[] = [
            'name' => 'terms',
            'value' => 'Edit this setting to define the terms of service for your application.',
            'created_at' => $now,
            'updated_at' => $now
        ];
        DB::table('settings')->insert($data);

        $data[] = [
            'name' => 'privacy',
            'value' => 'Edit this setting to define the privacy policy for your application.',
            'created_at' => $now,
            'updated_at' => $now
        ];
        DB::table('settings')->insert($data);

        $data = [];
        $data[] = [
            'name' => 'token',
            'value' => 'xxxxxxxxxxx',
            'created_at' => $now,
            'updated_at' => $now
        ];
        $data[] = [
            'name' => 'email',
            'value' => env('ADMIN_EMAIL', 'manager@sms.to'),
            'created_at' => $now,
            'updated_at' => $now
        ];
        $data[] = [
            'name' => 'phone',
            'value' => '+35722000522',
            'created_at' => $now,
            'updated_at' => $now
        ];
        $data[] = [
            'name' => 'address',
            'value' => 'Intergo Telecom Ltd,
                        Nikolaou Nikolaidi 3, Office 206,
                        Paphos, 8010, Cyprus',
                        'created_at' => $now,
                        'updated_at' => $now
        ];

        DB::table('settings')->insert($data);
    }
}
