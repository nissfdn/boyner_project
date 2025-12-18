<?php
session_start();

// Session içini boşalt
$_SESSION = [];

// Session cookie varsa onu da uçur
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Session'ı tamamen bitir
session_destroy();

// Index'e geri yolla
header("Location: index.php");
exit();
