<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'photography_portfolio');

// Fetch all photographers
$result = $conn->query("SELECT * FROM photographers");
$photographers = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Photographers</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            /* padding: 10px 0; */
        }

        /* .navbar {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .navbar h1 {
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

        .photographer-card {
            background-color: white;
            margin: 20px 0;
            padding: 30px; /* Increased padding for a more spacious look */
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s, background-color 0.3s; /* Transition for hover effect */
            width: 100%; /* Full width of the column */
            max-width: 300px; /* Set a max width for uniformity */
        }

        .photographer-card img {
            width: 120px; /* Uniform image size */
            height: 120px; /* Uniform image size */
            border-radius: 50%;
            margin-bottom: 15px; /* Space between image and text */
        }

        .view-portfolio {
            background-color: #4A90E2;
            color: white;
            padding: 10px 15px; /* Adjusted padding for button */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s; /* Transition for button */
        }

        .view-portfolio:hover {
            background-color: #357ABD;
        }

        .photographer-card:hover {
            transform: translateY(-5px); /* Lift the card on hover */
            background: linear-gradient(135deg, rgba(74, 144, 226, 0.7), rgba(255, 182, 193, 0.7)); /* Mixed color on hover */
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
                            <a class="nav-link" href="gallery.php">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="services.php">Experiences and Skills</a>
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
    <div class="container mt-4">
        <h1 class="text-center mb-4">Our Photographers</h1>
        <div class="row">
            <?php foreach ($photographers as $photographer) : ?>
                <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="photographer-card">
                        <img src="uploads/<?php echo $photographer['image']; ?>" alt="Photographer Image">
                        <h3><?php echo $photographer['name']; ?></h3>
                        <p><?php echo $photographer['role']; ?></p>
                        <a href="portfolio.php?id=<?php echo $photographer['id']; ?>" class="view-portfolio">View Portfolio</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
