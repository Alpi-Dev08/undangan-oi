<?php

return [
    // Product
    'product' => [
        'name' => 'Klinik Satriadharama Medika',
        'description' => 'Klinik Satriadharama Medika',
        'preview' => 'https://putrakuningan.com',
        'home' => 'https://putrakuningan.com',
        'purchase' => 'https://putrakuningan.com',
        'licenses' => [
            'terms' => 'https://themeforest.net/licenses/standard',
            'types' => [
                [
                    'title' => 'Regular License',
                    'description' => 'For single end product used by you or one client',
                    'tooltip' => 'Use, by you or one client in a single end product which end users are not charged for',
                    'price' => '39',
                ],
                [
                    'title' => 'Extended License',
                    'description' => 'For single SaaS app with paying users',
                    'tooltip' => 'Use, by you or one client, in a single end product which end users can be charged for.',
                    'price' => '939',
                ],
            ],
        ],
        'demos' => [
            'demo1' => [
                'title' => 'Demo 1',
                'description' => 'Default Dashboard',
                'published' => true,
                'thumbnail' => 'demos/demo1.png',
            ],
        ],
    ],

    // Meta
    'meta' => [
        'title' => 'Klinik Satriadharama Medika',
        'description' => '',
        'keywords' => '',
        'canonical' => '',
    ],

    // General
    'general' => [
        'website' => 'https://putrakuningan.com',
        'copyright' => 'https://putrakuningan.com',
        'about' => 'https://putrakuningan.com',
        'contact' => 'mailto:support@putrakuningan.com',
        'support' => 'https://putrakuningan.com/support',
        'bootstrap-docs-link' => 'https://getbootstrap.com/docs/5.0',
        'licenses' => 'https://putrakuningan.com',
        'social-accounts' => [
            [
                'name' => 'Youtube', 'url' => '#', 'logo' => 'svg/social-logos/youtube.svg', 'class' => 'h-20px',
            ],
            [
                'name' => 'Github', 'url' => '#', 'logo' => 'svg/social-logos/github.svg', 'class' => 'h-20px',
            ],
            [
                'name' => 'Twitter', 'url' => '#', 'logo' => 'svg/social-logos/twitter.svg', 'class' => 'h-20px',
            ],
            [
                'name' => 'Instagram', 'url' => '#', 'logo' => 'svg/social-logos/instagram.svg', 'class' => 'h-20px',
            ],

            [
                'name' => 'Facebook', 'url' => '#', 'logo' => 'svg/social-logos/facebook.svg', 'class' => 'h-20px',
            ],
            [
                'name' => 'Dribbble', 'url' => '#', 'logo' => 'svg/social-logos/dribbble.svg', 'class' => 'h-20px',
            ],
        ],
    ],

    // Layout
    'layout' => [
        // Docs
        'docs' => [
            'logo-path' => [
                'default' => 'logos/logo-klinik.png',
                'dark' => 'logos/logo-klinik.png',
            ],
            'logo-class' => 'h-25px',
        ],

        // Illustration
        'illustrations' => [
            'set' => 'sketchy-1',
        ],

        // Engage
        'engage' => [
            'demos' => [
                'enabled' => true,
                'direction' => 'end',
            ],
            'explore' => [
                'enabled' => true,
                'direction' => 'end',
            ],
            'help' => [
                'enabled' => true,
                'direction' => 'end',
            ],
            'purchase' => [
                'enabled' => true,
            ],
        ],
    ],

];
