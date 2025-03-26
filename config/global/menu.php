<?php

    return [

        // Main menu
        'main' => [
            //// Dashboard
            [
                'title' => 'Dashboard',
                'path' => '',
                'icon' => theme()->getSvgIcon('assets/media/icons/duotune/art/art002.svg', 'svg-icon-2'),
            ],

            // Account
            [
                'title' => 'Account',
                'icon' => [
                    'svg' => theme()->getSvgIcon('assets/media/icons/duotune/communication/com006.svg', 'svg-icon-2'),
                    'font' => '<i class="bi bi-person fs-2"></i>',
                ],
                'classes' => ['item' => 'menu-accordion'],
                'attributes' => [
                    'data-kt-menu-trigger' => 'click',
                ],
                'sub' => [
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => [
                        [
                            'title' => 'Overview',
                            'path' => 'account/overview',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                        [
                            'title' => 'Settings',
                            'path' => 'account/settings',
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

            [
                'title' => 'Registrasi', // Patients
                'path' => 'klinik/patients',
                'role' => ['admin', 'administrator','admin-perawat',],
                'icon' => theme()->getSvgIcon('assets/media/icons/duotune/communication/com014.svg', 'svg-icon-2'),
            ],
            [
                'title' => 'Appointment', // Patients
                'path' => 'klinik/appointments',
                'role' => ['admin', 'administrator','admin-perawat'],
                'icon' => theme()->getSvgIcon('assets/media/icons/duotune/general/gen014.svg', 'svg-icon-2'),
            ],
            [
                'title' => 'Vital Sign & BMI',
                'path' => 'klinik/examinations',
                'role' => ['ners', 'administrator','admin-perawat'],
                'icon' => theme()->getSvgIcon('assets/media/icons/duotune/medicine/med001.svg', 'svg-icon-2'),
            ],
            [
                'title' => 'Anamnesis & Physical Examination',
                'path' => 'klinik/examinations',
                'role' => ['dokter', 'administrator'],
                'icon' => theme()->getSvgIcon('assets/media/icons/duotune/general/gen005.svg', 'svg-icon-2'),
            ],
            [
                'title' => 'Pcare',
                'path' => 'pcare',
                'role' => ['dokter', 'administrator'],
                'icon' => theme()->getSvgIcon('assets/media/icons/duotune/general/gen005.svg', 'svg-icon-2'),
            ],
            [
                'title' => 'Laboratorium Examination',
                'path' => 'klinik/laboratoryexaminations',
                'role' => ['laboran', 'administrator'],
                'icon' => theme()->getSvgIcon('assets/media/icons/duotune/medicine/med004.svg', 'svg-icon-2'),
            ],
	    [
                'title' => 'Farmasi',
                'role' => ['farmasi', 'administrator'],
                'icon' => theme()->getSvgIcon('assets/media/icons/duotune/medicine/med002.svg', 'svg-icon-2'),
		'classes' => ['item' => 'menu-accordion'],
                'attributes' => [
                    'data-kt-menu-trigger' => 'click',
                ],
		'sub' => [
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => [
			[
                            'title' => 'Drug Units',
                            'path' => 'klinik/units',
                            'bullet' => '<span class="bullet bullet-dot"></span>'
                        ],
                        [
                            'title' => 'Drug',
                            'path' => 'klinik/drugs',
                            'bullet' => '<span class="bullet bullet-dot"></span>'
                        ],

		    ]
		]

            ],
            [
                'title' => 'Transactions',
                'path' => 'klinik/transactions',
                'role' => ['admin', 'administrator','admin-perawat'],
                'icon' => theme()->getSvgIcon('assets/media/icons/duotune/finance/fin007.svg', 'svg-icon-2'),
            ],

            //// User Management
            [
                'title' => 'User Management',
                'icon' => [
                    'svg' => theme()->getSvgIcon('assets/media/icons/duotune/general/gen051.svg', 'svg-icon-2'),
                    'font' => '<i class="bi bi-layers fs-3"></i>',
                ],
                'classes' => ['item' => 'menu-accordion'],
                'attributes' => [
                    'data-kt-menu-trigger' => 'click',
                ],
                'role' => ['administrator'],
                'sub' => [
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => [
                        [
                            'title' => 'Users',
                            'path' => 'users',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                        [
                            'title' => 'Practitioners',
                            'path' => 'klinik/healthprofesionals',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                        [
                            'title' => 'Roles',
                            'path' => 'roles',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                        [
                            'title' => 'Permissions',
                            'path' => 'permissions',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                    ],
                ],
            ],

            // Master Data
            [
                'title' => 'Klinik',
                'icon' => [
                    'svg' => theme()->getSvgIcon('assets/media/icons/duotune/general/gen010.svg', 'svg-icon-2'),
                    'font' => '<i class="bi bi-layers fs-3"></i>',
                ],
                'classes' => ['item' => 'menu-accordion'],
                'attributes' => [
                    'data-kt-menu-trigger' => 'click',
                ],
                //'permission' => ['klinik.read'],
                'role' => ['administrator', 'admin','admin-perawat'],
                'sub' => [
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => [
                        [
                            'title' => 'Organization',
                            'path' => 'klinik/organization',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['settings.read'],
                        ],
                        [
                            'title' => 'Locations',
                            'path' => 'klinik/locations',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['settings.read'],
                        ],
                        [
                            'title' => 'Healthcare Category',
                            'path' => 'klinik/healthcarecategories',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Healthcare Type',
                            'path' => 'klinik/healthcaretypes',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Healthcare',
                            'path' => 'klinik/healthcares',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Health Profesional Type',
                            'path' => 'klinik/healthprofesionaltypes',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Speciality',
                            'path' => 'klinik/specialities',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Disease',
                            'path' => 'klinik/diseases',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Service Category',
                            'path' => 'klinik/servicecategories',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Service',
                            'path' => 'klinik/services',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Package',
                            'path' => 'klinik/packages',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Anamnesis Category',
                            'path' => 'klinik/anamnesiscategories',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Anamnesis',
                            'path' => 'klinik/anamnesis',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Physical Category',
                            'path' => 'klinik/physicalcategories',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Physical',
                            'path' => 'klinik/physicals',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'ICD-10',
                            'path' => 'klinik/icdten',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Jenis Pasien',
                            'path' => 'klinik/jenis-pasien',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Jenis Riwayat Penyakit Pribadi',
                            'path' => 'klinik/personal-disease-histories',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ],
                        [
                            'title' => 'Jenis Riwayat Penyakit Keluarga',
                            'path' => 'klinik/family-disease-histories',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['klinik.read'],
                        ]
                    ],
                ],
            ],

            // Master Data
            [
                'title' => 'Master Data',
                'icon' => [
                    'svg' => theme()->getSvgIcon('assets/media/icons/duotune/abstract/abs029.svg', 'svg-icon-2'),
                    'font' => '<i class="bi bi-layers fs-3"></i>',
                ],
                'classes' => ['item' => 'menu-accordion'],
                'attributes' => [
                    'data-kt-menu-trigger' => 'click',
                ],
                'role' => ['administrator', 'admin','admin-perawat'],
                'permission' => ['masters.read'],
                'sub' => [
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => [
                        [
                            'title' => 'Religions',
                            'path' => 'masters/religions',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title' => 'Genders',
                            'path' => 'masters/genders',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title' => 'Works',
                            'path' => 'masters/works',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title' => 'Educations',
                            'path' => 'masters/educations',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title' => 'Blood Types',
                            'path' => 'masters/bloodtypes',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title' => 'Marital Statuses',
                            'path' => 'masters/maritalstatuses',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title' => 'Relationship Statuses',
                            'path' => 'masters/relationshipstatuses',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title' => 'Card Types',
                            'path' => 'masters/cardtypes',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title' => 'Country',
                            'path' => 'masters/countries',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title' => 'Province',
                            'path' => 'masters/provinces',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title' => 'City',
                            'path' => 'masters/cities',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title' => 'District',
                            'path' => 'masters/districts',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title' => 'Sub District',
                            'path' => 'masters/subdistricts',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                        [
                            'title' => 'Daftar Singkatan Odontogram',
                            'path' => 'masters/odontogramsymbols',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['masters.read'],
                        ],
                    ],
                ],
            ],

            // System
            [
                'title' => 'System',
                'icon' => [
                    'svg' => theme()->getSvgIcon('assets/media/icons/duotune/coding/cod001.svg', 'svg-icon-2'),
                    'font' => '<i class="bi bi-layers fs-3"></i>',
                ],
                'classes' => ['item' => 'menu-accordion'],
                'attributes' => [
                    'data-kt-menu-trigger' => 'click',
                ],
                'permission' => ['settings.read'],
                'sub' => [
                    'class' => 'menu-sub-accordion menu-active-bg',
                    'items' => [
                        [
                            'title' => 'General Setting',
                            'path' => 'setting',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['settings.read'],
                        ],
                        [
                            'title' => 'Audit Log',
                            'path' => 'log/audit',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'permission' => ['settings.read'],
                        ],
                        [
                            'title' => 'System Log',
                            'path' => 'log/system',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
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
                'title' => 'Dashboard',
                'path' => '',
                'classes' => ['item' => 'me-lg-1'],
            ],

            // Account
            [
                'title' => 'Account',
                'classes' => ['item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'],
                'attributes' => [
                    'data-kt-menu-trigger' => 'click',
                    'data-kt-menu-placement' => 'bottom-start',
                ],
                'sub' => [
                    'class' => 'menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px',
                    'items' => [
                        [
                            'title' => 'Overview',
                            'path' => 'account/overview',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                        [
                            'title' => 'Settings',
                            'path' => 'account/settings',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                        [
                            'title' => 'Security',
                            'path' => '#',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'attributes' => [
                                'link' => [
                                    'title' => 'Coming soon',
                                    'data-bs-toggle' => 'tooltip',
                                    'data-bs-trigger' => 'hover',
                                    'data-bs-dismiss' => 'click',
                                    'data-bs-placement' => 'right',
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // System
            [
                'title' => 'System',
                'classes' => ['item' => 'menu-lg-down-accordion me-lg-1', 'arrow' => 'd-lg-none'],
                'attributes' => [
                    'data-kt-menu-trigger' => 'click',
                    'data-kt-menu-placement' => 'bottom-start',
                ],
                'sub' => [
                    'class' => 'menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px',
                    'items' => [
                        [
                            'title' => 'Settings',
                            'path' => '#',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                            'attributes' => [
                                'link' => [
                                    'title' => 'Coming soon',
                                    'data-bs-toggle' => 'tooltip',
                                    'data-bs-trigger' => 'hover',
                                    'data-bs-dismiss' => 'click',
                                    'data-bs-placement' => 'right',
                                ],
                            ],
                        ],
                        [
                            'title' => 'Audit Log',
                            'path' => 'log/audit',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                        [
                            'title' => 'System Log',
                            'path' => 'log/system',
                            'bullet' => '<span class="bullet bullet-dot"></span>',
                        ],
                    ],
                ],
            ],
        ],
    ];
