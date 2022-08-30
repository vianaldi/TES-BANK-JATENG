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
      <link rel="stylesheet" type="text/css" href="mystyle.css">
      <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <title>Account Statement</title>
    </head>

    <?php
      if(isset($_SESSION['customer_login'])){
          if ($_SESSION['customer_login']==1)
            include 'customer_navbar.php';
          else
            include 'customer_navbar2.php';
          }
    ?>

    <div class="container-fluid">
    <div class="jumbotron2 text-center">
    <h3 style="text-align:center;color:#2E4372;"><u>Account summary by Date</u></h3><br><br>
    <form class="form-inline" action="customer_account_statement_date.php" method="POST">
      <div class="form-group">
        <label for="ex1">Start Date</label>
        <input class="form-control" id="ex1" name="date1" type="date" required>
      </div>
      <div class="form-group">
        <label for="ex2">End Date</label>
        <input class="form-control" id="ex2" name="date2" type="date" required>
    </div>
    <br><br>
    <button type="submit" class="btn btn-info" name="summary_date"/>Enter</button>
  </form>
    </div>
    </div>
</body>
