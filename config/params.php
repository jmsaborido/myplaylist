<?php

return [
    'bsVersion' => '4.x',
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'smtpUsername' => 'myplaylist.web@gmail.com',
    'igdb' => [
        'key' => getenv('apiKey'),
        'url' => 'https://api-v3.igdb.com',
        'cache' => 5
    ]
];
