<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories | Discussion Dock</title>
    <link rel="stylesheet" href="style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            font-family: "Poppins", sans-serif;

        }
    </style>
</head>

<body>

    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    };
    require 'utils/_login_reg_query.php';
    include 'utils/_header.php';
    require 'utils/_db_connect.php';
    include 'utils/_sign_form.php';
    include 'utils/_login_form.php';
    if (isset($_GET['category_id'])) {

        $category_id = $_GET['category_id'];
        $query = $mysql->prepare('SELECT * FROM `category` WHERE `cat_id`=?');
        $query->bind_param('i', $category_id);
        $query->execute();
        if (!$query) {
            $error = 'SERVER ERROR';
            echo $error;
        } else {
            $row = $query->get_result();
            $result = $row->fetch_assoc();
            if ($result === NULL) {
                include '404.php';
            } else {
                $title = $result['cat_title'];
                $description = $result['cat_desc'];
                $catId = $result['cat_id'];

                echo '<nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <li class="page-item"><a class="page-link" href="/forum/categories.php">Categories</a></li>
              <li class="page-item"><a class="page-link" href="#">' . $title . '</a></li>
            </ul>
          </nav>';

                echo '<div class="card text-bg-primary mb-3 container alert-dismissible fade show alert" role="alert" style="max-width: 50rem;">
            <div class="card-header">Rules of Discussion Dock Forums</div>
            <div class="card-body">
                <h5 class="card-title">Please follow these rules while posting a review or question.</h5>
                <p class="card-text">
                <ol>
                    <li>Treat all members with respect. Personal attacks, harassment, and hate speech will not be tolerated.</li>
                    <li>Post content relevant to the category you are participating in. Off-topic posts may be moved or removed.</li>
                    <li>Do not post spam, advertisements, or promotional content without prior permission.</li>
                    <li>Make sure your posts are clear, concise, and relevant to the topic. Use proper grammar and avoid excessive use of slang or abbreviations.</li>
                    <li>When sharing information from other sources, give appropriate credit and provide links where possible.</li>
                    <li>Do not post content that you did not create without proper attribution.</li>
                </ol>
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }
        };
    } else {

        $query = $mysql->prepare('SELECT * FROM `category`');
        if (!$query) {
            $error = '';
            echo $error;
        }
        $query->execute();
        $row = $query->get_result();
    };


    ?>


    </div>
    <hr>
    <div class="card text-bg-light mb-3 container" style="max-width: 50rem;">
        <div class="card-header">Welcome to Discussion Dock Forums</div>
        <div class="card-body">
            <h5 class="card-title"> <?php if (isset($catId)) {
                                        echo 'Welcome to ' . $title . ' Forums</h5>
                                        <p class="card-text">' . $description . '</p>';
                                    } else {
                                        echo "Browse all Topics & Categories";
                                    }   ?>


        </div>
        <?php
        if ((isset($_SESSION['logged-in']) && $_SESSION['logged-in']) && isset($_GET['category_id'])) {
            echo '<br>
            <button class=" container btn btn-info w-50" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style="font-weight: 550;">Post a Question</button>
            <br>';
        } else {
            echo '<p class="opacity-50 container">Please Sign in to post a question</p>';
        }
        ?>

    </div>
    <?php
    if ((isset($_SESSION['logged-in']) && $_SESSION['logged-in']) && isset($_GET['category_id'])) {
        require 'utils/_add_form.php';
    }
    ?>
    <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
        <div class="list-group">
            <?php
            if (isset($catId)) {
                $queryThreads = $mysql->prepare('SELECT * FROM `threads` WHERE `thread_cat_id`=?');
                $queryThreads->bind_param('i', $category_id);
                $queryThreads->execute();
                $rowThreads = $queryThreads->get_result();
                $resultThread = $rowThreads->fetch_all(MYSQLI_ASSOC);
                if ($resultThread != NULL) {
                    foreach ($resultThread as $result) {
                        echo '<div href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3 border-bottom border-dark" aria-current="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                    </svg>
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <h6 class="mb-0"><a href="/forum/threads.php?category_id=' . htmlspecialchars_decode($result['thread_cat_id']) . '&thread_id=' . $result['thread_id'] . '">' . $result['thread_title'] . '</a></h6>
                            <p class="mb-0 opacity-75">' . htmlspecialchars_decode( $result['thread_desc']) . '</p>
                        </div>
                        <small class="opacity-50 text-nowrap"><a href="/forum/threads.php?category_id=' . $result['thread_cat_id'] . '&thread_id=' . $result['thread_id'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z" />
                            </svg></a></small>
                    </div>
                </div>';
                    }
                } else {

                    echo '<div class="container">
                   <h3>No Results</h3>
                   <p class="opacity-75">Be first to post a question</p>
                   </div>';
                }
            };

            ?>

        </div>
    </div>
    <div class="cards-container d-flex flex-wrap container">
        <?php
        while ($result = $row->fetch_assoc()) {
            $sentence = $result['cat_desc'];
            $pos = strpos($sentence, '.');
            $substituted = substr($sentence, 0, $pos);
            echo '<div class="card bg-dark m-4" data-bs-theme="dark" style="max-width: 40%;">
        <div class="card-header">
            Featured
        </div>
        <div class="card-body">
            <h5 class="card-title">' . $result['cat_title'] . '</h5>
            <p class="card-text">' . $substituted . '</p>
            <a href="/forum/categories.php?category_id=' . $result['cat_id'] . '" class="btn btn-outline-primary" role="button">View Thread</a>
        </div>
    </div>';
        }

        ?>
    </div>



    <?php include 'utils/_footer.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="utils/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>



</body>


</html>