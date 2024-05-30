<?php
session_start();
if (isset($_SESSION["logged-in"]) && $_SESSION["logged-in"]) :
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile <?php echo htmlspecialchars($_SESSION['username']); ?> | Discussion Dock</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        <?php include 'utils/_header.php'; ?>
        <?php require 'utils/_db_connect.php'; ?>
        <?php require 'utils/profile_form.php'; ?>
        <?php
        $query = $mysql->prepare('SELECT * FROM `users` WHERE `username`=?');
        if ($query) {
            $query->bind_param('s', $_SESSION['username']);
            $query->execute();
            $row = $query->get_result();
            if ($row->num_rows === 1) :
                $result = $row->fetch_assoc();
        ?>
                <div class="container rounded bg-white mt-5 mb-5">
                    <div class="row">
                        <div class="col-md-3 border-right">
                            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                                <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                                <span class="font-weight-bold"><?php echo htmlspecialchars($result['username']); ?></span>
                                <span class="text-black-50"><?php echo htmlspecialchars($result['email']); ?></span>
                                <span> </span>
                            </div>
                        </div>
                        <div class="col-md-5 border-right">
                            <div class="p-3 py-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="text-right">Profile Settings</h4>
                                </div>
                                <form action="/forum/profile.php" method="post" id="profile-form">
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="labels">First Name</label>
                                            <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($result['first_name']); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="labels">Last Name</label>
                                            <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($result['last_name']); ?>">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <label class="labels">Username</label>
                                            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($result['username']); ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="labels">Mobile Number</label>
                                            <input type="text" class="form-control" name="mobile_number" value="<?php echo htmlspecialchars($result['mobile_number']); ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="labels">Email ID</label>
                                            <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($result['email']); ?>">
                                        </div>
                                    </div>

                                    <div class="mt-5 text-center">
                                        <button class="btn btn-primary profile-button" type="submit">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            endif;
        }
        ?>
    <?php else :
    header('Location: 404.php');
    exit(); // Make sure script stops after redirection
endif;
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    </body>

    </html>