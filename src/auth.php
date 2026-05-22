<?php
/**
 * auth.php — Drop `require_once __DIR__ . '/../src/auth.php';` at the top of
 * any src/ file you want to protect. On success, $GLOBALS['auth_user'] is
 * populated with the decoded JWT payload (sub, email, name, picture).
 */

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Bootstrap: autoload + .env (tolerates being called multiple times)
if (!defined('SILIP_BOOTSTRAP_DONE')) {
    define('SILIP_BOOTSTRAP_DONE', true);
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
}

function silip_require_auth(): object {
    $token = $_COOKIE['silip_jwt'] ?? '';

    if ($token === '') {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Unauthenticated', 'login_url' => '/SILIP/public/auth/login']);
        exit;
    }

    try {
        $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));
        $GLOBALS['auth_user'] = $decoded;
        return $decoded;
    } catch (\Throwable $e) {
        setcookie('silip_jwt', '', time() - 3600, '/', '', false, true);
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid or expired token', 'login_url' => '/SILIP/public/auth/login']);
        exit;
    }
}

// Immediately enforce auth for the file that included this.
silip_require_auth();