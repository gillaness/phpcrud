<?php

    session_start();
    require_once "pdo.php";

    if ( ! isset($_SESSION['email']) ) {
        die("ACCESS DENIED");
    }

    $stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :id");
    $stmt->execute(array(":id" => $_GET['autos_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for auto_id';
    header( 'Location: index.php' ) ;
    return;  
    }

    if(isset($_POST['cancel'])){
        header("Location:index.php");
        return;
    }

    if((isset($_POST['make']) && (trim($_POST['make'])=='')) || (isset($_POST['model']) && (trim($_POST['model'])=='')) || (isset($_POST['year']) && (trim($_POST['year'])=='')) ||
        (isset($_POST['mileage']) && (trim($_POST['mileage'])==''))){
        $_SESSION['failure']= "All fields are required";
        header("Location: edit.php?autos_id=".$_REQUEST['id']);
        return;
    
    
    } else if((isset($_POST['mileage']) && !is_numeric($_POST['mileage'])) || (isset($_POST['year']) && !is_numeric($_POST['year']))){
        $_SESSION['failure'] = "Mileage and year must be numeric";
        header("Location: edit.php?autos_id=".$_REQUEST['id']);
        return;


    //UPDATE query
    } else if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['mileage']) && isset($_POST['id']) && isset($_POST['year'])) {
            $sql = "UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage WHERE auto_id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage'],
            ':id' => $_POST['id']));
            $_SESSION['success'] = 'Record updated';
            header("Location: index.php") ;
            return;
    }  
        
    $make = htmlentities($row['make']);
    $model = htmlentities($row['model']);
    $year = htmlentities($row['year']);
    $mileage = htmlentities($row['mileage']);
    $id = $row['auto_id'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Germán Eduardo Illanes Salas</title>
</head>
<body>
    <h1>Editing Automobile</h1>
    <?php
        if ( isset($_SESSION['failure']) ) {
            echo "<p style='color:#F00;'>".htmlentities($_SESSION['failure'])."</p>\n";
        }
        unset($_SESSION['failure']);
    ?>

<form method="POST">
        <p>Make:
        <input type="text" name="make" size="60" value="<?= $make ?>"></p>
        <p>Model:
        <input type="text" name="model" size="60" value="<?= $model ?>"></p>
        <p>Year:
        <input type="text" name="year" value="<?= $year ?>"></p>
        <p>Mileage:
        <input type="text" name="mileage" value="<?= $mileage ?>"></p>
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="submit" value="Save">
        <input type="submit" name="cancel" value="Cancel"> 
    </form>

</body>
</html>