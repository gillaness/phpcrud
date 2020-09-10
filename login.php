<?php

    session_start();
    $failure = false;
    $user = '';
    $password = '';
    $salt = 'XyZzy12*_';
    $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

    if(isset($_POST['cancel'])){
        header("Location:index.php");
        return;
    }
    if(isset($_POST['email'])){

        unset($_SESSION['email']);

        $password = hash('md5',$salt.$_POST['pass']);

        if($password == '' || $_POST['email'] == ''){
           $_SESSION['failure'] = "User name and password are requered";
           error_log("Login fail: empty values ".$_POST['email']." $password");
           header("Location:login.php");
           return;
        }else if($password != $stored_hash){
            $_SESSION['failure'] = "Incorrect password";
            error_log("Login fail: wrong password ".$_POST['email']." $password");
            header("Location:login.php");
            return;
            }else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $_SESSION['failure'] = "Email must have an at-sign (@)";
                error_log("Login fail: ".$_POST['email']." $password"." ". $_SESSION['failure']);
                header("Location:login.php");
                return;
            }else{
                $_SESSION['email'] = $_POST['email'];
                error_log("Login success ".$_POST['email']);
                header("Location:index.php");
                return;
            }
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

<h2>Welcome my friend</h2>
    <h3>Please Log In</h3>

    <?php
    if ( isset($_SESSION['failure']) ) {
        echo "<p style='color:#F00;'>".htmlentities($_SESSION['failure'])."</p>\n";
    }
    unset($_SESSION['failure']);
    ?>

    <form method="post">

        <table>
            <tr>
                <td><label for="email">Email</label></td>
                <td><input type="text" name="email"></td>
            </tr>
            <tr>
                <td><label for="pass">Password</label></td>
                <td><input type="password" name="pass"></td>
            </tr>
        </table>
        
        <input type="submit" name="login" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
        
    
    </form>

    <p>If you don't know the password, check the source code</p>

    <!--Password is php123-->

</body>
</html>