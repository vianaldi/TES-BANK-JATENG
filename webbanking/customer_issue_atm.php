<?php
session_start();
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
        <title>ATM request</title>

    </head>

    <?php
      if(isset($_SESSION['customer_login'])){
          if ($_SESSION['customer_login']==1)
            include 'customer_navbar.php';
          else
            include 'customer_navbar2.php';
          }
    ?>

    <div class="container">
    <div class="jumbotron2 text-center">
    <h3 style="text-align:center;color:#2E4372;"><u>Issue ATM card / Cheque Book</u></h3><br><br>

    <form action="customer_issue_atm_process.php" method="POST">
      <div class='form-group form-inline'>
      <label>Issue:</label>
      <select class='form-control' name='transfer'>
        <option value='ATM' class='form-control' selected>ATM</option>
        <option value='CHEQUE' class='form-control'>Cheque Book</option>
      </select>
      </div>
      <input type="submit" name="submitBtn" value="Request" class='btn btn-info'>
    <form>


    <?php
        include 'dbconn.php';
        $sender_id=$_SESSION["login_id"];

        $sql="SELECT * FROM cheque_book WHERE account_no='$sender_id'";
        $result=mysqli_query($con,$sql) or die(mysqli_error($con));
        $rws=mysqli_fetch_array($result);
        $c_status=$rws[3];
        $c_id=$rws[2];

        $sql="SELECT * FROM atm WHERE account_no='$sender_id'";
        $result=mysqli_query($con,$sql) or die(mysqli_error($con));
        $rws=mysqli_fetch_array($result);
        $atm_status=$rws[3];
        $a_id=$rws[2];

        if(($a_id==$sender_id) || ($c_id==$sender_id))
        {

        echo "<table class='table table-hover' style='text-align:left'>";
        echo "<tr><th style='text-align:left'>Requests</th><th style='text-align:left'>Status</th></tr>";
        echo "<tr><td>ATM Card Status: </td><td>$atm_status</td></tr>";
        echo "<tr><td>Cheque Book Status: </td><td>$c_status</td></tr>";
            echo "</table>"; }?>

      </div>
    </div>
