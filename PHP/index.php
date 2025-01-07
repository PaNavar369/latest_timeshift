<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News with Time Feature</title>
    <link rel="stylesheet" href="../Css/style.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">NewsTime</div>
        <div class="search">
            <form class="search-bar" action="search.php" method="get">
                <input type="text" name="query" placeholder="search news..." required>
                <button type="submit">Submit</button>
            </form>
        </div>
         <nav class="nav">
            <a href="#">Home</a>
            <a href="About.php">About</a>
            <a href="loginpagewin.php">Login</a>
            <a href="signupwin.php">SignUp</a>
            <a href="contact.php">Contact</a> 
           
        </nav> 
       
    </header>

    <!-- Main Content -->
   
    <?php
// API URL and Key
$url = "https://newsapi.org/v2/top-headlines?country=us&category=business&apiKey=c0f08cd4fb4d403780b017373691ca91";
//$url = "https://newsapi.org/v2/top-headlines?country=us&category=business&apiKey=pub_63633232158417aae96767fa626a7a9472a71";

// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: MyApp/1.0' // Replace "MyApp/1.0" with your application name
]);

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
    curl_close($ch);
    exit();
}

// Close the cURL session
curl_close($ch);

// Decode the JSON response
$newsData = json_decode($response, true);

// Check if the API response is valid
if (!isset($newsData['articles']) || empty($newsData['articles'])) {
    echo "<p>No news articles available at the moment.</p>";
    exit();
}

// Get articles from the response
$articles = $newsData['articles'];

?>
<?php

   // Connect to the database
   $sname = "localhost";
   $unmae = "root";
   $password = "";
   $db_name = "info";
   
   // Create connection
   $conn = new mysqli($sname, $unmae, $password, $db_name);
   
   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   
   //$url = "https://newsapi.org/v2/top-headlines?country=us&category=business&apiKey=c0f08cd4fb4d403780b017373691ca91";
   
   // Initialize cURL
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_HTTPHEADER, [
       'User-Agent: MyApp/1.0'
   ]);
   
   $response = curl_exec($ch);
   
   if (curl_errno($ch)) {
       echo 'Error: ' . curl_error($ch);
       curl_close($ch);
       exit();
   }
   
   curl_close($ch);
   
   $newsData = json_decode($response, true);
   
   if (!isset($newsData['articles']) || empty($newsData['articles'])) {
       echo "<p>No news articles available at the moment.</p>";
       exit();
   }
   
   $articles = $newsData['articles'];
   //Delete existing data before inserting new articles (optional)
   //Uncomment this section if you want to keep the table clean:
  $delete_sql = "DELETE FROM news";
  $delete_stmt = $conn->prepare($delete_sql);
   $delete_stmt->execute();
   $delete_stmt->close();
   foreach ($articles as $article) {
       $title = $article['title'];
       $content = $article['content'];
       $description = $article['description'];
       $author = $article['author'];
       $image_url = $article['urlToImage'];
       $published_at = $article['publishedAt'];
       $url=$article['url'];
   
       // Check if the record already exists (using title and published_at as unique identifiers)
       $check_sql = "SELECT COUNT(*) FROM news WHERE title = ? AND published_at = ?";
       $check_stmt = $conn->prepare($check_sql);
       $check_stmt->bind_param("ss", $title, $published_at);
       $check_stmt->execute();
       $check_stmt->bind_result($count);
       $check_stmt->fetch();
       $check_stmt->close();
      
       
       if ($count > 0) {
           //echo "Record with title '$title' already exists.<br>";
       } else {
           // Insert record without explicitly referencing the primary key
           $sql = "INSERT INTO news (title, content, description, author, image_url, published_at,url) 
                   VALUES (?, ?, ?, ?, ?, ?,?)";
           $stmt = $conn->prepare($sql);
           $stmt->bind_param("sssssss", $title, $content, $description, $author, $image_url, $published_at,$url);
   
            if ($stmt->execute()) {
                //echo "Record for '$title' inserted successfully.<br>";
             } else {
               echo "Error inserting record for '$title': " . $stmt->error . "<br>";
            }
   
            
   
           $stmt->close();
       }
   }
   
   $conn->close();
   
   ?>

 <div class="container">
        <?php foreach ($articles as $news): ?>
                    <?php
                     if( empty($news['urlToImage'])){
                        echo '<div class="news-item">
                        <div class="news-image">
                            <img src="../images/no_image.jpeg" alt="news thumbnail" id="article-img">
                        </div>'; 
                      echo'<div class="news-content">
                      <h2>' . htmlspecialchars($news['title']) . '</h2>
                      <p><strong>Description:</strong> ' . htmlspecialchars($news['description']) . '</p>
                      <p><strong>Content:</strong> ' . htmlspecialchars($news['content'] ?? 'No content available.') . '</p>
                      <p><strong>Author:</strong> ' . htmlspecialchars($news['author'] ?? 'Unknown') . '</p>
                      <p><strong>Published:</strong> ' . htmlspecialchars($news['publishedAt']) . '</p>
                      <a href="' . htmlspecialchars($news['url']) . '" target="_blank" class="read-more">Read More</a>
                    </div>
                    </div>
                    <hr>';
                     }
                     else
                     {
                        echo '<div class="news-item">
                        <div class="news-image">
                            <img src="' . htmlspecialchars($news['urlToImage']) . '" alt="news thumbnail" id="article-img">
                        </div>
                      ';
                      echo'<div class="news-content">
                      <h2>' . htmlspecialchars($news['title']) . '</h2>
                      <p><strong>Description:</strong> ' . htmlspecialchars($news['description']) . '</p>
                      <p><strong>Content:</strong> ' . htmlspecialchars($news['content'] ?? 'No content available.') . '</p>
                      <p><strong>Author:</strong> ' . htmlspecialchars($news['author'] ?? 'Unknown') . '</p>
                      <p><strong>Published:</strong> ' . htmlspecialchars($news['publishedAt']) . '</p>
                      <a href="' . htmlspecialchars($news['url']) . '" target="_blank" class="read-more">Read More</a>
                    </div>
                    </div>
                    <hr>';
                        }
                     ?>  
                    
           
        <?php endforeach; ?>
    </div>

  
     



    
    
    <footer class="footer">
        <p>&copy; 2024 NewsTime. All rights reserved.</p>
        <div class="socials">
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">LinkedIn</a>
        </div>
    </footer>

    <!-- Footer --> 
</body>
</html>
