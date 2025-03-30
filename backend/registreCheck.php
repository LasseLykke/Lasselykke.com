<?php
include("../assets/conn/config.php");

if (
    isset($_POST['uname']) && isset($_POST['password'])
    && isset($_POST['name']) && isset($_POST['re_password'])
) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $password = validate($_POST['password']);
    $name = validate($_POST['name']);
    $re_password = validate($_POST['re_password']);

    $user_data = 'uname=' . urlencode($uname) . '&name=' . urlencode($name);

    if (empty($uname)) {
        header("Location: reg.php?error=User name is required&$user_data");
        exit();
    } else if (empty($password)) {
        header("Location: reg.php?error=Password is required&$user_data");
        exit();
    } else if (empty($name)) {
        header("Location: reg.php?error=Name is required&$user_data");
        exit();
    } else if (empty($re_password)) {
        header("Location: reg.php?error=Re_password is required&$user_data");
        exit();
    } else if ($password !== $re_password) {
        header("Location: reg.php?error=The confirmation password does not match&$user_data");
        exit();
    } else {
        // Hash adgangskoden med bcrypt
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Tjek om brugernavnet allerede findes
        $sql = "SELECT * FROM users WHERE user_name = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            header("Location: reg.php?error=The username is taken. Try another.&$user_data");
            exit();
        } else {
            // Indsæt brugeren i databasen
            $sql2 = "INSERT INTO users (user_name, password, name) VALUES (?, ?, ?)";
            $stmt2 = mysqli_prepare($conn, $sql2);
            mysqli_stmt_bind_param($stmt2, "sss", $uname, $hashed_password, $name);
            $result2 = mysqli_stmt_execute($stmt2);

            if ($result2) {
                header("Location: reg.php?success=Your account has been created successfully.");
                exit();
            } else {
                header("Location: reg.php?error=Unknown error occurred&$user_data");
                exit();
            }
        }
    }
} else {
    header("Location: reg.php");
    exit();
}
