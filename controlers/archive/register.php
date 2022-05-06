<?php

//register.php

/**
 * Start the session.
 */
session_start();


require 'db.php';

//If the POST var "register" exists (our submit button), then we can
//assume that the user has submitted the registration form.
if(isset($_POST['reg_user'])){
    
    //Retrieve the field values from our registration form.
    $name = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $passwordHash = md5($password);
    $date = !empty($_POST['date']) ? trim($_POST['date']) : null;
    $date = date("Y-m-d");
    //TO ADD: Error checking (username characters, password length, etc).
    //Basically, you will need to add your own error checking BEFORE
    //the prepared statement is built and executed.
    
    //Now, we need to check if the supplied username already exists.
    
    
    //check if there is not another username or email;
    
    //Construct the SQL statement and prepare it.
    $sql = "SELECT * FROM `users` WHERE `email`= :email;";
    $stmt = $pdo->prepare($sql);
    
    //Bind the provided username to our prepared statement.
    $stmt->bindValue(':email', $email);
    //Execute.
    $stmt->execute();
    
    $result= $stmt->fetchAll();
    
    if($result)
    {
        die("email already used");
    }
    
    
    
    //Construct the SQL statement and prepare it.
    $sql = "INSERT INTO `users` (`userid`, `name`, `email`, `password`, `title`, `birthday`, `info`, `stamp`, `rank`, `createdata`, `picture`) VALUES (NULL, :name, :email, :password, NULL, :date, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL);";
    $stmt = $pdo->prepare($sql);
    
    //Bind the provided username to our prepared statement.
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $passwordHash);
    $stmt->bindValue(':date', $date);
    //Execute.
    $result = $stmt->execute();
    
    //If the signup process is successful.
    if($result){
        //What you do here is up to you!
        echo 'Thank you for registering with our website.';
    }
    
    
}

?>
