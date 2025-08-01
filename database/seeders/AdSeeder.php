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
                'title' => 'Premium Banner Advertisement',
                'image_url' => 'ads/placeholder-banner.jpg',
                'link_url' => 'https://example.com',
                'size' => '728x90',
                'position' => 'header',
                'is_active' => true,
            ],
            [
                'title' => 'Sidebar Promotion',
                'image_url' => 'ads/placeholder-sidebar.jpg',
                'link_url' => 'https://promotion.com',
                'size' => '160x300',
                'position' => 'sidebar',
                'is_active' => true,
            ],
            [
                'title' => 'Footer Advertisement',
                'image_url' => 'ads/placeholder-footer.jpg',
                'link_url' => 'https://footer-ad.com',
                'size' => '468x60',
                'position' => 'footer',
                'is_active' => false,
            ],
            [
                'title' => 'Content Top Banner',
                'image_url' => 'ads/placeholder-content.jpg',
                'link_url' => 'https://content-top.com',
                'size' => '300x250',
                'position' => 'content-top',
                'is_active' => true,
            ],
            [
                'title' => 'Mobile Banner',
                'image_url' => 'ads/placeholder-mobile.jpg',
                'link_url' => 'https://mobile-ad.com',
                'size' => '320x50',
                'position' => 'header',
                'is_active' => true,
            ],
        ];

        foreach ($ads as $ad) {
            Ad::create($ad);
        }
    }
}
