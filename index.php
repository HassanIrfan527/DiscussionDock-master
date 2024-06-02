<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Discussion-Dock | An online forum for programmers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style/style1.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="resources/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="resources/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="resources/favicon-16x16.png">
    <link rel="manifest" href="resources/site.webmanifest">

</head>

<body>
    <?php
    require 'utils/_db_connect.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    };

    if (!isset($_SESSION['logged-in'])) {
        if (isset($_COOKIE['user_token']) && isset($_COOKIE['allow']) && $_COOKIE['allow']) {
            $token = $_COOKIE['user_token'];
            // Validate the token
            $query = $mysql->prepare('SELECT * FROM `users` WHERE `user_token`=?');
            $query->bind_param('s', $token);
            $query->execute();
            $result = $query->get_result();
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                // User is authenticated
                $_SESSION['logged-in'] = true;
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit();
            } else {
                // Invalid token
                setcookie('user_token', '', time() - 3600, "/"); // Delete the cookie
                $_SESSION['logged-in'] = false;
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit();
            }
        }
    }
    require 'utils/_header.php';
    require 'utils/_login_reg_query.php';
    include 'utils/_sign_form.php';
    include 'utils/_login_form.php';

    ?>
    <section class="custom-sec sec-1">
        <div class="bg-white text-secondary px-4 py-5 text-center">
            <?php if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) : ?>
            <?php {
                    echo 'Welcome , ' . $_SESSION['username'] . ' ! ';
                };  ?>
            <div class="py-5" style="width: 100%; height:100%;">
                <h1 class="display-5 fw-bold text-dark">Discussion Dock</h1>
                <div class="col-lg-6 mx-auto">
                    <p class="fs-5 mb-4 text-dark">Discussion-Dock is a vibrant online forum dedicated to programmers of
                        all skill levels and backgrounds. Our mission is to foster a supportive and engaging community
                        where developers can share knowledge, collaborate on projects, and grow-custom their technical
                        skills.</p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <?php else : ?>
                        <?php {
                                echo '<div class="py-5" style="width: 100%; height:100%;">
                <h1 class="display-5 fw-bold text-dark">Discussion Dock</h1>
                <div class="col-lg-6 mx-auto">
                    <p class="fs-5 mb-4 text-dark">Discussion-Dock is a vibrant online forum dedicated to programmers of all skill levels and backgrounds. Our mission is to foster a supportive and engaging community where developers can share knowledge, collaborate on projects, and grow-custom their technical skills.</p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <button type="button" class="btn btn-outline-dark btn-lg px-4" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Sign Up</button>';
                            }
                            ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="custom-sec sec-2">
        <br>
        <br>
        <br>
        <h1 class="text-center text-light">Featured Categories</h1>
        <div class="wrapper-box">
            <div class="container">
                <?php
                require 'utils/_db_connect.php';

                $query = $mysql->prepare('SELECT * FROM `category`');
                if (!$query) {
                    $error = 'SERVER ERROR';
                    echo $error;
                } else {

                    $number = 1;
                    $query->execute();
                    $row = $query->get_result();
                    while ($result = $row->fetch_assoc()) {
                        if ($result['tag'] == 'featured') {
                            echo '<input type="radio" name="slide" id="c' . $number . '">
                        <label for="c' . $number . '" class="card">
                        <div class="icon">' . $number . '</div>
                            <div class="row">
                                <div class="description">
                                    <h4>' . $result['cat_title'] . '</h4>
                                    <p>' . $result['cat_desc'] . '</p>
                                    <div>
                                    <a role="button" class="button-86" role="button" href="/forum/categories.php?category_id=' . $result['cat_id'] . '">View Thread
                                    <span>&RightArrow;</span></a>                            
                                    </div>
                                    </div>
                            </div>
                            
                        </label>';
                        };
                        $number++;
                    };
                }

                ?>

            </div>
        </div>
        <div class="text-center">
            <a class="button-40" role="button" type="button" href="/forum/categories.php">View all Categories</a>
        </div>

    </section>
    <section class="custom-sec sec-3 p-5">
        <h1 class="p-2 m-5" style="background: transparent;">Why Discussion Dock ?</h1>
        <div class="content d-flex" style="justify-content: space-between;">
            <div class="list-items">
                <ul>
                    <li>
                        <h3>Enhanced Collaboration : </h3>
                        <p>We provide the tools you need to foster active and productive discussions.</p>
                    </li>
                    <li>
                        <h3>Improved Organization : </h3>
                        <p>Our structured approach keeps conversations clear and manageable.</p>
                    </li>
                    <li>
                        <h3>Effective Moderation : </h3>
                        <p>Maintain a respectful and engaging environment with our robust moderation features.</p>
                    </li>
                    <li>
                        <h3>Insightful Analytics : </h3>
                        <p>Gain valuable insights to understand and improve participation and engagement.</p>
                    </li>
                </ul>



            </div>
            <img src="resources/problem.png" width="500px" height="500px" alt="">
        </div>
    </section>
    <!-- START Bootstrap-Cookie-Alert -->
    <?php
    if ((isset($_COOKIE['allow']) && $_COOKIE['allow']) || isset($_COOKIE['user_token'])) {
        echo '';
    } else {
        echo '<div class="wrapper">
    <div class="content">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-cookie" viewBox="0 0 16 16">
            <path d="M6 7.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m4.5.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m-.5 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
            <path d="M8 0a7.96 7.96 0 0 0-4.075 1.114q-.245.102-.437.28A8 8 0 1 0 8 0m3.25 14.201a1.5 1.5 0 0 0-2.13.71A7 7 0 0 1 8 15a6.97 6.97 0 0 1-3.845-1.15 1.5 1.5 0 1 0-2.005-2.005A6.97 6.97 0 0 1 1 8c0-1.953.8-3.719 2.09-4.989a1.5 1.5 0 1 0 2.469-1.574A7 7 0 0 1 8 1c1.42 0 2.742.423 3.845 1.15a1.5 1.5 0 1 0 2.005 2.005A6.97 6.97 0 0 1 15 8c0 .596-.074 1.174-.214 1.727a1.5 1.5 0 1 0-1.025 2.25 7 7 0 0 1-2.51 2.224Z" />
        </svg>
        <header>Cookies Consent</header>
        <p>This website use cookies to ensure you get the best experience on our website.</p>
        <div class="buttons">
            <button class="item allow-btn">Allow</button>
            <button class="item bg-danger dismiss-btn">Dismiss</button>

        </div>
    </div>
</div>';
    }
    ?>


    <?php include 'utils/_footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="utils/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }
    const cookieBox = document.querySelector(".wrapper"),
        acceptBtn = cookieBox.querySelector(".allow-btn"),
        dismissBtn = cookieBox.querySelector(".dismiss-btn");
    acceptBtn.onclick = () => {
        cookieBox.classList.add('hide')
        setCookie('allow', true, 30)
    }
    dismissBtn.onclick = () => {
        cookieBox.classList.add('hide')

    }
    if (localStorage.getItem('allow')) {
        cookieConsent.classList.add('hide')
    }
    </script>

</body>

</html>