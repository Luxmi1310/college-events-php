<?php
// Start the session to access it
session_start();

// Unset all session variables
$_SESSION = array();

// If you want to kill the session cookie as well (optional but recommended)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session
session_destroy();

// Redirect to login page with a logout message
header("Location: login.php?msg=logout_success");
exit();
?>