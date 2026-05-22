<?php
// Clear the JWT session cookie
setcookie('silip_jwt', '', [
    'expires'  => time() - 3600,
    'path'     => '/',
    'httponly' => true,
    'samesite' => 'Lax',
]);

// Redirect to the main page (or a "logged out" page)
header('Location: /SILIP/public/');
exit;