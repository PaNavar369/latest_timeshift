<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../Css/contact.css">
</head>
   <body>
        <header>
            <h1> Contact US</h1>
            <p> we'd love to here from you!</p>
        </header>
       <link rel="stylesheet" href="../Css/contact.css">
        <div  class="container">
            <h2>Get in Touch</h2>
            <p>If you have any questions, feedback, or inquiries, feel free to reach out to us by filling out the form below:</p>
        </div>
        <form action="submit_contact.php" method="post">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" required>

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" placeholder="Enter the subject" required>

            <label for="message">Your Message:</label>
            <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 News Shifter | <a href="about.html">About Us</a></p>
    </footer>
   </body>
</html>