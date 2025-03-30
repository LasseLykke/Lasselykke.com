<?php 
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
include '../assets/conn/config.php';

?>


<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tilføj Projekt</title>
</head>
<body>
    <h2>Tilføj nyt projekt</h2>
    <form action="uploadProjectHandler.php" method="POST" enctype="multipart/form-data">
        <label for="title">Titel:</label>
        <input type="text" name="title" required>

        <label for="short_description">Kort beskrivelse:</label>
        <textarea name="short_description" required></textarea>

        <label for="long_description">Lang beskrivelse:</label>
        <textarea name="long_description" required></textarea>

        <label for="tags">Tags (kommasepareret):</label>
        <input type="text" name="tags">

        <label for="images">Upload billeder (max 10):</label>
        <input type="file" name="images[]" multiple accept="image/*" required>

        <button type="submit">Tilføj Projekt</button>
    </form>
</body>
</html>

<?php
} else {
    header("Location: index.php");
    exit();
}
?>


