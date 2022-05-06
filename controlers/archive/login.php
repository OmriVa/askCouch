<?php

//login.php

/**
 * Start the session.
 */
session_start();

/**
 * Include our MySQL connection.
 */
require 'db.php';


//If the POST var "login" exists (our submit button), then we can
//assume that the user has submitted the login form.
if(isset($_POST['login'])){
    
    //Retrieve the field values from our login form.
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $passwordAttempt = md5($password);
    
    //Retrieve the user account information for the given username.
    $sql = "SELECT `name`, `email`, `password`,'birthday' FROM `users` WHERE `email` = :email ";
    $stmt = $pdo->prepare($sql);
    
    //Bind value.
    $stmt->bindValue(':email', $email);
    
    //Execute.
    $stmt->execute();
    
    //Fetch row.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo $passwordAttempt;
        //If $validPassword is TRUE, the login has been successful.
        if($passwordAttempt == $user['password']){
            
            //Provide the user with a login session.
            $_SESSION['name'] = $user['name'];
            $_SESSION['logged_in'] = time();
            $_SESSION['age'] = $user['birthday'];
            $_SESSION['email'] = $user['email'];
            //Redirect to our protected page, which we called home.php
            header('Location: ../index.php');
            exit;
            
        } else{
            //$validPassword was FALSE. Passwords do not match.
            die('Incorrect username / password combination!');
        }
    
    
}
 
?>
