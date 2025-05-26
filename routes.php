<?php

$routes = $_SESSION['role'] == 'admin' ? [
    [
        'name' => 'Dashboard',
        'path' => '../admin/',
    ],
    [
        'name' => 'Produk',
        'path' => '../admin_product/',
    ],
    [
        'name' => 'Pesanan',
        'path' => '../admin_pesanan/',
    ],
] : [
    [
        'name' => 'Home',
        'path' => '../home/',
    ],
    [
        'name' => 'Store',
        'path' => '../store/',
    ],
    [
        'name' => 'Products',
        'path' => '../products/',
    ],
    [
        'name' => 'Categories',
        'path' => [
            [
                'name' => 'Kitcken',
                'path' => '../kitcken/',
            ],
            [
                'name' => 'Bedroom',
                'path' => '../bedroom/',
            ],
            [
                'name' => 'Living room',
                'path' => '../living-room/',
            ],
        ],
    ],
    [
        'name' => 'Contact',
        'path' => '../contact-us/',
    ]
];
