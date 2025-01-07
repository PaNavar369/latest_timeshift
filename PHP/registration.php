<?php

//print_r($_POST);


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
if(empty($_POST['Name'])){
    die ("Name is required");
}
//print_r($_POST['Email']);
if(! filter_var($_POST['Email'],FILTER_VALIDATE_EMAIL)){
    die ("enter valid emain address");
}
if(strlen($_POST["password"])<8){
    die("password must be atlease 8 characters");
}
if(! preg_match("/[a-z]/i",$_POST["password"])){
    die("password must contain atleast one letter");
}
if(! preg_match("/[0-9]/i",$_POST["password"])){
    die("password must contain atleast one letter");
}
if($_POST["password"]!=$_POST["confirm_password"]){
    die("password should match");
}


$email = $_POST['Email'];
$sql_check_email = "SELECT * FROM users WHERE Email = ?";
$stmt_check_email = $conn->prepare($sql_check_email);

if ($stmt_check_email === false) {
    die("SQL error: " . $conn->error);
}

// Bind parameters for the check email query
$stmt_check_email->bind_param("s", $email);
$stmt_check_email->execute();
$stmt_check_email->store_result();

// If a record is found with the same email, stop execution
if ($stmt_check_email->num_rows > 0) {
    header("Location: signupwin.php?error=email already exist is required");
    exit();
    
}
//$Password = password_hash($_POST['password'], PASSWORD_DEFAULT);


//$conn=require __DIR__."db_conn.php"; 

$sql="Insert into users(Email,Password,Name) values (?,?,?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("SQL error: " . $conn->error);
}

// Bind the parameters
$stmt->bind_param("sss", $_POST['Email'],  $_POST['password'], $_POST['Name']);

// Execute the statement
if ($stmt->execute()) {
    //echo "User successfully registered!";
    include "login.php";
} 

// Close the statement and connection
$stmt->close();
$conn->close();



   //print_r($_POST);


?>