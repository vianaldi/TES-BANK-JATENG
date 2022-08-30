<?php
session_start();
include 'sessionexpire.php';
include 'ErrorHandling.php';

if(session_status() == PHP_SESSION_NONE){
    header('location:adminlogin.php');
}else {
  if(!($_SESSION['admin_login']==1 || $_SESSION['admin_login']==2)){
    session_destroy();
    header('location:adminlogin.php');
  }
}
?>
<!DOCTYPE html>
<html>
<body style="background-color:  #d1dffa;">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=1024">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="mystyle.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <title>Admin Homepage</title>
    </head>

           <?php include 'admin_navbar.php'?>

           <?php
           if(isset($_SESSION['admin_login'])){
             if ($_SESSION['admin_login']==1)
               include 'admin_hp1.php';
             else
               include 'admin_hp2.php';
             }
           ?>

    </body>
</html>
