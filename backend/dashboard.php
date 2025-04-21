<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    include '../assets/conn/config.php';
    ?>

<a href="addProject.php">Add addProject</a>


<a href="logout.php">Log ud</a>


<?php
    /* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: signin.php");
    exit();
}
?>