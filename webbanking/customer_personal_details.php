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
        <title>Personal Details</title>

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
            <h3 style="text-align:center;color:#2E4372;"><u>Personal Details</u></h3>
            <br><br>

            <?php
                $cust_id=$_SESSION['cust_id'];
                include 'dbconn.php';
                $sql="SELECT * FROM customer WHERE email='$cust_id'";
                $result=  mysqli_query($con,$sql) or die(mysqli_error($con));
                $rws=  mysqli_fetch_array($result);


                $name= $rws[1];
                $account_no= $rws[0];
                $dob=$rws[3];
                $nominee=$rws[4];
                $branch=$rws[10];
                $branch_code= $rws[11];

                $gender=$rws[2];
                $mobile=$rws[7];
                $email=$rws[8];
                $address=$rws[6];

                $last_login= $rws[12];

                $acc_status=$rws[13];
                $acc_type=$rws[5];




?>
            <p>Name: <?php echo $name;?></p>
            <p>gender: <?php if($gender=='M') echo "Male"; else echo "Female";?></p>
            <p>Mobile: <?php echo $mobile;?></p>
            <p>Email: <?php echo $email;?></p>
            <p>Address: <?php echo $address;?></p>

            <p>Account No: <?php echo $account_no;?></p>
            <p>Nominee: <?php echo $nominee;?></p>
            <p>Branch: <?php echo $branch;?></p>
            <p>Branch Code: <?php echo $branch_code;?></p>

            <p>Account Type: <?php echo $acc_type;?></p>
            </div>
            </div>

    </body>
</html>
