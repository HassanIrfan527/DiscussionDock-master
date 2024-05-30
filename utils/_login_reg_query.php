<?php
function generateToken($length = 60)
{
  return bin2hex(random_bytes($length));
}
require '_db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


  if ($_POST['action'] == 'register') {

    // Register script
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    $username = $_POST['username'];
    $query = $mysql->prepare('INSERT INTO `users` (`username`,`email`,`password`) VALUES (?,?,?)');
    $query->bind_param('sss', $username, $email, $password_hashed);


    $result = $query->execute();
    if ($result) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your account is created !
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      };
      $_SESSION['logged-in'] = true;
      $_SESSION['username'] = $username;
      $_SESSION['email'] = $email;
      $token = generateToken();
      setcookie('user_token', $token, time() + (86400 * 30), "/", "", true, true); // 30 days expiry, HttpOnly and Secure flags
      header('Location: '.$_SERVER['REQUEST_URI']);
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>System Error !!!</strong>  Our engineer has been notified
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
  } else if ($_POST['action'] == 'login') {
    $email = $_POST['email-login'];
    $password = $_POST['password-login'];

    $query = $mysql->prepare('SELECT * FROM `users` WHERE `email`=?');
    $query->bind_param('s', $email);
    $query->execute();
    $row = $query->get_result();
    while ($result = $row->fetch_assoc()) {
      if (password_verify($password, $result['password'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong>  Logged in successfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        if (session_status() === PHP_SESSION_NONE) {
          session_start();
        };
        $_SESSION['logged-in'] = true;
        $_SESSION['username'] = $result['username'];
        $_SESSION['email'] = $email;
        $token = generateToken();
        setcookie('user_token', $token, time() + (86400 * 30), "/", "", true, true); // 30 days expiry, HttpOnly and Secure flags

        $updateQuery = $mysql->prepare('UPDATE `users` SET `user_token`=? WHERE `username`=?');
        $updateQuery->bind_param('ss', $token, $result['username']);
        $updateQuery->execute();
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
      } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>System Error !!!</strong>  Please Try Again ! Our Engineer has been notified
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
      }
    }
  };
}
