<?php
if(session_status()==PHP_SESSION_NONE){
    session_start();
};

require 'utils/_db_connect.php';

if (!isset($_SESSION["logged-in"]) || !$_SESSION["logged-in"]) {
    header('Location: 404.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $new_username = $_POST['username'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];

    // Retrieve current values to compare
    $query = $mysql->prepare('SELECT * FROM `users` WHERE `username`=?');
    $query->bind_param('s', $username);
    $query->execute();
    $row = $query->get_result()->fetch_assoc();

    if ($row) {
        $changes = [];
        if ($row['first_name'] !== $first_name) $changes['first_name'] = $first_name;
        if ($row['last_name'] !== $last_name) $changes['last_name'] = $last_name;
        if ($row['username'] !== $new_username) $changes['username'] = $new_username;
        if ($row['mobile_number'] !== $mobile_number) $changes['mobile_number'] = (int)$mobile_number;
        if ($row['email'] !== $email) $changes['email'] = $email;

        if (!empty($changes)) {
            // Construct the update query dynamically
            $fields = [];
            $values = [];
            $types = '';

            foreach ($changes as $field => $value) {
                $fields[] = "`$field`=?";
                $values[] = $value;
                $types .= 's'; // Set type to 'i' for integer and 's' for string
            }

            $values[] = $username; // for the WHERE clause
            $types .= 's';

            $query_str = 'UPDATE `users` SET ' . implode(', ', $fields) . ' WHERE `username`=?';
            $query = $mysql->prepare($query_str);
            $query->bind_param($types, ...$values);

            try {
                $query->execute();
                // Check if the username was updated and update session
                if (isset($changes['username'])) {
                    $_SESSION['username'] = $new_username;
                }
                header('Location: profile.php'); // Redirect to the profile page after successful update
                exit();
            } catch (mysqli_sql_exception $e) {
                // Handle duplicate entry error or any other error
                if ($e->getCode() == 1062) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Duplicate entry for username. !
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                } else {
                    $error = "Error: " . $e->getMessage();
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>' . $e->getMessage(); '!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                }
            }
        } else {
            header('Location: profile.php'); // No changes made, redirect back to the profile page
            exit();
        }
    } else {
        $error = "Error: User not found.";
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> User Not Found !
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
}
