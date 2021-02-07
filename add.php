<?php 
    session_start();
    require_once "../../pdo.php";

    $debugging = true;

    
    if(!isset($_SESSION['name'])){
        //if a username/email has not been entered, die()
        die("ACCESS DENIED");
    }

    if(isset($_POST['logout'])){
        if($debugging){
            echo("logout button clicked!");
        }
        
        header('Location: logout.php');
        return;
    }
    
    if(isset($_POST['Add'])){

        echo("Submit was clicked!");

        //use isset and empty together
        //https://stackoverflow.com/questions/9986761/isset-function-is-returning-true-even-when-item-is-not-set
        if(isset($_POST['make']) && !empty($_POST['make']) && isset($_POST['model']) && !empty($_POST['model']) && isset($_POST['year']) && !empty($_POST['year']) && isset($_POST['mileage']) && !empty($_POST['mileage'])){
            
            
            print_r($_POST);
            echo("isset values: ".isset($_POST['make'])." ".isset($_POST['model'])." ".isset($_POST['year'])." ".isset($_POST['mileage']));
            

            if($debugging){
                echo("All variables are set");
                print_r($_POST);
    
            }

            if(!is_numeric($_POST['mileage'])){
                $_SESSION['error'] = "Mileage must be numeric";
                echo("Inside mileage error");
                header("Location: add.php");
                return;
            }

            if(!is_numeric($_POST['year'])){
                $_SESSION['error'] = "Year must be numeric";
                header("Location: add.php");
                return;
            }

            //insert record into database
            $stmt = $pdo->prepare('INSERT INTO autos (make, model, year, mileage) VALUES (:mk, :md, :yr, :mi)');
            $stmt->execute(array(
                ':mk' => htmlentities($_POST['make']),
                ':md' => htmlentities($_POST['model']),
                ':yr' => htmlentities($_POST['year']),
                ':mi' => htmlentities($_POST['mileage'])
            ));

            $_SESSION['success'] = "Record added";
            header("Location: index.php");
            return;


        }
        else{
            $_SESSION['error'] = "All fields are required";
            header("Location: add.php");
            return; //don't forget these return statements!!!!
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
        <?php echo("<h1>Tracking Autos for ".$_SESSION['name']); ?>
        <?php
        
        // Note triple not equals and think how badly double
        // not equals would work here...
        if ( isset($_SESSION['error'])) {
            // Look closely at the use of single and double quotes
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
        
        ?>



        <form method="post">
            <p>Make: <input type="text" name="make"></p>
            <p>Model: <input type="text" name="model"></p>
            <p>Year: <input type="text" name="year"></p>
            <p>Mileage: <input type="text" name="mileage"></p>
            <input type="submit" value="Add" name="Add">
            <input type="submit" value="Logout" name="logout">
        </form>
    </div>
    
    
</body>
</html>
