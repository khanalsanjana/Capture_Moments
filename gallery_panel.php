<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'photography_portfolio');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle image upload
if (isset($_POST['upload_image'])) {
    $category_id = $_POST['category_id'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO images (category_id, image_path) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $category_id, $image);
        
        if ($stmt->execute()) {
            $message = "Image uploaded successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
    } else {
        $message = "Failed to upload image.";
    }
}

// Handle image deletion
if (isset($_GET['delete_image'])) {
    $image_id = $_GET['delete_image'];

    // Fetch the image file path from the database
    $stmt = $conn->prepare("SELECT image_path FROM images WHERE id = ?");
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $image = $result->fetch_assoc();
        $image_path = "uploads/" . $image['image_path'];

        if (file_exists($image_path)) {
            if (unlink($image_path)) {
                // Image file deleted
            } else {
                $message = "Failed to delete the file: " . $image_path;
            }
        }

        // Delete the image record from the database
        $stmt = $conn->prepare("DELETE FROM images WHERE id = ?");
        $stmt->bind_param("i", $image_id);
        if ($stmt->execute()) {
            $message = "Image deleted successfully!";
        } else {
            $message = "Error deleting record: " . $stmt->error;
        }
    } else {
        $message = "Image not found in the database.";
    }
}

// Handle category addition
if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];

    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $category_name);
    if ($stmt->execute()) {
        $message = "Category added successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
}

// Handle category edit
if (isset($_POST['edit_category'])) {
    $category_id = $_POST['category_id'];
    $new_category_name = $_POST['new_category_name'];

    $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $new_category_name, $category_id);
    if ($stmt->execute()) {
        $message = "Category updated successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
}

// Handle category deletion
if (isset($_GET['delete_category'])) {
    $category_id = $_GET['delete_category'];

    // Fetch image paths for the category to delete images from the server
    $stmt = $conn->prepare("SELECT image_path FROM images WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Delete each image file
    while ($image = $result->fetch_assoc()) {
        $image_path = "uploads/" . $image['image_path'];
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the image file
        }
    }

    // Delete the images from the database
    $stmt = $conn->prepare("DELETE FROM images WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();

    // Now delete the category
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $category_id);
    if ($stmt->execute()) {
        $message = "Category and associated images deleted successfully!";
    } else {
        $message = "Error deleting category: " . $stmt->error;
    }
}

// Fetch all categories for the dropdown and editing
$categories = $conn->query("SELECT * FROM categories");

// Fetch all images and their categories
$images = $conn->query("
    SELECT images.id, images.image_path, categories.name AS category_name 
    FROM images 
    LEFT JOIN categories ON images.category_id = categories.id
");

if ($images === FALSE) {
    die("Error fetching images: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 0;
            margin: 0;
        }

        .container {
            width: 80%;
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

        .form-container {
            margin-bottom: 40px;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-container input[type="file"],
        .form-container input[type="text"],
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }

        img {
            max-width: 100px;
            border-radius: 8px;
        }

        .delete-link {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }

        .delete-link:hover {
            text-decoration: underline;
        }

        .edit-link {
            color: blue;
            text-decoration: none;
        }

        .edit-link:hover {
            text-decoration: underline;
        }

        /* Small box styles */
        .action-box {
            display: inline-block;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin: 5px;
        }
    </style>
</head>
<body>
<a href="admin_panel.php">Go to Admin Panel</a>
    <div class="container">
        <h1>Admin Panel - Manage Gallery & Categories</h1>

        <!-- Message after uploading or deleting -->
        <?php if (isset($message)) { ?>
            <div class="message"><?= $message ?></div>
        <?php } ?>

        <!-- Category Addition Form -->
        <div class="form-container">
            <h2>Add New Category</h2>
            <form method="POST">
                <label for="category_name">Category Name:</label>
                <input type="text" name="category_name" required>
                <button type="submit" name="add_category">Add Category</button>
            </form>
        </div>

        <!-- Category Editing Form -->
        <div class="form-container">
            <h2>Edit Existing Category</h2>
            <form method="POST">
                <label for="category_id">Select Category:</label>
                <select name="category_id" required>
                    <option value="">Select a category</option>
                    <?php 
                    // Reset pointer to fetch categories again for the edit form
                    $categories->data_seek(0);
                    while ($row = $categories->fetch_assoc()) { ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                    <?php } ?>
                </select>

                <label for="new_category_name">New Category Name:</label>
                <input type="text" name="new_category_name" required>
                <button type="submit" name="edit_category">Edit Category</button>
            </form>
        </div>

       

        <!-- Image Upload Form -->
        <div class="form-container">
            <h2>Upload Image</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="category_id">Select Category:</label>
                <select name="category_id" required>
                    <option value="">Select a category</option>
                    <?php 
                    // Reset pointer to fetch categories again for the upload form
                    $categories->data_seek(0);
                    while ($row = $categories->fetch_assoc()) { ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                    <?php } ?>
                </select>

                <label for="image">Select Image:</label>
                <input type="file" name="image" accept="image/*" required>
                <button type="submit" name="upload_image">Upload Image</button>
            </form>
        </div>

        <!-- Display Images and Categories -->
        <h2>Gallery</h2>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($image = $images->fetch_assoc()) { ?>
                    <tr>
                        <td><img src="uploads/<?= $image['image_path'] ?>" alt="Image"></td>
                        <td><?= $image['category_name'] ?></td>
                        <td>
                            <div class="action-box">
                                <a class="delete-link" href="?delete_image=<?= $image['id'] ?>">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Display Categories -->
        <h2>Categories</h2>
        <table>
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Reset pointer to fetch categories again for display
                $categories->data_seek(0);
                while ($category = $categories->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $category['id'] ?></td>
                        <td><?= $category['name'] ?></td>
                        <td>
                            <div class="action-box">
                               
                                <a class="delete-link" href="?delete_category=<?= $category['id'] ?>">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
