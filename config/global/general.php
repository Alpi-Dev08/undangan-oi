<?php

return [
    // Product
    'product' => [
        'name' => 'Undangan Online',
        'description' => 'Undangan Online',
        'preview' => 'https://undanganonlineindonesia.com',
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
        'title' => 'Undangan Online',
        'description' => '',
        'keywords' => '',
        'canonical' => '',
    ],

    // General
    'general' => [
        'website' => 'https://undanganonlineindonesia.com',
        'copyright' => 'https://undanganonlineindonesia.com',
        'about' => 'https://undanganonlineindonesia.com',
        'contact' => 'mailto:support@kliniksatriabudi.com',
        'support' => 'https://undanganonlineindonesia.com/support',
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
                'default' => '',
                'dark' => '',
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
