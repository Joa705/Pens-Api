<?php
class Auth {
    // username and password
    private $user_name = 'Svein';
    private $password = '12345';

    // Check if request is using simple authorizatin header
    public function check_user() {
        // Check if user has proper crendetials
        if (!isset($_SERVER['PHP_AUTH_USER'])){
            header('WWW-Authenticate: Private Area');
            header('HTTP/1.0 401 Unauthorized');
            echo "Error, No credentials inserted";
            die();
        }
    }

    // Verify users credentials
    public function verify_user() {
        // Verify users crendetials
        if(($_SERVER['PHP_AUTH_USER'] != $this->user_name) or ($_SERVER['PHP_AUTH_PW'] != $this->password)) {
            header('WWW-Authenticate: Private Area');
            header('HTTP/1.0 401 Unauthorized');
            echo "Error, user not authorized";
            die();
        }
    }
}


class Request {
    // method param
    public $method;

    // Constructor
    public function __construct($m) {
        $this->method = $m;
    }

    // Verify method
    public function veryify_method() {
        // Verify method, etc 'DELETE'
        if($_SERVER['REQUEST_METHOD'] != $this->method){
            header('HTTP/1.1 405 Method Not Allowed');
            header('Content-Type: text/plain');
            echo 'Method not allowed';
            die();
        }
    }
}