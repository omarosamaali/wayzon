<?php
chdir('/var/www/wyns');
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
try {
    $user = App\Models\User::first();
    Illuminate\Support\Facades\Mail::to('fffyslaw@gmail.com')->send(new App\Mail\WelcomeMerchantMail($user, 'TestPass123'));
    echo 'SENT OK' . PHP_EOL;
} catch(Exception $e){
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
