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
<?php
include 'dbconn.php';
$sql="SELECT * FROM `customer`";
$result=  mysqli_query($con,$sql) or die(mysql_error($con));
$sql_min="SELECT MIN(id) from customer";
$result_min=  mysqli_query($con,$sql_min);
$rws_min=  mysqli_fetch_array($result_min);
?>
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

    <title>Delete Customer</title>
    </head>

                <?php include 'admin_navbar.php'?>
                <div class="container-fluid">
                <div class="jumbotron2 text-center">
                <h1>Delete Account</h1><br>
                <form action="editcustomer.php" method="POST">

                    <table class="table table-hover" align="center">
                        <th>id</th>
                        <th>name</th>
                        <th>gender</th>
                        <th>DOB</th>
                        <th>nominee</th>
                        <th>account type</th>
                        <th>address</th>
                        <th>mobile</th>
                        <th>email</th>
                        <?php
                        include 'cleandata.php';
                        while($rws=  mysqli_fetch_array($result)){
                          $rws[0]=cleanData($con,$rws[0]);
                          $rws[1]=cleanData($con,$rws[1]);
                          $rws[2]=cleanData($con,$rws[2]);
                          $rws[3]=cleanData($con,$rws[3]);
                          $rws[4]=cleanData($con,$rws[4]);
                          $rws[5]=cleanData($con,$rws[5]);
                          $rws[6]=cleanData($con,$rws[6]);
                          $rws[7]=cleanData($con,$rws[7]);
                          $rws[8]=cleanData($con,$rws[8]);
                            echo "<tr><td><input type='radio' name='customer_id' value=".$rws[0];
                            if($rws[0]==$rws_min[0]) echo' checked';
                            echo " /></td>";
                            echo "<td>".$rws[1]."</td>";
                            echo "<td>".$rws[2]."</td>";
                            echo "<td>".$rws[3]."</td>";
                            echo "<td>".$rws[4]."</td>";
                            echo "<td>".$rws[5]."</td>";
                            echo "<td>".$rws[6]."</td>";
                            echo "<td>".$rws[7]."</td>";
                            echo "<td>".$rws[8]."</td>";
                            echo "</tr>";
                        }
                        ?>

                    </table>
                    <input type="submit" name="submit2_id" value="EDIT CUSTOMER DETAILS" class='btn btn-info' onclick="javascript: form.action='editcustomer.php';"/>
                    <input type="submit" name="submit2_id" value="DELETE CUSTOMER DETAILS" class='btn btn-danger' onclick="javascript: form.action='deletecustomer.php';"/>
                </form>
                </div>
                </div>
    </body>
</html>
