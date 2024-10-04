<?php

return [
    'user_token_ttl' => env('TBP_USER_TOKEN_TTL_IN_DAYS', 30),
    'pronouns' => [
        'none' => [
            'name' => 'None',
            'translation_key' => 'None',
            'slug' => 'none',
        ],
        'he-him' => [
            'name' => 'He/Him',
            'translation_key' => 'HeHim',
            'slug' => 'he-him',
        ],
        'she-her' => [
            'name' => 'She/Her',
            'translation_key' => 'SheHer',
            'slug' => 'she-her',
        ],
        'they-them' => [
            'name' => 'They/Them',
            'translation_key' => 'TheyThem',
            'slug' => 'they-them',
        ],
        'she-they' => [
            'name' => 'She/They',
            'translation_key' => 'SheThey',
            'slug' => 'she-they',
        ],
        'he-they' => [
            'name' => 'He/They',
            'translation_key' => 'HeThey',
            'slug' => 'he-they',
        ],
        'he-she' => [
            'name' => 'He/She',
            'translation_key' => 'HeShe',
            'slug' => 'he-she',
        ],
        'xe-xem' => [
            'name' => 'Xe/Xem',
            'translation_key' => 'XeXem',
            'slug' => 'xe-xem',
        ],
        'it-its' => [
            'name' => 'It/Its',
            'translation_key' => 'ItIts',
            'slug' => 'it-its',
        ],
        'fae-faer' => [
            'name' => 'Fae/Faer',
            'translation_key' => 'FaeFaer',
            'slug' => 'fae-faer',
        ],
        've-ver' => [
            'name' => 'Ve/Ver',
            'translation_key' => 'VeVer',
            'slug' => 've-ver',
        ],
        'ae-aer' => [
            'name' => 'Ae/Aer',
            'translation_key' => 'AeAer',
            'slug' => 'ae-aer',
        ],
        'zie-hir' => [
            'name' => 'Zie/Hir',
            'translation_key' => 'ZieHir',
            'slug' => 'zie-hir',
        ],
        'per-per' => [
            'name' => 'Per/Per',
            'translation_key' => 'PerPer',
            'slug' => 'per-per',
        ],
        'e-em' => [
            'name' => 'E/Em',
            'translation_key' => 'EEm',
            'slug' => 'e-em',
        ],
    ],
    'occupations' => [
        [
            'name' => 'None',
            'slug' => 'none',
            'translation_key' => 'None',
        ],
        [
            'name' => 'Student',
            'slug' => 'student',
            'translation_key' => 'Student',
        ],
        [
            'name' => 'Lawyer',
            'slug' => 'lawyer',
            'translation_key' => 'Lawyer',
        ],
        [
            'name' => 'Doctor',
            'slug' => 'doctor',
            'translation_key' => 'Doctor',
        ],
        [
            'name' => 'Civil Engineer',
            'slug' => 'civil-engineer',
            'translation_key' => 'CivilEngineer',
        ],
        [
            'name' => 'Front End Engineer',
            'slug' => 'frontend-engineer',
            'translation_key' => 'FrontEndEngineer',
        ],
        [
            'name' => 'SRE Engineer',
            'slug' => 'sre-engineer',
            'translation_key' => 'SreEngineer',
        ],
        [
            'name' => 'Back End Engineer',
            'slug' => 'backend-engineer',
            'translation_key' => 'BackEndEngineer',
        ],
        [
            'name' => 'Fullstack Engineer',
            'slug' => 'fullstack-engineer',
            'translation_key' => 'FullstackEngineer',
        ],
        [
            'name' => 'UX/UI Designer',
            'slug' => 'uxui-designer',
            'translation_key' => 'UxUiDesigner',
        ],
    ],
    'colors' => [
        'none' => [
            'name' => 'None',
            'slug' => 'none',
            'translation_key' => 'None',
            'hex' => '#000',
        ],
        'brown' => [
            'name' => 'Brown',
            'slug' => 'brown',
            'translation_key' => 'Brown',
            'hex' => '#8B4513',
        ],
        'crimson' => [
            'name' => 'Crimson',
            'slug' => 'crimson',
            'translation_key' => 'Crimson',
            'hex' => '#DC143C',
        ],
        'purple' => [
            'name' => 'Purple',
            'slug' => 'purple',
            'translation_key' => 'Purple',
            'hex' => '#800080',
        ],
        'royal-blue' => [
            'name' => 'Royal Blue',
            'slug' => 'royal-blue',
            'translation_key' => 'RoyalBlue',
            'hex' => '#4169E1',
        ],
    ],
    'effects' => [
        'none' => [
            'name' => 'None',
            'slug' => 'none',
            'translation_key' => 'None',
            'hex' => null,
            'class_name' => 'none',
            'raw_css' => <<<'CSS'
            .none {}
            CSS
        ],
        'glow-purple' => [
            'name' => 'Glow Purple',
            'slug' => 'glow-purple',
            'translation_key' => 'GlowPurple',
            'class_name' => 'glow-purple',
            'hex' => '#FFD700',
            'raw_css' => <<<'CSS'
            .glow-purple {
                text-align: center;
                -webkit-animation: glow-purple 1s ease-in-out infinite alternate;
                -moz-animation: glow-purple 1s ease-in-out infinite alternate;
                animation: glow-purple 1s ease-in-out infinite alternate;
            }


            @-webkit-keyframes glow-purple {
                from {
                    text-shadow: 0 0 2px rgb(170, 100, 234), 0 0 2px rgb(170, 100, 234), 0 0 5px rgb(170, 100, 234), 0 0 7px rgb(170, 100, 234), 0 0 9px rgb(170, 100, 234), 0 0 12px rgb(170, 100, 234), 0 0 15px rgb(170, 100, 234);
                }
                to {
                    text-shadow: 0 0 2px rgb(170, 100, 234), 0 0 5px rgb(170, 100, 234), 0 0 7px rgb(170, 100, 234), 0 0 9px rgb(170, 100, 234), 0 0 12px rgb(170, 100, 234), 0 0 15px rgb(170, 100, 234), 0 0 15px rgb(170, 100, 234);
                }
            }
            CSS
        ],
        'default-gradient' => [
            'name' => 'Default Gradient',
            'slug' => 'default-gradient',
            'translation_key' => 'DefaultGradient',
            'class_name' => 'gradient-default',
            'hex' => '#FFD700',
            'raw_css' => <<<'CSS'
            .gradient-default {
              background: linear-gradient(90deg, #FF6D1B, #FFEE55, #5BFF89, #4D8AFF, #6B5FFF, #FF64F9, #FF6565);
              -webkit-background-clip: text;
              -webkit-text-fill-color: transparent;
              -webkit-animation: gradient-default-animate 2s infinite linear;
              -moz-animation: gradient-default-animate 2s infinite linear;
              background-size: 200%;
              animation: gradient-default-animate 2s infinite linear;
            }

            @-webkit-keyframes gradient-default-animate {
              0% {background-position: 0;}
              100% {background-position: 200%;}
            }
            CSS
        ],
    ],
];
