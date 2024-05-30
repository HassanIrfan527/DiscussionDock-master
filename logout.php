<?php

session_start();
session_unset();
session_destroy();
if (isset($_COOKIE['user_token']) && isset($_COOKIE['allow'])) {
    setcookie('user_token', '', time() - 3600, "/"); // Expire the cookie
    setcookie('allow', '', time() - 3600, "/"); // Expire the cookie
}
header("Location: index.php");
exit();

?>