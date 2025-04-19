<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'hero_slider',
                'value' => json_encode([
                    [
                        'title' => 'Welcome to Egeden Emlak',
                        'subtitle' => 'Find your dream property',
                        'image' => null
                    ],
                    [
                        'title' => 'Premium Properties',
                        'subtitle' => 'Discover luxury living',
                        'image' => null
                    ],
                    [
                        'title' => 'Expert Real Estate Services',
                        'subtitle' => 'Your trusted partner in real estate',
                        'image' => null
                    ]
                ]),
                'type' => 'json',
                'group' => 'homepage',
                'label' => 'Hero Slider',
                'description' => 'Configure the main slider on the homepage'
            ],
            [
                'key' => 'site_title',
                'value' => 'Egeden Emlak',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Title',
                'description' => 'The main title of your website'
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@egedenemlak.com',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Contact Email',
                'description' => 'The main contact email address'
            ],
            [
                'key' => 'contact_phone',
                'value' => '+90 123 456 7890',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Contact Phone',
                'description' => 'The main contact phone number'
            ]
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
} 