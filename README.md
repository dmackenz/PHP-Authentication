# PHP Authentication System
##### Dylan MacKenzie

This is a simple authentication system written in php that can be used in a wide variety of senarios. The system connects to a database which stores users usernames and passwords and verifies that they exist.

An example database is included as an sql file. The credentials that are preset are:
USERNAME: username
PASSWORD: password

Passwords are stored using the PASSWORD_BCRYPT hash algorithm.

index.php provides an example of how this system can be used. 

### API

  - new Authentication()
  - connect($host, $hostUsername, $hostPassword, $hostDb)
  - authenticate($username, $password)
  - startSession()
  - logout()

### Example Usage
```php
if (isset($_POST['dom_login'])) {
    // load authentication class
    require "Authentication.php";

    // receive dom inputs
    $username = filter_input(INPUT_POST, 'dom_username');
    $password = filter_input(INPUT_POST, 'dom_password');

    $auth = new Authentication();
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
```