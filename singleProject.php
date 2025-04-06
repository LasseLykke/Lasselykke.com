<?php
include './assets/conn/config.php';
include './assets/include/nav.php';

// Tjek om der er et projekt ID i URL'en
if (!isset($_GET['id'])) {
    die('Ingen projekt ID angivet.');
}

$project_id = intval($_GET['id']);

// Hent projektdata fra databasen
$sql = "SELECT * FROM projects WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $project_id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

if (!$project) {
    die('Projekt ikke fundet.');
}

// Hent billeder fra databasen
$sql_images = "SELECT image_path, comment FROM project_images WHERE project_id = ? ORDER BY uploaded_at ASC";
$stmt_images = $conn->prepare($sql_images);
$stmt_images->bind_param('i', $project_id);
$stmt_images->execute();
$result_images = $stmt_images->get_result();
$images = $result_images->fetch_all(MYSQLI_ASSOC);

// Håndter første billede separat
$first_image = array_shift($images);

// Hardcoded færdighedsprocenter pr. projekt
// 1,2,3 => er project id, dette skal altså rettes for hver nyt projekt. Men er bedre med et loop end kode det ind i db.
$skillLevels = [
    1 => ['PHP' => 70, 'JavaScript' => 50, 'HTML/CSS' => 90],
    2 => ['PHP' => 30, 'JavaScript' => 80],
    3 => ['HTML/CSS' => 100],
];


// Hent skills for det aktuelle projekt
$projectSkills = $skillLevels[$project_id] ?? [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo htmlspecialchars($project['title']); ?> - Lasse Lykke</title>
</head>

<body>
    <div class="projectWrapper">
        <h1><?php echo htmlspecialchars($project['title']); ?></h1>

        <p><strong>Tags:</strong> <?php echo htmlspecialchars($project['tags']); ?></p>

        <?php if ($first_image): ?>
            <img src="<?php echo htmlspecialchars($first_image['image_path']); ?>" alt="Projektbillede">
        <?php endif; ?>

        <p><?php echo nl2br(htmlspecialchars($project['long_description'])); ?></p>

        <?php foreach ($projectSkills as $skill => $percent): ?>
            <div class="label"><?php echo htmlspecialchars($skill); ?></div>
            <div class="progress-container">
                <div class="progress-bar" data-percent="<?php echo $percent; ?>"><?php echo $percent; ?>%</div>
            </div>
        <?php endforeach; ?>

        <?php foreach ($images as $image): ?>
            <img src="<?php echo htmlspecialchars($image['image_path']); ?>" alt="Projektbillede">
            <?php if (!empty($image['comment'])): ?>
                <p><?php echo htmlspecialchars($image['comment']); ?></p>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</body>
<script src="./assets/style/script.js"></script>

</html>