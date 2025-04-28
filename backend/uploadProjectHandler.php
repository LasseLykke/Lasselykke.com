<?php
require '../assets/conn/config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $short_description = $_POST['short_description'];
    $long_description = $_POST['long_description'];
    $tags = $_POST['tags'];

    // Hvilket billede er valgt som hero?
    $hero_index = isset($_POST['hero_image']) ? (int)$_POST['hero_image'] : -1;

    $stmt = $conn->prepare("INSERT INTO projects (title, short_description, long_description, tags) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $short_description, $long_description, $tags);

    if ($stmt->execute()) {
        $project_id = $stmt->insert_id;
        $stmt->close();

        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if (!empty($tmp_name)) {
                $file_name = uniqid() . "_" . $_FILES['images']['name'][$key];
                $target_file = $upload_dir . $file_name;

                if (compressImage($tmp_name, $target_file, 1080)) {
                    $comment = !empty($_POST['image_comments'][$key]) ? $_POST['image_comments'][$key] : NULL;

                    // Check om dette billede er valgt som hero
                    $is_hero = ($key === $hero_index) ? 1 : 0;

                    $stmt_img = $conn->prepare("INSERT INTO project_images (project_id, image_path, comment, is_hero) VALUES (?, ?, ?, ?)");
                    $stmt_img->bind_param("issi", $project_id, $target_file, $comment, $is_hero);
                    $stmt_img->execute();
                    $stmt_img->close();
                }
            }
        }

        echo "Projekt og billeder tilføjet!";
    } else {
        echo "Fejl ved indsættelse af projekt: " . $stmt->error;
    }

    $conn->close();
}

// Funktion til at komprimere og gemme billedet
function compressImage($source, $destination, $max_width) {
    $info = getimagesize($source);
    if (!$info) return false;

    switch ($info['mime']) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        default:
            return false; // Kun JPG/PNG understøttes
    }

    // Beregn ny størrelse
    $orig_width = imagesx($image);
    $orig_height = imagesy($image);
    $new_width = min($max_width, $orig_width);
    $new_height = ($orig_height / $orig_width) * $new_width;

    $new_width = round($new_width);
    $new_height = round($new_height);

    $resized_image = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($resized_image, $image, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);

    // Gem det komprimerede billede
    imagejpeg($resized_image, $destination, 80); // 80% kvalitet
    imagedestroy($image);
    imagedestroy($resized_image);

    return true;
}
?>
