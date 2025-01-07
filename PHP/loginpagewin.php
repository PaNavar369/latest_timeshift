<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../Css/loginstyle.css">
</head>
<body>
    <div class="auth-container">
        <h1>Login</h1>
       
        <form action="login.php" method="POST">
        <?php if(isset($_GET['error'])){?>
            <p class="error" style="color: red;"><?php echo $_GET['error']; ?></p>

       <?php } ?>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" >
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password">
            
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signupwin.php">Sign Up</a></p>
    </div>
</body>
</html>
