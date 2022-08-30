<?php
session_start();

include 'dbconn.php';
include 'cleandata.php';
include 'sessionexpire.php';
include 'ErrorHandling.php';

if(session_status() == PHP_SESSION_NONE){
    header('location:index.php');
}else {
  if(!($_SESSION['customer_login']==1 || $_SESSION['customer_login']==2)){
    session_destroy();
    header('location:index.php');
  }
}

$date=date('Y-m-d h:i:s');
$id=$_SESSION['login_id'];
$id=cleanData($con,$id);
$date=cleanData($con,$date);
$sql=$con->prepare("UPDATE customer SET lastlogin=? WHERE id=?");
$sql->bind_param("si", $date, $id);
$sql->execute();
#mysqli_query($con,$sql) or die(mysqli_error($con));

session_destroy();
header('location:index.php');
?>
