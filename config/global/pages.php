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
        'religions' => [
            '*' => [
                'title' => 'Religions',
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
        'genders' => [
            '*' => [
                'title' => 'Gender',
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
        'works' => [
            '*' => [
                'title' => 'Work',
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
        'educations' => [
            '*' => [
                'title' => 'Education',
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
        'bloodtypes' => [
            '*' => [
                'title' => 'Blood Type',
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
        'maritalstatuses' => [
            '*' => [
                'title' => 'Marital Status',
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
        'relationshipstatuses' => [
            '*' => [
                'title' => 'Relationship Status',
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
        'cardtypes' => [
            '*' => [
                'title' => 'Card Types',
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
        'countries' => [
            '*' => [
                'title' => 'Country',
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

        'provinces' => [
            '*' => [
                'title' => 'Province',
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
        'cities' => [
            '*' => [
                'title' => 'City',
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
        'districts' => [
            '*' => [
                'title' => 'District',
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
        'subdistricts' => [
            '*' => [
                'title' => 'Sub District',
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
        'odontogramsymbols' => [
            '*' => [
                'title' => 'Daftar Singkatan Odontogram',
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

    'pcare' => [
        'title' => 'PCare',
        'diagnosa' => [
            'title' => 'Diagnosa'
        ],
        'dokter' => [
            'title' => 'Dokter'
        ],
        'kesadaran' => [
            'title' => 'Kesadaran'
        ],
        'poli' => [
            'title' => 'Poli'
        ],
        'provider' => [
            'title' => 'Provider'
        ],
        'spesialis' => [
            'title' => 'Spesialis'
        ],
        'subspesialis' => [
            'title' => 'Sub Spesialis'
        ],
        'sarana' => [
            'title' => 'Sarana'
        ],

    ],

    'klinik' => [
        'healthprofesionals' => [
            'title' => 'Health Profesional',
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
        'patients' => [
            'title' => 'Patient',
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
        'healthcarecategories' => [
            '*' => [
                'title' => 'Healthcare Category',
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
        'healthcaretypes' => [
            '*' => [
                'title' => 'Healthcare Type',
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
        'healthcares' => [
            '*' => [
                'title' => 'Healthcare',
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
        'locations' => [
            '*' => [
                'title' => 'Location',
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
        'healthprofesionaltypes' => [
            '*' => [
                'title' => 'Health Profesional Type',
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
        'specialities' => [
            '*' => [
                'title' => 'Speciality',
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
        'diseases' => [
            '*' => [
                'title' => 'Disease',
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
        'examinations' => [
            '*' => [
                'title' => 'Examinations',
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
        'laboratoryexaminations' => [
            '*' => [
                'title' => 'Examinations',
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
        'appointments' => [
            '*' => [
                'title' => 'Appointments',
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
        'transactions' => [
            '*' => [
                'title' => 'Transactions',
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
            'create' => [
                'title' => 'Create Transaction',
                'assets' => [
                    'custom' => [
                        'js' => [
                            'js/custom/apps/invoices/create.js',
                        ],
                    ],
                ],
            ],
        ],
        'servicecategories' => [
            '*' => [
                'title' => 'Service Category',
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

        'services' => [
            '*' => [
                'title' => 'Service',
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

        'packages' => [
            '*' => [
                'title' => 'Package',
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

        'anamnesiscategories' => [
            '*' => [
                'title' => 'Service Category',
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

        'anamnesis' => [
            '*' => [
                'title' => 'Service',
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
        'physicalcategories' => [
            '*' => [
                'title' => 'Physical Category',
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

        'physicals' => [
            '*' => [
                'title' => 'Physical',
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
        'icdten' => [
            '*' => [
                'title' => 'ICD-10',
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
        'jenis-pasien' => [
            '*' => [
                'title' => 'Jenis Pasien',
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
        'personal-disease-histories' => [
            '*' => [
                'title' => 'Jenis Riwayat Penyakit Pribadi',
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
        'family-disease-histories' => [
            '*' => [
                'title' => 'Jenis Riwayat Penyakit Keluarga',
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

        'units' => [
            '*' => [
                'title' => 'Unit',
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

        'drugs' => [
            '*' => [
                'title' => 'Drug',
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
