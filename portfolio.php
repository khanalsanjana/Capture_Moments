<?php
require 'db_config.php';

// Get photographer ID from URL
$photographer_id = $_GET['id'];

// Fetch photographer data based on ID
$query = "SELECT * FROM photographers WHERE id = $photographer_id";
$result = mysqli_query($conn, $query);
$photographer = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($photographer['name']); ?>'s Portfolio - Captured Moments</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eaeaea;
            padding: 20px;
        }
        .container {
            display: flex; /* Use flexbox for layout */
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .left-section {
            flex: 1; /* Allow left section to grow */
            padding-right: 20px; /* Add space between sections */
        }
        .photographer-img {
            width: 100%;
            height: 350px; /* Adjusted height for better appearance */
            object-fit: cover;
            border-radius: 12px;
            border: 3px solid #4A90E2; /* Added a border */
        }
        .info-section {
            text-align: left; /* Align text to the left */
            margin-top: 10px; /* Added margin for spacing */
        }
        .info-section h1 {
            font-size: 1.8rem; /* Decreased font size */
            color: #4A90E2;
            margin: 5px 0; /* Reduced margin */
        }
        .info-section p {
            font-size: 1rem; /* Decreased font size */
            margin: 0; /* Removed margin for better alignment */
            color: #555; /* Darker color for better readability */
        }
        .right-section {
            flex: 2; /* Allow right section to take more space */
        }
        .description {
            margin-top: 20px;
            font-size: 1.1rem; /* Increased font size for better readability */
            line-height: 1.8; /* Improved line height */
            color: #333; /* Darker color for the description */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-section">
            <img class="photographer-img" src="uploads/<?php echo htmlspecialchars($photographer['image']); ?>" alt="<?php echo htmlspecialchars($photographer['name']); ?>">
            <div class="info-section">
                <h1><?php echo htmlspecialchars($photographer['name']); ?></h1>
                <p><strong>Award:</strong> <?php echo htmlspecialchars($photographer['role']); ?></p>
            </div>
        </div>
        <div class="right-section">
            <div class="description">
                <p><?php echo htmlspecialchars($photographer['description']); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
