<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Branding & Identitas Rumah Sakit (SIMRS RSU Rajawali Citra)
    |--------------------------------------------------------------------------
    */
    'app_name' => env('SIMRS_APP_NAME', 'SIMRS RSU Rajawali Citra'),
    'app_title_suffix' => env('SIMRS_TITLE_SUFFIX', 'SIMRS'),
    'hospital_name' => env('SIMRS_HOSPITAL_NAME', 'RSU Rajawali Citra'),
    'hospital_type' => env('SIMRS_HOSPITAL_TYPE', 'Rumah Sakit Umum 24 Jam'),
    'address' => env('SIMRS_HOSPITAL_ADDRESS', 'Jl. Pleret No.KM 2.5, Banjardadap, Potorono, Kec. Banguntapan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55196'),
    'phone' => env('SIMRS_HOSPITAL_PHONE', '0821-3431-3535'),
    'email' => env('SIMRS_HOSPITAL_EMAIL', 'info@rsurajawalicitra.co.id'),
    'website' => env('SIMRS_HOSPITAL_WEBSITE', 'https://rsurajawalicitra.co.id'),
    'hours' => 'Open 24 hours (Buka 24 Jam)',
    'province' => 'Daerah Istimewa Yogyakarta',
    'version' => 'v4.2.0 Enterprise',
    'copyright' => '© '.date('Y').' SIMRS RSU Rajawali Citra. Hak Cipta Dilindungi Undang-Undang.',

    /*
    |--------------------------------------------------------------------------
    | Informasi Developer & Pengembang
    |--------------------------------------------------------------------------
    */
    'developer' => [
        'name' => 'Rivan Alamsyah',
        'email' => 'alamsyahrivan14@gmail.com',
        'portfolio' => 'https://rivanalamsyah.netlify.app',
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO & Accessibility Defaults
    |--------------------------------------------------------------------------
    */
    'seo' => [
        'default_title' => 'SIMRS | Sistem Informasi Manajemen Rumah Sakit',
        'meta_description' => 'Sistem Informasi Manajemen Rumah Sakit (SIMRS) RSU Rajawali Citra — Platform Pelayanan Kesehatan Terpadu, Modern, & Handal.',
        'meta_author' => 'Rivan Alamsyah (alamsyahrivan14@gmail.com - https://rivanalamsyah.netlify.app)',
        'meta_robots' => 'noindex, nofollow', // Internal Hospital System
    ],
];
