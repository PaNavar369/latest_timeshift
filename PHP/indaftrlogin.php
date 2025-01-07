<?php
session_start(); // Start the session

// Debug the session
//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';

if (isset($_SESSION['mail'])) {
    header("Location: indaftrlogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            page after login
        </title>
        <link rel="stylesheet" href="../Css/loginpage.css">
    </head>
    <body>
        <header class="header">
            <div class="logo">NewsTime</div>
            <div class="time-selector">
                <form method="POST" action="indaftrlogin.php">
                    <input type="time" id="time" name="time" required>
                    <button type="submit" id="goButton">Go</button>
                </form>
           </div>
        <nav class="nav">
        <div class="search">
            <form class="search-bar" action="search.php" method="get">
                <input type="text" name="query" placeholder="search news..." required>
                <button type="submit">Submit</button>
            </form>
            <Button class="logout" onclick="window.location.href='index.php';">Log Out </button>
        </div>
        </nav>
        </header>


<?php

//         
     // for data base connection
     $sname = "localhost";
        $unmae = "root";
        $password = "";
        $db_name = "info";

        $conn = new mysqli($sname, $unmae, $password, $db_name);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // else{
        //     echo "db connected successfully";
        // }
         
        
        $selectedTime = isset($_POST['time']) ? $_POST['time'] : null;
        $time24=date("$selectedTime");
         //echo "$time24"; 

         if ($selectedTime) {
            $sql = "SELECT * FROM news WHERE TIME(published_at) >= TIME('$time24') ORDER BY published_at"; ; 
            } else 
            {
              $sql = "SELECT * FROM news ORDER BY published_at   ";
             }
        $result = $conn->query($sql);
        
?>
    <!-- loading main content -->

    <div class="news-container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="news-item">
                <div class="news-card">
                    <div class="news-image">
                        <img src="' . (!empty($row['image_url']) ? htmlspecialchars($row['image_url'], ENT_QUOTES, 'UTF-8') : '../images/no_image.jpeg') . '" alt="news thumbnail">
                    </div>
                    <div class="news-content">
                        <h2>' . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . '</h2>
                        <p><strong>Description:</strong> ' . htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Content:</strong> ' . htmlspecialchars($row['content'] ?? 'No content available.', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Author:</strong> ' . htmlspecialchars($row['author'] ?? 'Unknown', ENT_QUOTES, 'UTF-8') . '</p>
                        <p><strong>Published:</strong> ' . htmlspecialchars($row['published_at'], ENT_QUOTES, 'UTF-8') . '</p>
                        <a href="' . htmlspecialchars($row['url'], ENT_QUOTES, 'UTF-8') . '" target="_blank" class="read-more">Read More</a>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo "<p>No news available</p>";
    }
    ?>
</div>


</body>
</html>
