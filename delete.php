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

    if ( isset($_POST['delete']) && isset($_POST['id']) ) {
        $sql = "DELETE FROM autos WHERE auto_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':id' => $_POST['id']));
        $_SESSION['success'] = 'Record deleted';
        header( 'Location: index.php' ) ;
        return;
        }
    
        
    $make = htmlentities($row['make']);
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
    <p>Confirm: Deleting <?= $make ?></p>

<form method="POST">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="submit" value="Delete" name="delete">
        <a href="index.php">Cancel</a>
    </form>

</body>
</html>