<?php

$routes = $_SESSION['role'] == 'admin' ? [
    [
        'name' => 'Dashboard',
        'path' => '../admin/',
    ],
    [
        'name' => 'Products',
        'path' => '../admin/products/',
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
        'path' => '../categories/',
    ],
    [
        'name' => 'Contact',
        'path' => '../contact-us/',
    ]
];
