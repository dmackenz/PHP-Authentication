<?php

    class Authentication {
        // name of host
        private $host;

        // name of database holding users
        private $hostDb;

        // database username
        private $hostUsername;

        // database password
        private $hostPassword;

        // mysqli connection
        private $dbc;

        /**
         * __construct
         *
         * Creates an authentication object
         */
        public function __construct() {
            // intialize instance data
            $this->host             = null;
            $this->hostDb           = null;
            $this->hostUsername     = null;
            $this->hostPassword     = null;
            $this->dbc              = null;
        }

        /**
         * connect
         *
         * Establish a connection to the database holding user information.
         */
        public function connect($host, $hostUsername, $hostPassword, $hostDb) {
            // initialize instance data (data)
            $this->host             = $host;
            $this->hostDb           = $hostDb;
            $this->hostUsername     = $hostUsername;
            $this->hostPassword     = $hostPassword;

            // connect to database
            $this->dbc = mysqli_connect($this->host, $this->hostUsername, $this->hostPassword, $this->hostDb);
            if (!$this->dbc) {
                throw new Exception("Database did not connect.");
            }
        }

        /**
         * authenticate
         *
         * Check if the username and password match
         * a record in the database.
         */
        public function authenticate($username, $password) {
            // make database friendly
            $username = strtolower(Authentication::make_safe($username));

            // fetched hashed password
            $hash = null;

            // lookup password
            $query = "SELECT password FROM users WHERE username='".$username."'";
            $result = mysqli_query($this->dbc, $query);
            if ($result) {

                // check if username found
                if (mysqli_num_rows($result) < 1) {
                    throw new Exception("Username does not exist.");
                } else {

                    // assign fetched hash
                    $row = mysqli_fetch_row($result);
                    $hash = $row[0];
                }
            } else {
                throw new Exception("Qeury failed.");
            }

            // compare hash to entered password
            if (!password_verify($password, $hash)) {
                throw new Exception("Password is incorrect.");
            }
        }

        /**
         * startSession
         *
         * Starts the session for the user
         * and gives a new session id.
         */
        public static function startSession() {
            // start session
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // give new session id
            session_regenerate_id();
        }

        /**
         * logout
         *
         * Unset the current login session.
         */
        public function logout() {
            // start session
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // remove session
            if (isset($_SESSION['login'])) {
                unset($_SESSION['login']);
            }    
        }

        /**
         * make_safe
         *
         * Make input strings safe for database queries.
         */
        public static function make_safe($str) {
            return mysql_real_escape_string(strip_tags(trim($str)));
        }
    }

?>