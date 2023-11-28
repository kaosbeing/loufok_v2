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
        'route' => ['/mon-espace/loufokerie'],
        'method' => 'GET',
        'script' => 'user@userLoufokeriePage',
    ],
    [
        'route' => ['/mon-espace/loufokerie'],
        'method' => 'POST',
        'script' => 'user@userSubmission',
    ],
    [
        'route' => ['/mon-espace/historique'],
        'method' => 'GET',
        'script' => 'user@userHistoriquePage',
    ],
    [
        'route' => ['/api/loufokerie/all'],
        'method' => 'GET',
        'script' => 'api@allLoufokeries',
    ],
    [
        'route' => ['/api/loufokerie/{int:id}'],
        'method' => 'GET',
        'script' => 'api@loufokerie',
    ],
    [
        'route' => ['/api/like/{int:id}'],
        'method' => 'POST',
        'script' => 'api@like',
    ],
];
