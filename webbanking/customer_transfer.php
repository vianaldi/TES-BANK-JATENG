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
      <meta charset="utf-8">
      <meta name="viewport" content="width=1024">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
      <link rel="stylesheet" type="text/css" href="mystyle.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <title>Transfer Funds</title>

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
        <h3 style="text-align:center;color:#2E4372;"><u>Transfer Funds</u></h3><br><br>


                    <?php
                    include 'dbconn.php';
        $sender_id=$_SESSION["login_id"];


        $sql="SELECT * FROM beneficiary1 WHERE sender_id='$sender_id' AND status='ACTIVE'";
        $result=  mysqli_query($con,$sql);
        $rws=mysqli_fetch_array($result);
        $s_id=$rws[1];
        ?>


        <?php
        if($sender_id==$s_id)
        {
        echo "<form action='customer_transfer_process.php' method='POST'>";
        echo "<div class='form-group form-inline'>
        <label>Select Beneficiary:
        </label><select class='form-control' name='transfer'>
        </div>";

        $sql1="SELECT * FROM beneficiary1 WHERE sender_id='$sender_id' AND status='ACTIVE'";
        $result=  mysqli_query($con,$sql);

        while($rws=mysqli_fetch_array($result)) {
        echo "<option value='$rws[3]'>$rws[4]</option>";
        }

        echo "<div class='form-group form-inline'>
        <label>Select Beneficiary:
        </label><select class='form-control'>
        </div>";

        echo "<div class='form-group form-inline'>
        <label for='ex'>Enter Amount:</label>
        <input type='number' id='ex' class='form-control' name='t_val' required>
        </div>";

        echo "<input type='submit' name='submitBtn' value='Transfer' class='btn btn-success'></form>";
        }
        else{
            echo "<br><br><div class='head'><h3>No Benefeciary Added with your account.</h3></div>";
        }
        ?>
    </div>
