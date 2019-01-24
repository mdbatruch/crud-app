<?php

// //Load Config
require('includes/config.inc.php');

// //Load Connection
require('includes/connect.inc.php');

// //Load Functions
require('includes/functions.inc.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

$errors = array();
$data = array();


/* EMAIL */
if (empty($_POST['email'])) {
   $errors['email'] = "Email is required";
} else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Invalid email format";
}


/* MESSAGE */
if (empty($_POST['password'])) {
    $errors['password'] = "Please enter a password";
}

if(!empty($errors)) {
        
        $data['success'] = false;
        $data['errors'] = $errors;
        $data['message']  = 'There was an error with your login credentials. Please Review.';
} else {

    /* database check */

    $password = $_POST['password'];
                
    $email = sanitize($database, $_POST['email']);

    // $data['errors'] = $errors;

    // $logged_in = LOGGED_IN;
                
    $addition = "SELECT
                        id,
                        firstname,
                        lastname,
                        password
                            FROM users
                            WHERE email = '$email'
                            LIMIT 1";
                
                $result = mysqli_query( $database, $addition )
        or die( mysqli_error( $database ) );
                
    if( mysqli_num_rows( $result ) > 0){
                    
        $row = mysqli_fetch_assoc( $result );     
                    
            if(md5($password) === $row[ 'password']){
                
                $_SESSION[ 'login_token' ] = LOGGED_IN;
                $_SESSION[ 'user_id '] = $row[ 'id' ];
                $_SESSION[ 'firstname' ] = $row[ 'firstname' ];
                $_SESSION[ 'lastname' ] = $row[ 'lastname' ];
                $_SESSION[ 'email' ] = $email;

                if (!isset($_SESSION['LAST_ACTIVITY'])) {
                    $_SESSION['LAST_ACTIVITY'] = time();
                }

                $data['success'] = true;
                // $data['message']  = 'Logging you in now!';
                $data['redirecturl'] = 'http://localhost:8888/Web-Stuff/crud-app/discography-app/';

                // redirect('/');
                // redirect(SITE_ROOT);

            } else {
                
                $errors['password'] = 'Wrong Password. Please Try Again.';
                $data['errors'] = $errors;
                $data['message']  = 'There was an error with your login credentials. Please Review.';
            }
        } else {
                
                $errors['email'] = "No Email like this.";
                $data['errors'] = $errors;
                $data['message']  = 'There was an error with your login credentials. Please Review.';
    }
}
    echo json_encode($data);

?>