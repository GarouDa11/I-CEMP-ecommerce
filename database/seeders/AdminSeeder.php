<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\PlatformSetting;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin account
        Admin::create([
            'admin_id' => 'ADMIN001',
            'name' => 'Super Admin',
            'email' => 'admin@icemp.edu.my',
            'password' => Hash::make('admin123'),
        ]);
        
        // Create default platform settings
        PlatformSetting::create([
            'key' => 'commission_rate',
            'value' => '5',
            'description' => 'Platform commission rate (%)'
        ]);
        
        PlatformSetting::create([
            'key' => 'max_product_price',
            'value' => '1000',
            'description' => 'Maximum product price (RM)'
        ]);
        
        PlatformSetting::create([
            'key' => 'allow_new_sellers',
            'value' => 'true',
            'description' => 'Allow new seller registrations'
        ]);
    }
}