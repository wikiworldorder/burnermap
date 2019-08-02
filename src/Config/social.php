<?php
return [
    'facebook' => [
        'clientid' => env('FB_CLIENT_ID', ''),
        'clientsecret' => env('FB_CLIENT_SECRET', ''),
        'redirect' => env('FB_REDIRECT', 'https://burnermap.com/login/facebook/callback'),
        'domain' => env('SESSION_DOMAIN', 'burnermap.com'),
        'admins' => env('BURNER_ADMINS')
    ]
];
?>