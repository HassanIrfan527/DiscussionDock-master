<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussions in Threads | Discussion-Dock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="resources/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="resources/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="resources/favicon-16x16.png">
    <link rel="manifest" href="resources/site.webmanifest">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Poppins", "Montserrat", sans-serif;

        }
    </style>
</head>

<body>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    };
    require 'utils/_db_connect.php';
    require 'utils/_login_reg_query.php';
    require 'utils/_header.php';
    include 'utils/_sign_form.php';
    include 'utils/_login_form.php';

    ?>


    <?php


    if (isset($_GET['category_id']) && isset($_GET['thread_id'])) :
        $category_id = $_GET['category_id'];
        $thread_id = $_GET['thread_id'];
        $query = $mysql->prepare('SELECT * FROM `threads` WHERE `thread_id`=?');
        $query->bind_param('s', $thread_id);
        $query->execute();
        $row = $query->get_result()->fetch_assoc();

        $datetimeThread = $row['date_created'];
        $dateThread = new DateTime($datetimeThread);

        // Format the date to display only day, month, and year
        $formattedDateThread = $dateThread->format('d F Y'); // Or use 'Y-m-d' for year-month-day
        if ($row === NULL) :
            include '404.php';
    ?>
        <?php else :
            // Fetching User data who posted the question / thread
            $queryUser = $mysql->prepare('SELECT * FROM `users` WHERE `user_id`=?');
            $queryUser->bind_param('s', $row['thread_user_id']);
            $queryUser->execute();
            $rowUser = $queryUser->get_result()->fetch_assoc();

            // Fetching the comments related to every question/thread
            $queryComments = $mysql->prepare('SELECT * FROM `comments` WHERE `comment_thread_id`=?');
            $queryComments->bind_param('s', $row['thread_id']);
            $queryComments->execute();
            $resultComments = $queryComments->get_result();

        ?>
            <div class="card text-bg-info mb-3 container" style="max-width: 50rem;">
                <div class="card-header">Question</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['thread_title']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($row['thread_desc']); ?></p>
                </div>
                <div class="card-footer" style="opacity: 0.7;">Posted by <?php echo htmlspecialchars($rowUser['username']); ?>
                    <p class="text-end">On &ThickSpace; <?php echo htmlspecialchars($formattedDateThread); ?></p>
                </div>
            </div>
        <?php endif; ?>
    <?php else : ?>
        <?php include '404.php'; ?>
    <?php endif; ?>
    <br>
    <div class="container mt-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-8">
                <div class="d-flex flex-column comment-section">
                    <?php
                    if ($resultComments) :
                        while ($rowComments = $resultComments->fetch_assoc()) :

                            // Fetching User data who posted the comment
                            $queryCommentUser = $mysql->prepare('SELECT * FROM `users` WHERE `user_id`=?');
                            $queryCommentUser->bind_param('i', $rowComments['comment_user_id']);
                            $queryCommentUser->execute();
                            $rowCommentUser = $queryCommentUser->get_result()->fetch_assoc();

                            $datetime = $rowComments['comment_date'];
                            $date = new DateTime($datetime);

                            // Format the date to display only day, month, and year
                            $formattedDate = $date->format('d F Y'); // Or use 'Y-m-d' for year-month-day
                    ?>
                            <div class="bg-white p-2">
                                <div class="d-flex flex-row user-info"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                    </svg>
                                    <div class="d-flex flex-column justify-content-start ml-2"><span class="d-block font-weight-bold name"> &ThickSpace; <?php echo htmlspecialchars($rowCommentUser['username']); ?></span><span class="date text-black-50"> &ThickSpace; Shared publicly - <?php echo htmlspecialchars($formattedDate); ?></span></div>
                                </div>
                                <div class="mt-2">
                                    <p class="comment-text"><?php echo htmlspecialchars_decode($rowComments['comment_txt']); ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <?php if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) : ?>
                            <div class="bg-light p-2">
                                <form method="post" action="utils/_comment_add.php" class="add-comment-form">
                                    <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category_id); ?>">
                                    <input type="hidden" name="thread_id" value="<?php echo htmlspecialchars($thread_id); ?>">
                                    <input type="hidden" name="action" value="add comment with profile">
                                    <div class="d-flex flex-row align-items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                        </svg> &ThickSpace; <textarea class="form-control ml-1 shadow-none textarea border border-1 border-dark" name="comment_content" placeholder="Your comment here"></textarea>
                                    </div>
                                    <div class="mt-2 text-right mx-5"><input class="btn btn-primary btn-sm shadow-none" type="submit" value="Post comment"></input></div>
                                </form>
                            </div>
                        <?php else : ?>
                            <br><br>
                            <div class="container text-center">
                                <p>Please Sign in to post a Comment</p>
                            </div>
                        <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="container bg-light text-center">
        <h1>No Comments</h1>
        <p>Wait for someone to Post a question</p>
    </div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>

</html>