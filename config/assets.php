<?php

return [
    'default' => 'app',
    'manifests' => [
        'app' => [
            'path' => public_path('/dist'),
            'url' => WP_HOME . '/dist',
            'assets' => public_path('dist/manifest.json'),
            'bundles' => public_path('dist/entrypoints.json'),
        ],
    ],
];
