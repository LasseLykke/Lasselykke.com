<?php
include './assets/conn/config.php';
include './assets/include/nav.php';

// Hent alle projekter fra databasen
$sql = "SELECT id, title, short_description, tags FROM projects ORDER BY createdAt DESC";
$result = $conn->query($sql);
$projects = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Projects - Lasse Lykke</title>
</head>
<body>
    <div class="wrapper">
    <div class="allProjectWrapper">
        <section class="breadcrumbs">
            <p>projects / <span>all</span></p>
        </section>
        
        <?php foreach ($projects as $project): ?>
            <div class="project-card">
                <h2><?php echo htmlspecialchars($project['title']); ?></h2>
                <p><strong>Tech:</strong> <?php echo htmlspecialchars($project['tags']); ?></p>
                <p><?php echo nl2br(htmlspecialchars($project['short_description'])); ?></p>
                <a href="singleProject.php?id=<?php echo $project['id']; ?>" class="read-more">Read More</a>
                <hr>
                
            </div>
        <?php endforeach; ?>
    </div>
    </div>
</body>
<script src="./assets/style/script.js"></script>
</html>
