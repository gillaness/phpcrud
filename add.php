<?php

    session_start();
    require_once "pdo.php";

    if ( ! isset($_SESSION['email']) ) {
        die("ACCESS DENIED");
    }

    if(isset($_POST['cancel'])){
        header("Location:index.php");
        return;
    }

    if((isset($_POST['make']) && (trim($_POST['make'])=='')) || (isset($_POST['model']) && (trim($_POST['model'])=='')) || (isset($_POST['year']) && (trim($_POST['year'])=='')) ||
        (isset($_POST['mileage']) && (trim($_POST['mileage'])==''))){
        $_SESSION['failure']= "All fields are required";
        header("Location:add.php");
        return;
    
    
    } else if((isset($_POST['mileage']) && !is_numeric($_POST['mileage'])) || (isset($_POST['year']) && !is_numeric($_POST['year']))){
        $_SESSION['failure'] = "Mileage and year must be numeric";
        header("Location:add.php");
        return;


    //INSERT query
    } else if(isset($_POST['make']) && isset($_POST['model']) && isset($_POST['mileage']) && isset($_POST['year'])){
        $stmt = $pdo->prepare
        ('INSERT INTO autos (make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)');
        $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':md' => $_POST['model'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage'])
        );

        $_SESSION['success'] = "Record added";
        header("Location: index.php");
        return;

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Germán Eduardo Illanes Salas</title>
</head>
<body>
    <?php
        if(isset($_SESSION['email'])){
            echo "<h1>Tracking Autos for ".htmlentities($_SESSION['email'])."</h1>";
        }

        if ( isset($_SESSION['failure']) ) {
            echo "<p style='color:#F00;'>".htmlentities($_SESSION['failure'])."</p>\n";
        }
        unset($_SESSION['failure']);
    ?>

    <form method="POST">
        <p>Make:
        <input type="text" name="make" size="60"/></p>
        <p>Model:
        <input type="text" name="model" size="60"/></p>
        <p>Year:
        <input type="text" name="year"/></p>
        <p>Mileage:
        <input type="text" name="mileage"/></p>
        <input type="submit" value="Add">
        <input type="submit" name="cancel" value="Cancel"> 
    </form>

</body>
</html>