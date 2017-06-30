<?php
class Model{
    public $db;

    public function __construct(){
        require_once('includes/config.php');
        try {
            //create PDO connection
            $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            //show error
            echo '<p class="bg-danger">'.$e->getMessage().'</p>';
            exit;
        }
    }

    public function create_user(){

        if (isset($_POST['submit'])) {
            //very basic validation
            if (strlen($_POST['username']) < 5) {
                $error[] = 'Username is too short.';
            } else {
                $stmt = $this->db->prepare('SELECT username FROM users WHERE username = :username');
                $stmt->execute(array(':username' => $_POST['username']));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!empty($row['username'])) {
                    $error[] = 'Username provided is already in use.';
                }
            }
            if (!empty($_POST["password"])) {
                $password = $_POST["password"];
                if (strlen($password) < 8) {
                    $error[] = "Your Password Must Contain At Least 8 Characters!";
                } elseif (!preg_match("#[0-9]+#", $password)) {
                    $error[] = "Your Password Must Contain At Least 1 Number!";
                } elseif (!preg_match("#[A-Z]+#", $password)) {
                    $error[] = "Your Password Must Contain At Least 1 Capital Letter!";
                } elseif (!preg_match("#[a-z]+#", $password)) {
                    $error[] = "Your Password Must Contain At Least 1 Lowercase Letter!";
                }
            } else {
                $error[] = "Please enter password";
            }
            if ($_POST['password'] != $_POST['passwordConfirm']) {
                $error[] = 'Passwords do not match.';
            }
//email validation
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $error[] = 'Please enter a valid email address';
            } else {
                $stmt = $this->db->prepare('SELECT email FROM users WHERE email = :email');
                $stmt->execute(array(':email' => $_POST['email']));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!empty($row['email'])) {
                    $error[] = 'Email provided is already in use.';
                }
            }
//if no errors have been created carry on
            if (!isset($error)) {
                //hash the password
                   $hashedpassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

                try {
                    //insert into database with a prepared statement
                    $stmt = $this->db->prepare('INSERT INTO users (username,password,email) VALUES (:username, :password, :email)');
                    $stmt->execute(array(
                        ':username' => $_POST['username'],
                        ':password' => $hashedpassword,
                        ':email' => $_POST['email']
                    ));
                    $this->db->lastInsertId('userID');

                    header('Location: index.php?action=joined');
                    exit;
                    //else catch the exception and show the error.
                } catch (PDOException $e) {
                    $error[] = $e->getMessage();
                }
            }
            return $error;
        }else{
            //if action is joined show sucess
            if(isset($_GET['action']) && $_GET['action'] == 'joined'){
                $error[] = "<h2 class='bg-success'>Registration successful, please check your email to activate your account.</h2>";
                return $error;
            }
        }

    }


}