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
    <div class="contentWrapper">
        <section class="breadcrumbs">
            <p>projects / <span>all</span></p>
        </section>
        <div class="wrapper">

            <div class="allProjectWrapper">

                <?php foreach ($projects as $project): ?>
                    <?php
                    // Hent det første billede for hvert projekt
                    $sql_image = "SELECT image_path FROM project_images WHERE project_id = ? ORDER BY uploaded_at ASC LIMIT 1";
                    $stmt_image = $conn->prepare($sql_image);
                    $stmt_image->bind_param('i', $project['id']);
                    $stmt_image->execute();
                    $result_image = $stmt_image->get_result();
                    $first_image = $result_image->fetch_assoc();
                    ?>

                    <div class="project-card">
                        <h2><?php echo htmlspecialchars($project['title']); ?></h2>
                        <p><strong>Tech used:</strong> <?php echo htmlspecialchars($project['tags']); ?></p>
                        <?php if ($first_image): ?>
                            <img src="<?php echo htmlspecialchars($first_image['image_path']); ?>"
                                alt="CoverImages <?php echo htmlspecialchars($project['title']); ?>" class="project-image">
                        <?php endif; ?>
                        <p><?php echo nl2br(htmlspecialchars($project['short_description'])); ?></p>
                        <a href="singleProject.php?id=<?php echo $project['id']; ?>" class="read-more">Read More</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
<script src="./assets/style/script.js"></script>

</html>