<?php 
    session_start();
    require_once "../../pdo.php";

    $toDelete = $_GET['autos_id'];

    
    $stmt2 = $pdo->prepare('SELECT make FROM autos WHERE autos_id = :ai');
    $stmt2->execute(array(':ai' => htmlentities($_GET['autos_id']) ));

    $make = $stmt2->fetchColumn();

    if(isset($_POST['Delete'])){

        $stmt = $pdo->prepare('DELETE FROM autos WHERE autos_id = :ai');
        $stmt->execute(array(':ai' => htmlentities($_GET['autos_id']) ));
        $_SESSION['success'] = "Record deleted";

        header('Location: index.php');
        return;
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
        <?php 
        echo("<p>Confirm: Deleting ".htmlentities($make)."</p> ") ?>
    
        <form method="post">
            <input type="submit" value="Delete" name="Delete">
            <a href="index.php">Cancel</a>
        </form>
    </div>
    
</body>
</html>
