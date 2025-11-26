<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'nama_admin' => 'Super Admin',
            'user_admin' => 'admin',
            'password'   => Hash::make('admin123'),
        ]);
    }
}