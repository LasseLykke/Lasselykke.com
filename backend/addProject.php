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
    <style>
        .image-upload-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
        }
        .image-upload {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
    </style>
</head>
<body>
<div class="form-wrapper">
    <div class="form-container">
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

            <h3>Upload op til 10 billeder</h3>
            <div class="image-upload-container">
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <div class="image-upload">
                        <label for="image<?php echo $i; ?>">Billede <?php echo $i; ?>:</label>
                        <input type="file" name="images[]" accept="image/*">
                        <input type="text" name="image_comments[]" placeholder="Kommentar til billede <?php echo $i; ?>">
                    </div>
                <?php endfor; ?>
            </div>

            <button class="loginBtn" type="submit">Tilføj Projekt</button>
        </form>
    </div>
</div>
</body>
</html>

<?php
} else {
    header("Location: index.php");
    exit();
}
?>
