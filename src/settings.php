<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        //Database settings
        'db' =>[
            'host' => 'localhost',
            'user' => 'root',
            'pass' => '',
            'dbname' => 'aparece'
        ],

        // Email settings
        'email' => [
            'Port' => 587,
            'Host' => 'smtp.gmail.com',
            'SMTPSecure' => 'tls',
            'SMTPAuth' => true,
            'Username' => '',
            'Password' => '',
            'setFrom' => ['admin@aparecefake.com.br', 'Fake Admin'],
            'addReplyTo' => ['replyto@aparecefake.com.br', 'Fake Admin Reply']
        ],
    ],
];

?>
