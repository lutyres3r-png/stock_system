<?php

/**
 * Logout
 * STOCK SYSTEM
 */

require_once 'controllers/AuthController.php';

$auth = new AuthController();
$response = $auth->logout();

header('Location: ' . $response['redirect']);
exit();

?>