<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class TestBannerSeeder extends Seeder
{
    public function run()
    {
        // 1. External URL Banner
        Banner::create([
            'title' => 'Test External Banner',
            'subtitle' => 'Verification 1',
            'image' => 'https://via.placeholder.com/1920x600.png?text=External+Banner',
            'sort_order' => 1,
            'status' => true,
        ]);

        // 2. Local Path Banner (simulating standard media upload)
        // Assuming MediaController returns paths like 'uploads/image.jpg'
        Banner::create([
            'title' => 'Test Local Banner',
            'subtitle' => 'Verification 2',
            'image' => 'banners/demo-banner.jpg', // This will become asset('storage/banners/demo-banner.jpg')
            'sort_order' => 2,
            'status' => true,
        ]);
    }
}
