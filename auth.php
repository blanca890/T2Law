<?php
// Simple authentication guard
// Starts a session with secure cookie params and ensures a logged-in user exists.

$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'] ?? '',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If user is not logged in, redirect to login page
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
