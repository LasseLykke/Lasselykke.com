<?php
session_start();
include("../assets/conn/config.php");

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $password = validate($_POST['password']);

    if (empty($uname)) {
        header("location: index.php?error=Brugernavn er påkrævet");
        exit();
    } else if (empty($password)) {
        header("location: index.php?error=Password er påkrævet");
        exit();
    } else {
        // Hent brugerens adgangskode fra databasen
        $sql = "SELECT * FROM users WHERE user_name = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $stored_password = $row['password'];

            // Hvis adgangskoden er gemt med MD5, skal brugeren opdatere den
            if (strlen($stored_password) == 32) { // MD5 hashes er altid 32 tegn lange
                if (md5($password) === $stored_password) {
                    // Opgrader brugeren til bcrypt
                    $new_hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $update_sql = "UPDATE users SET password = ? WHERE user_name = ?";
                    $update_stmt = mysqli_prepare($conn, $update_sql);
                    mysqli_stmt_bind_param($update_stmt, "ss", $new_hashed_password, $uname);
                    mysqli_stmt_execute($update_stmt);
                    $stored_password = $new_hashed_password;
                } else {
                    header("Location: index.php?error=Forkert brugernavn eller password");
                    exit();
                }
            }

            // Tjek adgangskoden med password_verify()
            if (password_verify($password, $stored_password)) {
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['user_id'] = $row['user_id'];
                header("Location: dashboard.php"); 
                exit();
            } else {
                header("Location: index.php?error=Forkert brugernavn eller password");
                exit();
            }
        } else {
            header("Location: index.php?error=Forkert brugernavn eller password");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
