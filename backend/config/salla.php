<?php

return [
    'client_id'      => env('SALLA_CLIENT_ID'),
    'client_secret'  => env('SALLA_CLIENT_SECRET'),
    'webhook_secret' => env('SALLA_WEBHOOK_SECRET'),
    'redirect_uri'   => env('APP_URL') . '/salla/callback',
];
