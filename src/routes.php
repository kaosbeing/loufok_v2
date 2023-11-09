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
        'script' => 'auth@logOut',
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
        'script' => 'admin@adminIndexPage',
    ],
    [
        'route' => ['/admin/nouveau'],
        'method' => 'GET',
        'script' => 'admin@adminNouveauPage',
    ],
    [
        'route' => ['/admin/nouveau'],
        'method' => 'POST',
        'script' => 'admin@NewLoufokerie',
    ],
    [
        'route' => ['/mon-espace'],
        'method' => 'GET',
        'script' => 'user@userIndexPage',
    ],
    [
        'route' => ['/mon-espace/participation'],
        'method' => 'GET',
        'script' => 'user@userParticipationPage',
    ],
    [
        'route' => ['/mon-espace/participation'],
        'method' => 'POST',
        'script' => 'user@userParticipation',
    ],
    [
        'route' => ['/mon-espace/historique'],
        'method' => 'GET',
        'script' => 'user@userHistoriquePage',
    ],
];
