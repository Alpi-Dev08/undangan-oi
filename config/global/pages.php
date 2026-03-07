<?php

return [
    '' => [
        'title' => 'Dashboard',
        'description' => '',
        'view' => 'index',
        'layout' => [
            'page-title' => [
                'description' => false,
                'breadcrumb' => false,
            ],
        ],
        'assets' => [
            'custom' => [
                'js' => [],
            ],
        ],
    ],

    'login' => [
        'title' => 'Login',
        'assets' => [
            'custom' => [
                'js' => [
                    'js/custom/authentication/sign-in/general.js',
                ],
            ],
        ],
        'layout' => [
            'main' => [
                'type' => 'blank', // Set blank layout
                'body' => [
                    'class' => theme()->isDarkMode() ? '' : 'bg-body',
                ],
            ],
        ],
    ],
    'register' => [
        'title' => 'Register',
        'assets' => [
            'custom' => [
                'js' => [
                    'js/custom/authentication/sign-up/general.js',
                ],
            ],
        ],
        'layout' => [
            'main' => [
                'type' => 'blank', // Set blank layout
                'body' => [
                    'class' => theme()->isDarkMode() ? '' : 'bg-body',
                ],
            ],
        ],
    ],
    'forgot-password' => [
        'title' => 'Forgot Password',
        'assets' => [
            'custom' => [
                'js' => [
                    'js/custom/authentication/password-reset/password-reset.js',
                ],
            ],
        ],
        'layout' => [
            'main' => [
                'type' => 'blank', // Set blank layout
                'body' => [
                    'class' => theme()->isDarkMode() ? '' : 'bg-body',
                ],
            ],
        ],
    ],

    'log' => [
        'audit' => [
            'title' => 'Audit Log',
            'assets' => [
                'custom' => [
                    'css' => [
                        'plugins/custom/datatables/datatables.bundle.css',
                    ],
                    'js' => [
                        'plugins/custom/datatables/datatables.bundle.js',
                    ],
                ],
            ],
        ],
        'system' => [
            'title' => 'System Log',
            'assets' => [
                'custom' => [
                    'css' => [
                        'plugins/custom/datatables/datatables.bundle.css',
                    ],
                    'js' => [
                        'plugins/custom/datatables/datatables.bundle.js',
                    ],
                ],
            ],
        ],
    ],

    'account' => [
        'overview' => [
            'title' => 'Account Overview',
            'view' => 'account/overview/overview',
            'assets' => [
                'custom' => [
                    'js' => [
                        'js/custom/widgets.js',
                    ],
                ],
            ],
        ],

        'settings' => [
            'title' => 'Account Settings',
            'assets' => [
                'custom' => [
                    'js' => [
                        'js/custom/account/settings/profile-details.js',
                        'js/custom/account/settings/signin-methods.js',
                        'js/custom/modals/two-factor-authentication.js',
                    ],
                ],
            ],
        ],
    ],

    'users' => [
        'title' => 'Users',
        'assets' => [
            'custom' => [
                'css' => [
                    'plugins/custom/datatables/datatables.bundle.css',
                ],
                'js' => [
                    'plugins/custom/datatables/datatables.bundle.js',
                ],
            ],
        ],
    ],

    'roles' => [
        'title' => 'Roles',
        'assets' => [
            'custom' => [
                'css' => [
                    'plugins/custom/datatables/datatables.bundle.css',
                ],
                'js' => [
                    'plugins/custom/datatables/datatables.bundle.js',
                ],
            ],
        ],
    ],

    'permissions' => [
        'title' => 'Permissions',
        'assets' => [
            'custom' => [
                'css' => [
                    'plugins/custom/datatables/datatables.bundle.css',
                ],
                'js' => [
                    'plugins/custom/datatables/datatables.bundle.js',
                ],
            ],
        ],
    ],

    'masters' => [
        'kategori_web' => [
            '*' => [
                'title' => 'Kategori',
            ],
            'assets' => [ 
                'custom' => [
                    'css' => [
                        'plugins/custom/datatables/datatables.bundle.css',
                    ],
                    'js' => [
                        'plugins/custom/datatables/datatables.bundle.js',
                    ],
                ],
            ],
        ], 
        'kategori_video' => [
            '*' => [
                'title' => 'Kategori',
            ],
            'assets' => [
                'custom' => [
                    'css' => [
                        'plugins/custom/datatables/datatables.bundle.css',
                    ],
                    'js' => [
                        'plugins/custom/datatables/datatables.bundle.js',
                    ],
                ],
            ],
        ],  
        'template_web' => [
            '*' => [
                'title' => 'Template',
            ],
            'assets' => [
                'custom' => [
                    'css' => [
                        'plugins/custom/datatables/datatables.bundle.css',
                    ],
                    'js' => [
                        'plugins/custom/datatables/datatables.bundle.js',
                    ],
                ],
            ],
        ], 
        'template_video' => [
            '*' => [
                'title' => 'Template',
            ],
            'assets' => [
                'custom' => [
                    'css' => [
                        'plugins/custom/datatables/datatables.bundle.css',
                    ],
                    'js' => [
                        'plugins/custom/datatables/datatables.bundle.js',
                    ],
                ],
            ],
        ], 
        'fitur' => [ 
            '*' => [ 
                'title' => 'Fitur',
            ],
            'assets' => [
                'custom' => [
                    'css' => [
                        'plugins/custom/datatables/datatables.bundle.css',
                    ],
                    'js' => [
                        'plugins/custom/datatables/datatables.bundle.js',
                    ],
                ],
            ],
        ], 
        'paket' => [ 
            '*' => [ 
                'title' => 'Paket',
            ],
            'assets' => [
                'custom' => [
                    'css' => [
                        'plugins/custom/datatables/datatables.bundle.css',
                    ],
                    'js' => [
                        'plugins/custom/datatables/datatables.bundle.js',
                    ],
                ],
            ],
        ], 
    ],
];
