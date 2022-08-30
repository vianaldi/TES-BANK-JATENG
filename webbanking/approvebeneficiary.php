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
      <title>Display Beneficiary</title>

        </head>

           <?php include 'admin_navbar.php'?>

            <?php
              include 'dbconn.php';
              $sql="SELECT * FROM beneficiary1";
              $result=  mysqli_query($con,$sql) or die(mysqli_error($con));
              ?>

        <div class="container">
        <div class="jumbotron2 text-center">
        <h3 style="text-align:center;color:#2E4372;"><u>Approve Beneficiaries</u></h3>
        <form action="approve_beneficiary.php">
          <table class="table table-hover" align="center">

                        <th></th>
                        <th>Name</th>
                        <th>Beneficiary<br> Account No</th>
                        <th>Status</th>

                        <?php
                        include 'cleandata.php';
                        while($rws=  mysqli_fetch_array($result)){
                          $rws[0]=cleanData($con,$rws[0]);
                          $rws[1]=cleanData($con,$rws[1]);
                          $rws[2]=cleanData($con,$rws[2]);
                          $rws[3]=cleanData($con,$rws[3]);
                          $rws[4]=cleanData($con,$rws[4]);
                          $rws[5]=cleanData($con,$rws[5]);

                            echo "<tr><td><input type='radio' name='customer_id' value=".$rws[0];
                            echo ' checked';
                            echo " /></td>";
                            echo "<td>".$rws[4]."</td>";
                            echo "<td>".$rws[3]."</td>";
                            echo "<td>".$rws[5]."</td>";
                            echo "</tr>";
                        } ?>
</table>
  <input type="submit" class="btn btn-info" name="submit_id" value="APPROVE BENEFICIARY" class='addstaff_button'/></td></tr></table>
    </form>
</div>
