<?php 
    session_start();
    require_once "../../pdo.php";

        
    if ( isset($_POST['cancel'] ) ) {
        // Redirect the browser to game.php
        header("Location: index.php");
        return;
    }

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['email']) ) {

    $_SESSION['name'] = $_POST['email']; //saving post data in session

    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        // $failure = "Email and password are required";
        $_SESSION['error'] = "Email and password are required";
        header("Location: login.php");
        return;
    } 
    else {
        if(strpos($_POST['email'], '@') === FALSE){
            // $failure = "Email must have an at-sign (@)";
            $_SESSION['error'] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        }
        else{
            $check = hash('md5', $salt.$_POST['pass']);
            if ( $check == $stored_hash ) {
                error_log("Login success ".$_POST['email']);
                $_SESSION['logged-in'] = "true";
                // Redirect the browser to autos.php
                header("Location: index.php");
                return;
            } else {
                // $failure = "Incorrect password";

                error_log("Login fail ".$_POST['email']." $check");

                $_SESSION["error"] = "Incorrect password";
                header("Location: login.php");
                return;
            }
        }
        
    }
}

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muhaddatha Abdulghani</title>
    <?php require_once "bootstrap.php"?>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container">
        <h1>Please Log In</h1>
        <?php
        // Note triple not equals and think how badly double
        // not equals would work here...
        // if ( $failure !== false ) {
        //     // Look closely at the use of single and double quotes
        //     echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
        // }

        if(isset($_SESSION['error'])){
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
        ?>
        <form method="POST">
            <label for="nam">User Name</label>
            <input type="text" name="email" id="nam"><br/>
            <label for="id_1723">Password</label>
            <input type="text" name="pass" id="id_1723"><br/>
            <input type="submit" value="Log In">
            <a href="logout.php">Cancel</a>
            <input type="submit" name="cancel" value="Cancel" hidden>
            
        </form>
        
    </div>
    
</body>
</html>
