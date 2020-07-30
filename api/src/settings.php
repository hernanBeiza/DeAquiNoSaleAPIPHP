<?php
return [
    'settings' => [
        'origins' => [
            'http://localhost:4200',
            'http://www.deaquinosale.club',
            'https://www.deaquinosale.club',
            'https://api.deaquinosale.club',
        ],
        'origin' => 'https://www.deaquinosale.club', // set the origin allowed
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        'env' => 'LOCAL',

        'codification' => "HS256",     

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'deaquinosaleapi',
            'path' => __DIR__ . '/../logs/deaquinosale.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];