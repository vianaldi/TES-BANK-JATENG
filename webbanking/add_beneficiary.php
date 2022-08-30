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
  if ($_SESSION['customer_login']==2){
    header('location:customer_account_summary.php');
  }
}

?>
<!DOCTYPE html>
<html>
<body style="background-color:  #d1dffa;">
    <head>
        <title>Bootstrap Theme Company Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=1024">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <title>Add Beneficiary</title>

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
          <form action='add_beneficiary_process.php' method='post'>
          <h3 style="text-align:center;color:#2E4372;"><u>Add Beneficiary</u></h3><br>
          <div class="form-group form-inline">
            <label>Payee Name: </label>
            <input type='text' class="form-control" name='name' required>
          </div>
          <div class="form-group form-inline">
            <label>Account No: </label>
            <input type='text' class="form-control" name='account_no' required>
        </div>
        <div class="form-group form-inline">
          <label>Select Branch: </label>
          <select class="form-control" name='branch_select' required>
          <option value='ATHENS'>Athens</option>
          <option value='PATRA'>Patra</option>
          <option value='THESSALONIKI'>Thessaloniki</option>
          </select>
      </div>
      <div class="form-group form-inline">
        <label>Ifsc Code: </label>
        <input type='text' class="form-control" name='ifsc_code' required>
    </div>
        <br><br>
        <button type="submit" class="btn btn-info" name="submitBtn"/>Enter</button>
      </form>
