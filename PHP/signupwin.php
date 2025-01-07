<!DOCTYPE html>
<html>
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp page </title>
    <link rel="stylesheet" href="../Css/signupstyle.css">
   </head>

   <body>
      <div class="auth-container">
         <h1>    SignUp  </h1> 
         <!-- used novalidate tag to test the email addres -->
         <form action="registration.php" method="POST"  > 
         <?php if(isset($_GET['error'])){?>
            <p class="error" style="color: red;"><?php echo $_GET['error']; ?></p>

       <?php } ?>    
            <label for=" Full name">Full name</label>
            <input type="text" id="Name" name="Name" required>
            <label for="Email">Email</label> 
            <input type="text" id="Email" name ="Email" required>
            <label for="password"> password</label>
            <input type="text" id="email" name="password" required>
            
            <label for="confirm password"> confirm password </label>
            <input type="text" id="confirm password" name ="confirm_password" required >
            <Button type="submit"> Signup</Button>  
            <p>Already have a account? <a href="loginpagewin.php">Sign Up</a></p>
         </form>
      </div>
   </body>
</html>