<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Updated Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Photography</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav" style="position: absolute; right: 20px;">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Experiences and Skills</a></li>
                    <li class="nav-item active"><a class="nav-link" href="contact.php">Contact Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Admin</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <h1>Contact Us</h1>
        <!-- Form with validation -->
        <form action="submit_contact.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                <small id="nameError" class="text-danger"></small>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                <small id="emailError" class="text-danger"></small>
            </div>
            
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your message" required></textarea>
                <small id="messageError" class="text-danger"></small>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

    <!-- Client-side validation -->
    <script>
        function validateForm() {
            let isValid = true;

            // Clear previous error messages
            document.getElementById('nameError').innerText = '';
            document.getElementById('emailError').innerText = '';
            document.getElementById('messageError').innerText = '';

            // Validate name: should not be less than 2 characters or contain numbers
            let name = document.getElementById('name').value;
            let namePattern = /^[a-zA-Z\s]+$/;
            if (name.length < 2) {
                document.getElementById('nameError').innerText = 'Name must be at least 2 characters long.';
                isValid = false;
            } else if (!namePattern.test(name)) {
                document.getElementById('nameError').innerText = 'Name should only contain letters and spaces.';
                isValid = false;
            }

            // Validate email format
            let email = document.getElementById('email').value;
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                document.getElementById('emailError').innerText = 'Please enter a valid email address.';
                isValid = false;
            }

            // Validate message length
            let message = document.getElementById('message').value;
            if (message.length < 10) {
                document.getElementById('messageError').innerText = 'Message must be at least 10 characters long.';
                isValid = false;
            }

            return isValid;  // Return false if validation fails
        }
    </script>
</body>
</html>
