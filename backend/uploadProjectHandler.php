<?php
require '../assets/conn/config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $short_description = $_POST['short_description'];
    $long_description = $_POST['long_description'];
    $tags = $_POST['tags'];

    $upload_dir = 'uploads/';
    $image_paths = [];

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Håndtering af billedupload
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if ($key >= 10) break; // Maks 10 billeder

            $file_name = uniqid() . "_" . $_FILES['images']['name'][$key];
            $target_file = $upload_dir . $file_name;

            // Komprimer og gem billede
            if (compressImage($tmp_name, $target_file, 1080)) {
                $image_paths[] = $target_file;
            }
        }
    }

    // Gem stier i JSON-format
    $image_paths_json = json_encode($image_paths);

    // Indsæt data i databasen med MySQLi
    $stmt = $conn->prepare("INSERT INTO projects (title, short_description, long_description, tags, image_paths) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $short_description, $long_description, $tags, $image_paths_json); // Bind parametre

    if ($stmt->execute()) {
        echo "Projekt tilføjet!";
    } else {
        echo "Fejl ved indsættelse af projekt: " . $stmt->error;
    }

    $stmt->close();
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

    // Runder værdierne af til heltal for at undgå fejlen
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
