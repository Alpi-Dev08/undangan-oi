<?php

    return [

        // Main menu
        'main'       => [
            //// Dashboard
            [
                'title' => 'Dashboard',
                'path'  => '',
                'icon'  => theme()->getSvgIcon('assets/media/icons/duotune/art/art002.svg', 'svg-icon-2'),
            ],

            // Account
            [
                'title'      => 'Account',
                'icon'       => [
                    'svg'  => theme()->getSvgIcon('assets/media/icons/duotune/communication/com006.svg', 'svg-icon-2'),
                    'font' => '<i class="bi bi-person fs-2"></i>',
                ],
                'classes'    => ['item' => 'menu-accordion'],
                'attributes' => [
                    'data-kt-menu-trigger' => 'click',
                ],
                'sub'        => [
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => [
                        [
                            'title'  => 'Overview',
                            'path'   => 'account/overview',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                        [
                            'title'  => 'Settings',
                            'path'   => 'account/settings',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                    ],
                ],
            ],

            //// Modules
            [
                'classes' => ['content' => 'pt-8 pb-2'],
                'content' => '<span class="menu-section text-muted text-uppercase fs-8 ls-1">Modules</span>',
            ],

            // [
            //     'title' => 'Registrasi', // Patients
            //     'path'  => '#',
            //     'role'  => ['admin', 'administrator', 'admin-perawat',],
            //     'icon'  => theme()->getSvgIcon('assets/media/icons/duotune/communication/com014.svg', 'svg-icon-2'),
            // ],
            [
                'title' => 'Data Pembayaran',
                'path'  => '#',
                'role'  => ['admin', 'administrator', 'admin-perawat'],
                'icon'  => theme()->getSvgIcon('assets/media/icons/duotune/finance/fin007.svg', 'svg-icon-2'),
            ],

            [
                'title' => 'Data Customer',
                'path'  => '#',
                'role'  => ['admin', 'administrator', 'admin-perawat'],
                'icon'  => theme()->getSvgIcon('assets/media/icons/duotune/finance/fin007.svg', 'svg-icon-2'),
            ],
            
            [
                'title' => 'Manage Undangan',
                'path'  => '#',
                'role'  => ['admin', 'administrator', 'admin-perawat'],
                'icon'  => theme()->getSvgIcon('assets/media/icons/duotune/finance/fin007.svg', 'svg-icon-2'),
            ],

            //// Data Pengguna
            // [
            //     'title'      => 'Data Pengguna',
            //     'icon'       => [
            //         'svg'  => theme()->getSvgIcon('assets/media/icons/duotune/general/gen051.svg', 'svg-icon-2'),
            //         'font' => '<i class="bi bi-layers fs-3"></i>',
            //     ],
            //     'classes'    => ['item' => 'menu-accordion'],
            //     'attributes' => [
            //         'data-kt-menu-trigger' => 'click',
            //     ],
            //     'role'       => ['administrator'],
            //     'sub'        => [
            //         'class' => 'menu-sub-accordion menu-active-bg',
            //         'items' => [
            //             [
            //                 'title'  => 'Users',
            //                 'path'   => 'users',
            //                 'bullet' => '<span class="bullet bullet-dot"></span>',
            //             ],
            //             [
            //                 'title'  => 'Practitioners',
            //                 'path'   => 'klinik/healthprofesionals',
            //                 'bullet' => '<span class="bullet bullet-dot"></span>',
            //             ],
            //             [
            //                 'title'  => 'Roles',
            //                 'path'   => 'roles',
            //                 'bullet' => '<span class="bullet bullet-dot"></span>',
            //             ],
            //             [
            //                 'title'  => 'Permissions',
            //                 'path'   => 'permissions',
            //                 'bullet' => '<span class="bullet bullet-dot"></span>',
            //             ],
            //         ],
            //     ],
            // ],

            // Undangan Website
            [
                'title'      => 'Undangan Website',
                'icon'       => [
                    'svg'  => theme()->getSvgIcon('assets/media/icons/duotune/abstract/abs029.svg', 'svg-icon-2'),
                    'font' => '<i class="bi bi-layers fs-3"></i>',
                ],
                'classes'    => ['item' => 'menu-accordion'],
                'attributes' => [
                    'data-kt-menu-trigger' => 'click',
                ],
                'role'       => ['administrator', 'admin', 'admin-perawat'],
                'permission' => ['masters.read'],
                'sub'        => [
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => [
                        [
                            'title'      => 'Kategori',
                            'path'       => 'klinik/kategori-undangan',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title'      => 'Tema',
                            'path'       => '#',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                    ],
                ],
            ],

            // Undangan Video
            [
                'title'      => 'Undangan Video',
                'icon'       => [
                    'svg'  => theme()->getSvgIcon('assets/media/icons/duotune/abstract/abs029.svg', 'svg-icon-2'),
                    'font' => '<i class="bi bi-layers fs-3"></i>',
                ],
                'classes'    => ['item' => 'menu-accordion'],
                'attributes' => [
                    'data-kt-menu-trigger' => 'click',
                ],
                'role'       => ['administrator', 'admin', 'admin-perawat'],
                'permission' => ['masters.read'],
                'sub'        => [
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => [
                        [
                            'title'      => 'Kategori',
                            'path'       => '#',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title'      => 'Tema',
                            'path'       => '#',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                    ],
                ],
            ],
            
            // Paket Undangan
            [
                'title'      => 'Paket Undangan',
                'icon'       => [
                    'svg'  => theme()->getSvgIcon('assets/media/icons/duotune/abstract/abs029.svg', 'svg-icon-2'),
                    'font' => '<i class="bi bi-layers fs-3"></i>',
                ],
                'classes'    => ['item' => 'menu-accordion'],
                'attributes' => [
                    'data-kt-menu-trigger' => 'click',
                ],
                'role'       => ['administrator', 'admin', 'admin-perawat'],
                'permission' => ['masters.read'],
                'sub'        => [
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => [
                        [
                            'title'      => 'Paket 1',
                            'path'       => '#',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title'      => 'Paket 2',
                            'path'       => '#',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],

                        [
                            'title'      => 'Paket 3',
                            'path'       => '#',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                    ],
                ],
            ],

            // System
            [
                'title'      => 'System',
                'icon'       => [
                    'svg'  => theme()->getSvgIcon('assets/media/icons/duotune/coding/cod001.svg', 'svg-icon-2'),
                    'font' => '<i class="bi bi-layers fs-3"></i>',
                ],
                'classes'    => ['item' => 'menu-accordion'],
                'attributes' => [
                    'data-kt-menu-trigger' => 'click',
                ],
                'permission' => ['settings.read'],
                'sub'        => [
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => [
                        [
                            'title'      => 'General Setting',
                            'path'       => 'setting',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['settings.read'],
                        ],
                        [
                            'title'      => 'Audit Log',
                            'path'       => 'log/audit',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['settings.read'],
                        ],
                        [
                            'title'      => 'System Log',
                            'path'       => 'log/system',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['settings.read'],
                        ],
                    ],
                ],
            ],

        ],

        // Horizontal menu
        'horizontal' => [
            // Dashboard
            [
                'title'   => 'Dashboard',
                'path'    => '',
                'classes' => ['item' => 'me-lg-1'],
            ],

            // Account
            [
                'title'      => 'Account',
                'classes'    => ['item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'],
                'attributes' => [
                    'data-kt-menu-trigger'   => 'click',
                    'data-kt-menu-placement' => 'bottom-start',
                ],
                'sub'        => [
                    'class' => 'menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px',
                    'items' => [
                        [
                            'title'  => 'Overview',
                            'path'   => 'account/overview',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                        [
                            'title'  => 'Settings',
                            'path'   => 'account/settings',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                        [
                            'title'      => 'Security',
                            'path'       => '#',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                            'attributes' => [
                                'link' => [
                                    'title'             => 'Coming soon',
                                    'data-bs-toggle'    => 'tooltip',
                                    'data-bs-trigger'   => 'hover',
                                    'data-bs-dismiss'   => 'click',
                                    'data-bs-placement' => 'right',
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // System
            [
                'title'      => 'System',
                'classes'    => ['item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'],
                'attributes' => [
                    'data-kt-menu-trigger'   => 'click',
                    'data-kt-menu-placement' => 'bottom-start',
                ],
                'sub'        => [
                    'class' => 'menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px',
                    'items' => [
                        [
                            'title'      => 'Settings',
                            'path'       => '#',
                            'bullet'     => '<span class="bullet bullet-dot"></span>',
                            'attributes' => [
                                'link' => [
                                    'title'             => 'Coming soon',
                                    'data-bs-toggle'    => 'tooltip',
                                    'data-bs-trigger'   => 'hover',
                                    'data-bs-dismiss'   => 'click',
                                    'data-bs-placement' => 'right',
                                ],
                            ],
                        ],
                        [
                            'title'  => 'Audit Log',
                            'path'   => 'log/audit',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                        [
                            'title'  => 'System Log',
                            'path'   => 'log/system',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                    ],
                ],
            ],
        ],
    ];
