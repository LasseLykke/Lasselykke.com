<?php
require '../assets/conn/config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $short_description = $_POST['short_description'];
    $long_description = $_POST['long_description'];
    $tags = $_POST['tags'];

    // Indsæt projektet i databasen
    $stmt = $conn->prepare("INSERT INTO projects (title, short_description, long_description, tags) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $short_description, $long_description, $tags);

    if ($stmt->execute()) {
        $project_id = $stmt->insert_id; // Hent ID på det indsatte projekt
        $stmt->close();

        $upload_dir = '../uploads/'; // Sørg for, at denne mappe eksisterer
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Håndtering af billedupload
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if (!empty($tmp_name)) { // Kun hvis der faktisk er et billede uploadet
                $file_name = uniqid() . "_" . $_FILES['images']['name'][$key];
                $target_file = $upload_dir . $file_name;

                // Komprimer og gem billede
                if (compressImage($tmp_name, $target_file, 1080)) {
                    // Hent tilsvarende kommentar
                    $comment = !empty($_POST['image_comments'][$key]) ? $_POST['image_comments'][$key] : NULL;

                    // Indsæt billede i databasen
                    $stmt_img = $conn->prepare("INSERT INTO project_images (project_id, image_path, comment) VALUES (?, ?, ?)");
                    $stmt_img->bind_param("iss", $project_id, $target_file, $comment);
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
