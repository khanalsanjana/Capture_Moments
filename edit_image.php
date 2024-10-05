<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'photography_portfolio');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle image editing
if (isset($_POST['update_image'])) {
    $image_id = $_POST['image_id'];
    $category_id = $_POST['category_id'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    // Update the image path if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $stmt = $conn->prepare("SELECT image_path FROM images WHERE id = ?");
        $stmt->bind_param("i", $image_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $old_image = $result->fetch_assoc()['image_path'];
        $old_image_path = "uploads/" . $old_image;

        // Remove the old image file if it exists
        if (file_exists($old_image_path)) {
            unlink($old_image_path);
        }

        // Move the new image to the uploads directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // Update the database
            $stmt = $conn->prepare("UPDATE images SET category_id = ?, image_path = ? WHERE id = ?");
            $stmt->bind_param("isi", $category_id, $image, $image_id);
            $message = $stmt->execute() ? "Image updated successfully!" : "Error: " . $stmt->error;
        } else {
            $message = "Failed to upload new image.";
        }
    } else {
        // If no new image is uploaded, just update the category
        $stmt = $conn->prepare("UPDATE images SET category_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $category_id, $image_id);
        $message = $stmt->execute() ? "Category updated successfully!" : "Error: " . $stmt->error;
    }
}

// Fetch image details for editing
if (isset($_GET['id'])) {
    $image_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM images WHERE id = ?");
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $image = $result->fetch_assoc();

    // Fetch all categories for the dropdown
    $categories = $conn->query("SELECT * FROM categories");
} else {
    die("No image ID provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Image</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 0;
            margin: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .message {
            text-align: center;
            color: green;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-container input[type="file"],
        .form-container select {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .form-container button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        img {
            max-width: 300px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<a href="gallery_panel.php">Back to Gallery Panel</a>
    <div class="container">
        <h1>Edit Image</h1>

        <!-- Message after updating -->
        <?php if (isset($message)) { ?>
            <div class="message"><?= $message ?></div>
        <?php } ?>

        <!-- Edit Image Form -->
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="image_id" value="<?= $image['id'] ?>">
            <label for="category_id">Select Category:</label>
            <select name="category_id" required>
                <?php while ($row = $categories->fetch_assoc()) { ?>
                    <option value="<?= $row['id'] ?>" <?= $image['category_id'] == $row['id'] ? 'selected' : '' ?>>
                        <?= $row['name'] ?>
                    </option>
                <?php } ?>
            </select>
            
            <label for="image">Select New Image (leave blank to keep current):</label>
            <input type="file" name="image">

            <button type="submit" name="update_image">Update Image</button>
        </form>

        <h2>Current Image:</h2>
        <img src="uploads/<?= $image['image_path'] ?>" alt="Current Image">
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
