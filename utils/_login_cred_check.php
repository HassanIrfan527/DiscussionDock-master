<?php

require '_db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['password'])) {
        $password = $_POST['password'];
        $email = $_POST['email'];
        $query = $mysql->prepare('SELECT * FROM `users` WHERE `email`=?');
        $query->bind_param('s', $email);
        $query->execute();
        $row = $query->get_result();
        while ($result = $row->fetch_assoc()) {
            if (password_verify($password, $result['password'])) {
                echo '<span style="color: green;">Password Matched</span>';
            } else {
                echo '<span style="color: red;">Incorrect Password</span>';

            }
        }
    }
}
?>