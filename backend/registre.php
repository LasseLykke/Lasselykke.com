

<!DOCTYPE html>
<html lang="dk">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="1500;url=logout.php" />
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

    <form action="registreCheck.php" method="POST">
        <h2>Register</h2>
        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php } ?>
        <?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo htmlspecialchars($_GET['success']); ?></p>
        <?php } ?>
        <label>Name</label>
        <input type="text" name="name" placeholder="Name" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>"><br>
        <label>User name</label>
        <input type="text" name="uname" placeholder="User name" value="<?php echo isset($_GET['uname']) ? htmlspecialchars($_GET['uname']) : ''; ?>"><br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password"><br>
        <label>Re-enter Password</label>
        <input type="password" name="re_password" placeholder="Re-enter Password"><br>
        <button type="submit">Register</button>
        <a href="signin.php" class="ca">Already have an account?</a>
    </form>

</body>

</html>


