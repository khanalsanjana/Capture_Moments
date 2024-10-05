<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Captured Moments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        .navbar {
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
        }

        .description {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .description h2 {
            font-size: 2rem;
            color: #4A90E2;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .gallery img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .contact-details {
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .contact-details h2 {
            font-size: 1.8rem;
            color: #4A90E2;
            margin-bottom: 10px;
        }

        .contact-details p {
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .booking-form {
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .booking-form h2 {
            font-size: 1.8rem;
            color: #4A90E2;
            margin-bottom: 20px;
        }

        .booking-form form {
            display: grid;
            gap: 15px;
        }

        .booking-form label {
            font-size: 1.1rem;
        }

        .booking-form input, .booking-form select, .booking-form textarea {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        .booking-form button {
            padding: 10px 20px;
            font-size: 1.1rem;
            background-color: #4A90E2;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .booking-form button:hover {
            background-color: #357ABD;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: #fff;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<header>
        <div class="navbar">
            <h1>About Us</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="login.php">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="description">
        <h2>About Captured Moments</h2>
        <p>At Captured Moments, we believe in the power of photography to capture the most cherished memories. Our team of professional photographers is dedicated to providing the best services to make every moment unforgettable.</p>
    </div>

    <div class="gallery">
        <img src="gallery/photo1.jpg" alt="Gallery Photo 1">
        <img src="gallery/photo2.jpg" alt="Gallery Photo 2">
        <img src="gallery/photo3.jpg" alt="Gallery Photo 3">
        <img src="gallery/photo4.jpg" alt="Gallery Photo 4">
        <img src="gallery/photo5.jpg" alt="Gallery Photo 5">
        <img src="gallery/photo6.jpg" alt="Gallery Photo 6">
    </div>

    <div class="contact-details">
        <h2>Contact Us</h2>
        <p>Email: capturemmt@gmail.com</p>
        <p>Phone: 9803383838</p>
        <p>Location: 123 Photography St., City, Country</p>
    </div>

    <div class="booking-form">
        <h2>Book a Photographer</h2>
        <form action="booking_process.php" method="POST">
            <label for="email">Your Email Address:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="photographer">Which Photographer Do You Prefer?</label>
            <select id="photographer" name="photographer">
                <option value=" Nature">Nature</option>
                <option value="street">Street</option>
                <option value="Food">Food</option>
                <option value="Wedding">Wedding</option>
                <option value="Portrait">Portrait</option>
                <option value="Sky">Sky</option>
            </select>

            <label for="date">Your Date for Booking:</label>
            <input type="date" id="date" name="date" required>

            <label for="feedback">Feedback:</label>
            <textarea id="feedback" name="feedback" rows="4"></textarea>

            <button type="submit">Submit</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Captured Moments. All Rights Reserved.</p>
    </footer>
</body>
</html>
