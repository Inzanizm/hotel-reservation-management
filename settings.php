<!-- <?php include('includes/header.php'); ?>

<div class="container mt-4">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Website Settings</h3>
            <div class="add-user-button">
                <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus"></i> Add User
                </a>
            </div>
        </div>
        <div class="card-body">

        </div>
    </div>
</div>

Optional CSS
<style>
    .table td, .table th {
        vertical-align: middle;
    }
    a.text-primary:hover, a.text-danger:hover {
        opacity: 0.7;
        transition: 0.2s ease;
    }
    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #007bff;
    }
    .add-user-button {
        padding-top: 3px;
        left: 357px;
        position: relative;
    }
</style> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Website Settings</title>
</head>

<body>
    <div class="container">
        <h1>Edit Website Settings</h1>

        <form action="update_settings.php" method="POST" enctype="multipart/form-data">
            <!-- Resort Name -->
            <label for="resort_name">Resort Name:</label>
            <input type="text" id="resort_name" name="resort_name" value="Resort Name" required />

            <!-- Logo Image -->
            <label for="logo_image">Logo Image (Upload new image):</label>
            <input type="file" id="logo_image" name="logo_image" />

            <!-- Hero Heading -->
            <label for="hero_heading">Hero Heading Text:</label>
            <input type="text" id="hero_heading" name="hero_heading" value="HEADING" required />

            <!-- Button Links -->
            <label for="book_now_link">Book Now Button Link:</label>
            <input type="url" id="book_now_link" name="book_now_link" value="../page2/index.php" />

            <label for="view_packages_link">View Packages Button Link:</label>
            <input type="url" id="view_packages_link" name="view_packages_link" value="#Packages" />

            <input type="submit" value="Save Changes" />
        </form>
    </div>
</body>
</html>
