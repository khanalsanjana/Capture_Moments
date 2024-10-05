<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Captured Moments</title>
    <style>
        /* style.css */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative; /* Added for positioning the link */
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 2.5rem;
            color: #4A90E2;
            position: absolute;
            top: 5rem;
        }

        section {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            color: #333;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #4A90E2;
            outline: none;
        }

        button[type="submit"] {
            padding: 10px;
            background-color: #4A90E2;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #357ABD;
        }

        .go-back {
            position: absolute; /* Absolute positioning for the "Go Back" link */
            top: 20px; /* Adjust the top position as needed */
            left: 20px; /* Adjust the left position as needed */
            font-size: 1rem;
            color: #4A90E2;
            text-decoration: none; /* Remove underline */
            transition: color 0.3s ease;
        }

        .go-back:hover {
            color: #357ABD; /* Change color on hover */
        }

        /* Error message style */
        .error-message {
            color: red;
            margin-top: 15px;
            text-align: center;
        }

        @media (max-width: 500px) {
            section {
                padding: 15px;
            }

            header h1 {
                font-size: 2rem;
            }

            button[type="submit"] {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <a href="index.php" class="go-back">Go Back</a> <!-- "Go Back" link -->

    <header>
        <h1>Admin Login</h1>
    </header>
    <section>
        <form action="login_process.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>

            <?php if (isset($_GET['error'])): ?>
                <div class="error-message">Incorrect password.</div>
            <?php endif; ?>

            <button type="submit">Login</button>
        </form>
    </section>
</body>
</html>
