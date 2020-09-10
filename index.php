<?php
    session_start();
    require_once "pdo.php";

    $stmt = $pdo->query("SELECT make, model, year, mileage, auto_id FROM autos");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Germán Eduardo Illanes Salas</title>
</head>
<body>
    <h1>Welcome to Autos Database</h1>
    <?php
        if(!isset($_SESSION['email'])){

            echo "<p><a href='login.php'>Please log in</a></p>
            <p>Attempt to go to <a href='edit.php'>edit.php</a> without logging in - it should fail with an error message</p>
            <p>Attempt to go to <a href='add.php'>add.php</a> without logging in - it should fail with an error message</p>";

        }else{
            if(count($rows) == 0){
                echo "<p>No rows found</p>";
            }else{
                if ( isset($_SESSION['success']) ) {
                    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
                    unset($_SESSION['success']);
                }
                
                if ( isset($_SESSION['error']) ) {
                    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                    unset($_SESSION['error']);
                }
                echo 
                "<table border='1'>
                    <thead>
                        <tr>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>Mileage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";
                    foreach($rows as $row){
                        echo "<tr><td>";
                        echo(htmlentities($row['make']));
                        echo "</td><td>";
                        echo(htmlentities($row['model']));
                        echo "</td><td>";
                        echo(htmlentities($row['year']));
                        echo "</td><td>";
                        echo(htmlentities($row['mileage']));
                        echo "</td><td>";
                        echo('<a href="edit.php?autos_id='.$row['auto_id'].'">Edit</a> / ');
                        echo('<a href="delete.php?autos_id='. $row['auto_id'].'">Delete</a>');
                        echo("</td></tr>\n");
                    }
                    echo "</tbody>
                    </table>";
            }
            echo "<p><a href='add.php'>Add New Entry</a></p>
            <p><a href='logout.php'>Logout</a></p>";


        }
    ?>
    
    
</body>
</html>