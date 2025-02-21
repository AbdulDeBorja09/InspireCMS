<?php

namespace Database\Seeders;

use App\Models\Layout;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayoutDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contacts
        Layout::create(['type' => 'contact', 'key' => 'phone', 'value' => 'ask@inspire-sportsacademy.com']);

        // Locations
        Layout::create(['type' => 'location', 'key' => 'address', 'value' => 'Km. 53 Pan-Philippine Highway, Calamba, Laguna, Philippines, 4027']);


        // Social Media
        Layout::create(['type' => 'social_media', 'key' => 'facebook', 'value' => 'https://www.facebook.com/isacademyph']);
        Layout::create(['type' => 'social_media', 'key' => 'tiktok', 'value' => 'https://www.tiktok.com/@isacademyph']);
        Layout::create(['type' => 'social_media', 'key' => 'instagram', 'value' => 'https://www.instagram.com/isacademyph']);
        // Logo
        Layout::create(['type' => 'logo', 'key' => 'nav', 'value' => '/images/logo/inspire-logo.png']);
        Layout::create(['type' => 'logo', 'key' => 'footer', 'value' => '/images/logo/inspire-logo.png']);
    }
}
