<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="../Css/style.css">
</head>
<body>
    <header class="header">
        <div class="logo">NewsTime</div>
        <nav class="nav">
            <a href="index.php">Home</a>
            <a href="About.php">About</a>
            <a href="loginpagewin.php">Login</a>
            <a href="signupwin.php">SignUp</a>
            <a href="contact.php">Contact</a>
        </nav>
    </header>

    <div class="container">
        <?php
        // Database connection
        $sname = "localhost";
        $unmae = "root";
        $password = "";
        $db_name = "info";

        $conn = new mysqli($sname, $unmae, $password, $db_name);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the search query is provided
        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $query = $_GET['query'];

            // Prevent SQL injection
            $query = "%" . $conn->real_escape_string($query) . "%";

            // Search for news in the database
            $sql = "SELECT title, content, description, author, image_url, published_at, url 
                    FROM news 
                    WHERE title LIKE ? OR content LIKE ? OR description LIKE ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $query, $query, $query);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if any results are found
            if ($result->num_rows > 0) {
                echo "<h2>Search Results for '" . htmlspecialchars($_GET['query']) . "':</h2>";
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='news-item'>";
                    if (!empty($row['image_url'])) {
                        echo "<div class='news-image'>
                                  <img src='" . htmlspecialchars($row['image_url']) . "' alt='News Image' style='max-width: 200px;'>
                              </div>";
                    }
                    else{
                        echo 
                        '<div class="news-image">
                            <img src="../images/no_image.jpeg" alt="news thumbnail" id="article-img">
                        </div>';

                    }
                    echo "<div class='news-content'>";
                    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                    echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
                    echo "<p><strong>Content:</strong>"  . htmlspecialchars($row['content'] ?? 'No content available.') . "</p>";
                    echo "<p><strong>Author:</strong> " . htmlspecialchars($row['author'] ?? 'Unknown') . "</p>";
                    echo "<p><strong>Published At:</strong> " . htmlspecialchars($row['published_at']) . "</p>";
                    if (!empty($row["url"])) {
                        echo '<a href="' . htmlspecialchars($row["url"]) . '" target="_blank" class="read-more">Read More</a>';
                    } else {
                        echo '<p class="no-link">No link available for this article.</p>';
                    }
                    

                    echo "</div>";
                    echo "</div><hr>";
                }
            } else {
                echo "<p>No results found for your search query.</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Please enter a search query.</p>";
        }

        $conn->close();
        ?>
    </div>

    <footer class="footer">
        <p>&copy; 2024 NewsTime. All rights reserved.</p>
    </footer>
</body>
</html>
