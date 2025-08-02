<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ad;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ads = [
            [
                'title' => 'Header Banner',
                'script' => null,
                'size' => '728x90',
                'is_active' => true,
            ],
            [
                'title' => 'Detail Page Sidebar Banner',
                'script' => null,
                'size' => '160x300',
                'is_active' => true,
            ],
            [
                'title' => 'News Sidebar Banner',
                'script' => null,
                'size' => '468x60',
                'is_active' => true,
            ],
            [
                'title' => 'Home Sidebar Banner',
                'script' => null,
                'size' => '300x250',
                'is_active' => true,
            ],
            [
                'title' => 'Footer Banner',
                'script' => null,
                'size' => '320x50',
                'is_active' => true,
            ],
            [
                'title' => 'News Sidebar Banner 2',
                'script' => null,
                'size' => '160x600',
                'is_active' => true,
            ],
        ];

        foreach ($ads as $ad) {
            Ad::updateOrCreate(
                ['size' => $ad['size']],
                $ad
            );
        }
    }
}
