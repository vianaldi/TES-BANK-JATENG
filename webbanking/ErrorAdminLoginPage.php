<?php
session_start();
$now = time(); // Checking the time now when home page starts.

if ($now > $_SESSION['expire2']) {
    session_destroy();
}

if(!isset($_SESSION['admin_login']))
    header('location:adminlogin.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ErrorPage</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="mystyle.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body style="background-color:  #d1dffa;">
  <script>
          setTimeout(function(){window.location.replace("https:/Banking/adminlogin.php"); }, 1000);
  </script>
  <div class="jumbotron text-center" style="background-color:  #d1dffa;">
    <h2>Invalid Credentials</h2>
    <h2>Please wait 10 seconds to go back and try again</h2>
  </div>
</body>
