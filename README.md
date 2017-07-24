# PHP Authentication System
##### Dylan MacKenzie

This is a simple authentication system written in php that can be used in a wide variety of senarios. The system connects to a database which stores users usernames and passwords and verifies that they exist.

An example database is included as an sql file. The credentials that are preset are:
> USERNAME: username <br>
> PASSWORD: password

Passwords are stored using the PASSWORD_BCRYPT hash algorithm.

index.php provides an example of how this system can be used. 

### API

  - new Authentication($usernameField, $passwordField, $table)
  - connect($host, $hostUsername, $hostPassword, $hostDb)
  - authenticate($username, $password)
  - startSession()
  - logout()

### Example Usage
```php
// on form submit
if (isset($_POST['dom_login'])) {

    // load Authentication class
    require "Authentication.php";
    
    // declare settings
    $userField = "username";
    $passField = "password";
    $table = "users";
    $host = "localhost";
    $hostUsername = "root";
    $hostPassword = null;
    $hostDB = "users";
    
    // get username and password inputs
    $username = filter_input(INPUT_POST, 'dom_username');
    $password = filter_input(INPUT_POST, 'dom_password');

    // create authentication system
    $auth = new Authentication($userField, $passField, $table);

    try {
        // connect to authentication database
        $auth->connect($host, $hostUsername, $hostPassword, $hostDB);

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
```
```php
<?php
    // load authentication class
    require "Authentication.php";

    // start session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // perform logout
    $auth = $_SESSION['login'];
    $auth->logout();
?>
```
