<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <!--jQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <!--BootStrap-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>
</head>
<body>
    <div class="container">

        <br><br>

        <form action="index.php" method="post">
            <!-- USERNAME -->
            <div class="row">
                <div class="col-sm-1 col-md-4"></div>
                <div class="col-sm-10 col-md-4">
                    <input type="text" class="form-control" name="dom_username" placeholder="username">
                </div>
                <div class="col-sm-1 col-md-4"></div>
            </div>

            <!-- PASSWORD -->
            <div class="row">
                <div class="col-sm-1 col-md-4"></div>
                <div class="col-sm-10 col-md-4">
                    <input type="text" class="form-control" name="dom_password" placeholder="password">
                </div>
                <div class="col-sm-1 col-md-4"></div>
            </div>

            <!-- LOGIN -->
            <div class="row">
                <div class="col-sm-1 col-md-4"></div>
                <div class="col-sm-10 col-md-4">
                    <button type="submit" name="dom_login" class="btn btn-default btn-block">Login</button>
                </div>
                <div class="col-sm-1 col-md-4"></div>
            </div>
        </form>

        <br><br>

        <?php

            // on form submit
            if (isset($_POST['dom_login'])) {

                // load Authentication class
                require "Authentication.php";

                // get username and password inputs
                $username = filter_input(INPUT_POST, 'dom_username');
                $password = filter_input(INPUT_POST, 'dom_password');

                // create authentication system
                $auth = new Authentication("username", "password", "users");

                try {
                    // connect to authentication database
                    $auth->connect("localhost", "root", null, "users");

                    // authenticate user
                    $auth->authenticate($username, $password);

                    // declare session
                    $auth->startSession();
                    $_SESSION['login'] = $auth;

                    // redirect
                    header('Location: success.php');
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }

        ?>
    </div>
</body>
</html>