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
  if($_SESSION['customer_login']==2)
    header('location:customer_account_summary.php');
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

        <?php
          if(isset($_SESSION['customer_login'])){
              if ($_SESSION['customer_login']==1)
                include 'customer_navbar.php';
              else
                include 'customer_navbar2.php';
              }
        ?>

            <?php
              include 'dbconn.php';
              $sender_id=$_SESSION["login_id"];
              $sql="SELECT * FROM beneficiary1 WHERE sender_id='$sender_id'";
              $result=  mysqli_query($con,$sql) or die(mysqli_error($con));
              ?>

        <div class="container">
        <div class="jumbotron2 text-center">
        <h3 style="text-align:center;color:#2E4372;"><u>Added Beneficiary</u></h3>
        <form action="delete_beneficiary.php">
          <table class="table table-hover" align="center">

                        <th></th>
                        <th>Name</th>
                        <th>Beneficiary<br> Account No</th>
                        <th>Status</th>

                        <?php
                        while($rws=  mysqli_fetch_array($result)){

                            echo "<tr><td><input type='radio' name='customer_id' value=".$rws[0];
                            echo ' checked';
                            echo " /></td>";
                            echo "<td>".$rws[4]."</td>";
                            echo "<td>".$rws[3]."</td>";
                            echo "<td>".$rws[5]."</td>";
                            echo "</tr>";
                        } ?>
</table>
  <input type="submit" class="btn btn-danger" name="submit_id" value="DELETE BENEFICIARY" class='addstaff_button'/></td></tr></table>
    </form>
</div>
