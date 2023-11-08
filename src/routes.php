<?php

$routes = [
    [
        'route' => ['/', '/login'],
        'method' => 'GET',
        'script' => 'auth@loginPage',
    ],
    [
        'route' => ['/', '/login'],
        'method' => 'POST',
        'script' => 'auth@logIn',
    ],
    [
        'route' => ['/logout'],
        'method' => 'GET',
        'script' => '',
    ],
    [
        'route' => ['/404'],
        'method' => 'GET',
        'script' => '',
    ],
    [
        'route' => ['/403'],
        'method' => 'GET',
        'script' => '',
    ],
    [
        'route' => ['/admin'],
        'method' => 'GET',
        'script' => '',
    ],
    [
        'route' => ['/admin/nouveau'],
        'method' => 'GET',
        'script' => '',
    ],
    [
        'route' => ['/admin/nouveau'],
        'method' => 'POST',
        'script' => '',
    ],
    [
        'route' => ['/mon-espace'],
        'method' => 'GET',
        'script' => '',
    ],
    [
        'route' => ['/mon-espace/participation'],
        'method' => 'GET',
        'script' => '',
    ],
    [
        'route' => ['/mon-espace/participation'],
        'method' => 'POST',
        'script' => '',
    ],
    [
        'route' => ['/mon-espace/historique'],
        'method' => 'GET',
        'script' => '',
    ],
];
