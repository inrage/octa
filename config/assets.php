<?php

return [
    'default' => 'app',
    'manifests' => [
        'app' => [
            'path' => public_path('/build'),
            'url' => WP_HOME . '/build',
            'assets' => public_path('build/manifest.json'),
            'bundles' => public_path('build/manifest.json'),
        ],
    ],
];
