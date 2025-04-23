<?php
ob_start();
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    include '../assets/conn/config.php';
    ?>

    <div class="dashboard-wrapper">
        <div class="dashboard-container">
            <h1>Velkommen, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h1>
            <a href="addProject.php">Tilføj Projekt</a>
            <a href="addBlog.php">Tilføj Blog</a>
            <a href="logout.php">Log ud</a>
        </div>
    </div>

    </body>

    </html>


    <?php
    /* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: signin.php");
    exit();
}
?>