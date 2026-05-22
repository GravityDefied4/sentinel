<?php
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

$provider = new League\OAuth2\Client\Provider\Google([
    'clientId'     => $_ENV['GOOGLE_CLIENT_ID'],
    'clientSecret' => $_ENV['GOOGLE_CLIENT_SECRET'],
    'redirectUri'  => $_ENV['GOOGLE_REDIRECT_URI'],
]);

// Generate and store CSRF state token
$state = bin2hex(random_bytes(16));
setcookie('oauth_state', $state, [
    'expires'  => time() + 300,
    'path'     => '/',
    'httponly' => true,
    'samesite' => 'Lax',
]);

$authUrl = $provider->getAuthorizationUrl([
    'state'  => $state,
    'scope'  => ['openid', 'email', 'profile'],
]);

header('Location: ' . $authUrl);
exit;