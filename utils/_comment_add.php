<?php
include '_db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_SESSION['username'];

    $query_user = $mysql->prepare('SELECT * FROM `users` WHERE `username`=?');
    $query_user->bind_param('s', $username);
    $query_user->execute();
    $row_user = $query_user->get_result()->fetch_assoc();


    $thread_id = $_POST['thread_id'];
    $category_id = $_POST['category_id'];
    $comment_content = $_POST['comment_content'];

    $query_insert_comment = $mysql->prepare('INSERT INTO `comments` (`comment_txt`,`comment_user_id`,`comment_thread_id`) VALUES (?,?,?)');
    $query_insert_comment->bind_param('sii', $comment_content, $row_user['user_id'], $thread_id);

    $result = $query_insert_comment->execute();
    if ($result) {
        $redirect_url = "http://localhost/forum/threads.php?category_id=" . urlencode($category_id) . "&thread_id=" . urlencode($thread_id);
        header("Location: $redirect_url");

        echo '<div class="alert alert-success alert-dismissible fade show fixed-top" role="alert">
        <strong>Success !</strong>Comment Added successfully !
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        exit();
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show fixed-top" role="alert">
            <strong>System Error!</strong> Try Again !!!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
};
