<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'photography_portfolio');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all categories
$categories = $conn->query("SELECT * FROM categories");

// Fetch images based on the selected category or fetch all if none is selected
$selected_category = isset($_GET['category_id']) ? $_GET['category_id'] : null;
if ($selected_category) {
    $images = $conn->query("SELECT * FROM images WHERE category_id = '$selected_category'");
} else {
    $images = $conn->query("SELECT * FROM images");
}

// Debugging: Check if images are fetched
if (!$images) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: lavender;
        }

        header {
            background-color: #333;
            color: #fff;
            
        }

        /* .navbar h1 {
            font-size: 2rem;
            margin: 0;
        }

        .navbar nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar nav ul li {
            margin-left: 20px;
        }

        .navbar nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 1.1rem;
            padding: 5px 10px;
            transition: background-color 0.3s ease;
        }

        .navbar nav ul li a:hover {
            background-color: #555;
            border-radius: 5px;
        } */

        .card {
            border: none;
            overflow: hidden;
        }

        .card-img-top {
            object-fit: cover; /* Ensure images cover the area */
            height: 300px; /* Set a fixed height */
        }

        .gallery-title {
            font-size: 1.5rem; /* Adjust title size */
            color: #333;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Capture Moment</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav" style="position: absolute; right: 20px;">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="gallery.php">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="services.php">Experiences and Skills</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Admin</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <h1>Gallery</h1>

        <!-- Category Filter Buttons -->
        <div class="text-center mb-4">
            <a href="gallery.php" class="btn btn-outline-primary m-1">All</a>
            <?php while ($category = $categories->fetch_assoc()) { ?>
                <a href="?category_id=<?php echo $category['id']; ?>" class="btn btn-outline-primary m-1">
                    <?php echo $category['name']; ?>
                </a>
            <?php } ?>
        </div>

        <!-- Responsive Image Gallery -->
        <div class="row">
            <?php if ($images->num_rows > 0) {
                while ($image = $images->fetch_assoc()) {
                    // Use the correct key for image path
                    if (isset($image['image_path'])) {
                        $image_path = "uploads/" . $image['image_path'];
                        // Check if image exists
                        if (!file_exists($image_path) || empty($image['image_path'])) {
                            $image_path = "uploads/default.jpg"; // Fallback image
                        }
                        ?>
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="card">
                                <img src="<?php echo $image_path; ?>" class="card-img-top img-fluid" alt="Gallery Image">
                                <div class="card-body">
                                    <?php if (isset($image['title']) && !empty($image['title'])) { ?>
                                        <h5 class="gallery-title"><?php echo $image['title']; ?></h5>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="card">
                                <img src="uploads/default.jpg" class="card-img-top img-fluid" alt="Fallback Image">
                                <div class="card-body">
                                    <h5 class="gallery-title">No Image Available</h5>
                                </div>
                            </div>
                        </div>
                    <?php }
                }
            } else { ?>
                <p class="text-center">No images available for this category.</p>
            <?php } ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
