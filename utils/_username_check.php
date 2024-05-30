<?php

require '_db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['username'])) {
        $username = $_POST['username'];

        if (strlen($username) < 5) {
            echo '<span style="color: red;">Username must be greater than 5 characters.</span>';
        } else {

            $query_select = $mysql->prepare('SELECT * FROM `users` WHERE `username`=?');
            $query_select->bind_param('s', $username);
            $query_select->execute();
            $row = $query_select->get_result();
            $result_select = $row->num_rows;
            if ($result_select > 0) {
                echo '<span style="color: red;">Username already exists.</span>';
            } else {
                echo '<span style="color: green;">Good Username <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
            <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
          </svg></span>';
            }
        }
    } else if (isset($_POST['email'])) {
        $email = $_POST['email'];

        $query_select = $mysql->prepare('SELECT * FROM `users` WHERE `email`=?');
        $query_select->bind_param('s', $email);
        $query_select->execute();
        $row = $query_select->get_result();
        $result_select = $row->num_rows;
        if ($result_select > 0) {
            echo '<span style="color: red;">Another account is created with this email</span>';
        };
    } else if (isset($_POST['password'])) {
        $password = $_POST['password'];
        if (strlen($password) < 8) {
            echo '<span style="color: red;">Password should be at least 8 characters.</span>';
        }
    }
}
