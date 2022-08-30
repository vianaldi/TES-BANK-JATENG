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
           <?php include 'customer_navbar.php'?>




<div class="container-fluid">
<div class="jumbotron2 text-center">
<h3 style="text-align:center;color:#2E4372;"><u>Account Transactions</u></h3>
    <table class="table table-hover" align="center">
                      <thead>
                         <tr>
                           <th>Id</th>
                           <th>Transaction Date</th>
                           <th>Narration</th>
                           <th>Credit</th>
                           <th>Debit</th>
                           <th>Balance Amount</th>
                         </tr>
                       </thead>
                       <tbody>
                        <?php if(isset($_REQUEST['summary_date'])) {
                         $date1=$_REQUEST['date1'];
                         $date2=$_REQUEST['date2'];

                         include 'dbconn.php';
                         include 'cleandata.php';
                         $date1=cleanData($con,$date1);
                         $date2=cleanData($con,$date2);

                         $sender_id=$_SESSION["login_id"];

                         $sql=$con->prepare("SELECT * FROM passbook".$sender_id." WHERE transactiondate BETWEEN ? AND ?");
                         $sql->bind_param('ss', $date1,$date2);
                         $sql->execute();
                         $result = $sql->get_result();

                         $row = $result->fetch_assoc();
                         $rws=array_values($row);

                        while($rws=  mysqli_fetch_array($result)){

                            echo "<tr>";
                            echo "<td>".$rws[0]."</td>";
                            echo "<td>".$rws[1]."</td>";
                            echo "<td>".$rws[8]."</td>";
                            echo "<td>".$rws[5]."</td>";
                            echo "<td>".$rws[6]."</td>";
                            echo "<td>".$rws[7]."</td>";

                            echo "</tr>";
                        }
                        } ?>
                      </tbody>
</table>
  </div>
  </div>
  </body>
  </html>
