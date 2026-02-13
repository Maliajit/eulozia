<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SettingsSeeder::class,
            // SnippetDemoSeeder::class,
            // DemoCustomerSeeder::class,  
            // HomeSeeder::class,  
            // JewelryStoreSeeder::class,      
            // PageSeeder::class, 
            // ReviewSeeder::class,     
            // TestimonialSeeder::class,       
        ]);
    }
}
