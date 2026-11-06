<?php
/**
 * Copy this file to mail-config.php and fill in your SMTP details to send
 * welcome emails. mail-config.php is ignored by git – never commit passwords.
 *
 * Gmail: turn on 2-Step Verification, then create an "App password" at
 * https://myaccount.google.com/apppasswords and use it as 'password'.
 */
return [
    'enabled'    => false,              // set to true once the details below are filled in
    'host'       => 'smtp.gmail.com',
    'port'       => 587,
    'secure'     => 'tls',              // 'tls' or 'ssl'
    'username'   => 'you@example.com',
    'password'   => 'your-app-password',
    'from_email' => 'you@example.com',
    'from_name'  => 'ClubHub',
];
