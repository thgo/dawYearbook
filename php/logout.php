<?php

require_once("./authSession.php");

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );

    setcookie('loginAutomatico', '', time() - 42000);
    setcookie('ultimosVisitados', '', time() - 42000);
}
session_destroy();  // Destruímos a sessão em si
header("Location: ./index.php");  //redirecionando para a página principal
?>