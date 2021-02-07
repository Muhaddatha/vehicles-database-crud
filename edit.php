<?php 
    session_start();
    require_once "../../pdo.php";

    $toEdit = $_GET['autos_id'];

    
    $stmt2 = $pdo->prepare('SELECT make, model, year, mileage FROM autos WHERE autos_id = :ai');
    $stmt2->execute(array(':ai' => htmlentities($_GET['autos_id']) ));

    $rowInfo = $stmt2->fetch(PDO::FETCH_ASSOC);
    
    $_SESSION['make'] = $rowInfo['make'];
    $_SESSION['model'] = $rowInfo['model'];
    $_SESSION['year'] = $rowInfo['year'];
    $_SESSION['mileage'] = $rowInfo['mileage'];

    // echo($_SESSION['make']);
    

    if(isset($_POST['cancel'])){
        header('Location: index.php');
        return;
    }

    if(isset($_POST['save'])){
        //insert record into database
        $stmt = $pdo->prepare('UPDATE autos SET make=:mk, model=:md, year=:yr, mileage=:mi WHERE autos_id = :ai');
        $stmt->execute(array(
            ':ai' => htmlentities($_GET['autos_id']),
            ':mk' => htmlentities($_POST['make']),
            ':md' => htmlentities($_POST['model']),
            ':yr' => htmlentities($_POST['year']),
            ':mi' => htmlentities($_POST['mileage'])
        ));

        $_SESSION['success'] = "Record updated";
        header("Location: index.php");
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
        <h1>Editing Automobile</h1>
        <form method="post">
            <p>Make <input type="text" name="make" size="40" value="<?php echo(htmlentities($_SESSION['make'])); ?>"></p>
            <p>Model <input type="text" name="model" size="40" value="<?php echo(htmlentities($_SESSION['model'])); ?>"></p>
            <p>Year <input type="text" name="year" size="10" value="<?php echo(htmlentities($_SESSION['year'])); ?>"></p>
            <p>Mileage <input type="text" name="mileage" size="10" value="<?php echo(htmlentities($_SESSION['mileage'])); ?>"></p>
            <input type="hidden" name="autos_id" value="0">
            <input type="submit" value="Save" name="save">
            <input type="submit" value="Cancel" name="cancel">
        </form>
    </div>
</body>
</html>
