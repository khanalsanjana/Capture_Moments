<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'photography_portfolio');

// Check if an update request has been made
if (isset($_POST['update_photographer'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $role = $_POST['role'];
    $description = $_POST['description'];
    
    // Handle image update only if a new image is uploaded
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $sql = "UPDATE photographers SET name='$name', role='$role', description='$description', image='$image' WHERE id=$id";
    } else {
        $sql = "UPDATE photographers SET name='$name', role='$role', description='$description' WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Photographer updated successfully!";
        header("Location: admin_panel.php"); // Redirect to admin panel
    } else {
        echo "Error: " . $conn->error;
    }
}

// Check if an ID is passed via GET for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM photographers WHERE id = $id");
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Photographer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        form h2 {
            text-align: center;
            color: #333;
        }
        form label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }
        form input[type="text"],
        form textarea,
        form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        form button {
            display: block;
            background-color: #4A90E2;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        form button:hover {
            background-color: #357ABD;
        }
        .back-btn {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            background-color: #2ecc71;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .back-btn:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>

    <form method="POST" enctype="multipart/form-data">
        <h2>Edit Photographer</h2>
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        
        <label for="name">Photographer Name:</label>
        <input type="text" name="name" value="<?php echo $row['name']; ?>" required>

        <label for="role">Role:</label>
        <input type="text" name="role" value="<?php echo $row['role']; ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" required><?php echo $row['description']; ?></textarea>

        <label for="image">Upload New Image (optional):</label>
        <input type="file" name="image">

        <button type="submit" name="update_photographer">Update Photographer</button>
        <a href="admin_panel.php" class="back-btn">Back to Admin Panel</a>
    </form>

</body>
</html>
