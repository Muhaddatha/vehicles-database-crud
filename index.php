<?php 
    session_start();
    require_once "../../pdo.php";
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

    <h2>Welcome to the Automobiles Database</h2>
    <br>

    <?php 
        
        //if the user is logged in, show database table and errors
        if(isset($_SESSION['logged-in'])){

            if ( isset($_SESSION['error']) ) {
                echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
                unset($_SESSION['error']);
            }
            if ( isset($_SESSION['success']) ) {
                echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
                unset($_SESSION['success']);
            }

            $usersTableEmpty = true;

            echo('<table border="1">'."\n");
            $stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
            while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

                $usersTableEmpty = false;
                echo "<tr><td>";
                echo(htmlentities($row['make']));
                echo("</td><td>");
                echo(htmlentities($row['model']));
                echo("</td><td>");
                echo(htmlentities($row['year']));
                echo("</td><td>");
                echo(htmlentities($row['mileage']));
                echo("</td><td>");
                echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
                echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
                echo("</td></tr>\n");


                
            }

            if($usersTableEmpty){
                echo("<p> No rows found </p>");
            }
        
        }
        else{
            echo("<p><a href='login.php'>Please log in</a></p>");
        }
        

    ?>

<?php
    if(isset($_SESSION['logged-in'])){
        echo("<p><a href='add.php'>Add New Entry</a><p>");
        echo("<p><a href='logout.php'>Logout</a></p>");
    }

?>
    
</body>
</html>
