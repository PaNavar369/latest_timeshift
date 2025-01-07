<!-- to connect woth data base  -->

<?php
$sname="localhost";
$unmae="root";
$password=""; 
$db_name="info";
$conn= mysqli_connect($sname,$unmae,$password,$db_name);
if(!$conn){
    echo "connection failed  !";
}
else
{
 
}


if (isset($_POST['email']) && isset($_POST['password'])) {
    function validate($data) {
        return trim(stripslashes($data));
    }

    $email = validate($_POST['email']);
    $pass = validate($_POST['password']);

    if (empty($email)) {
        header("Location: loginpagewin.php?error=Email is required");
        exit();
    } elseif (empty($pass)) {
        header("Location: loginpagewin.php?error=Password is required");
        exit();
    } else {
        
        $sql = "SELECT * FROM users WHERE Email = '$email' AND Password = '$pass'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result)===1) {
            $row=mysqli_fetch_assoc( $result);
           // print_r($row);
            if($row['Email']===$email && $row['Password']===$pass){
                include "indaftrlogin.php";
            }
            else
            {
                header("Location: loginpagewin.php?error=Invalid credentials");
                exit();  
            }
            
        } else {
            header("Location: loginpagewin.php?error=Invalid credentials");
            exit();
        }
    }
} else {
    header("Location: loginpagewin.php");
    exit();
}


?>
