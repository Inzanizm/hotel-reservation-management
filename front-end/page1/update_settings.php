<?php
include('initialize.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input data
    $resort_name = htmlspecialchars(trim($_POST['resort_name']));
    $hero_heading = htmlspecialchars(trim($_POST['hero_heading']));
    $book_now_link = filter_var(trim($_POST['book_now_link']), FILTER_SANITIZE_URL);
    $view_packages_link = filter_var(trim($_POST['view_packages_link']), FILTER_SANITIZE_URL);

    // Validate URL format for links
    if (!filter_var($book_now_link, FILTER_VALIDATE_URL)) {
        die('Invalid Book Now link URL.');
    }

    if (!filter_var($view_packages_link, FILTER_VALIDATE_URL)) {
        die('Invalid View Packages link URL.');
    }

    // Handle logo image upload
    $logo_image = 'WEBSITE IMG/Logo.png'; // Default logo if no upload
    if (isset($_FILES['logo_image']) && $_FILES['logo_image']['error'] == 0) {
        $upload_dir = 'WEBSITE IMG/';
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif']; // Allowed image types
        $file_type = mime_content_type($_FILES['logo_image']['tmp_name']);

        // Check if the file type is allowed
        if (in_array($file_type, $allowed_types)) {
            // Ensure the directory exists or create it
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
            }

            // Create a unique file name to avoid overwriting
            $file_name = uniqid('logo_', true) . '.' . pathinfo($_FILES['logo_image']['name'], PATHINFO_EXTENSION);
            $upload_file = $upload_dir . $file_name;

            // Attempt to move the uploaded file
            if (move_uploaded_file($_FILES['logo_image']['tmp_name'], $upload_file)) {
                $logo_image = $upload_file;
            } else {
                die('Error: Could not move uploaded file.');
            }
        } else {
            die('Error: Invalid file type. Only JPEG, PNG, and GIF are allowed.');
        }
    }

    // Update settings in the settings file
    $settings = [
        'resort_name' => $resort_name,
        'hero_heading' => $hero_heading,
        'book_now_link' => $book_now_link,
        'view_packages_link' => $view_packages_link,
        'logo_image' => $logo_image
    ];

    if (file_put_contents('settings.txt', json_encode($settings, JSON_PRETTY_PRINT)) === false) {
        die('Error: Failed to save settings.');
    }

    // Redirect back with success message
    header("Location: settings.php?status=success");
    exit();
}
?>
