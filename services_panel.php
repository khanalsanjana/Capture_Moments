<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'photography_portfolio');

// Check if a delete request has been made
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Fetch the image file path before deletion
    $result = $conn->query("SELECT image FROM photographers WHERE id = $id");
    $row = $result->fetch_assoc();

    if ($row && !empty($row['image'])) {  // Ensure the image exists
        $imagePath = 'uploads/' . $row['image'];
        
        // Delete the photographer from the database
        $sql = "DELETE FROM photographers WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            // Delete the image file if it exists
            if (file_exists($imagePath) && is_file($imagePath)) {
                unlink($imagePath); // Delete the image file from the server
            }
            echo "Photographer deleted successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } 
}

// Add photographer functionality
if (isset($_POST['add_photographer'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    // Insert into database
    $sql = "INSERT INTO photographers (name, role, image, description) VALUES ('$name', '$role', '$image', '$description')";
    
    if ($conn->query($sql) === TRUE && move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        echo "Photographer added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Photographers</title>
    <style>
        /* Styles for the form and table */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 10px;
            margin: 0;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: 20px auto;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        form label, form input, form textarea {
            display: block;
            width: 100%;
            margin-bottom: 20px;
        }
        form button {
            background-color: #4A90E2;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #357ABD;
        }
        table {
            width: 100%;
            margin-top: 20px;
            background-color: #fff;
            border-collapse: collapse;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4A90E2;
            color: white;
        }
        .delete-btn {
            background-color: #E74C3C;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }
        .delete-btn:hover {
            background-color: #C0392B;
        }
        .edit-btn {
        background-color: #F39C12;
        color: white;
        padding: 5px 10px;
        border: none;
        cursor: pointer;
        border-radius: 3px;
        margin-right: 10px;
        }

        .edit-btn:hover {
            background-color: #D68910;
        }

    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <h2>Add New Photographer</h2>
        <label for="name">Photographer Name:</label>
        <input type="text" name="name" required>

        <label for="role">Role:</label>
        <input type="text" name="role" required>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea>

        <label for="image">Upload Image:</label>
        <input type="file" name="image" required>

        <button type="submit" name="add_photographer">Add Photographer</button>
    </form>

    <!-- Display list of photographers with delete option -->
    <h2>Manage Photographers</h2>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Role</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch all photographers from the database
            $result = $conn->query("SELECT * FROM photographers");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><img src='uploads/" . $row['image'] . "' width='100'></td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['role'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>
                    <a class='edit-btn' href='edit_photographer.php?id=" . $row['id'] . "'>Edit</a>
                    <a class='delete-btn' href='?delete=" . $row['id'] . "'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
