<?php 
include '../assets/conn/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lasse Lykke</title>
</head>
<body>
    <div class="loginWrapper">
    <form class="loginform" action="login.php" method="POST">
        
    
    <?php /*Udgiver fejlmedelelse */
        if(isset($_GET['error'])) {?>
        <p class="error"><?php echo $_GET['error']; ?></p>

    <?php }?>


    <div class="loginarea">
    <h1>Enter login</h1><br>
        <div class="user-name">
            <label for="">Brugernavn</label>
            <input type="text" name="uname" placeholder="Username">
        </div>
        <div class="user-pass">
            <label for="">Password</label>
            <input type="password" name="password" placeholder="Password">
        </div>
        <button class="loginBtn" type="submit">Login</button><br>
    </div>
        </form>
    </div>
     
</body>
</html>