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
<?php
                $cust_id=$_SESSION['cust_id'];
                include 'dbconn.php';
                include 'cleandata.php';

                $cust_id=cleanData($con,$cust_id);
                $sql=$con->prepare("SELECT * FROM customer WHERE email= ?");
                $sql->bind_param('s', $cust_id);
                $sql->execute();
                $result = $sql->get_result();

                $row = $result->fetch_assoc();
                $rws=array_values($row);

                $name= $rws[1];
                $account_no= $rws[0];
                $branch=$rws[10];
                $branch_code= $rws[11];
                $last_login= $rws[12];
                $acc_status=$rws[13];
                $address=$rws[6];
                $acc_type=$rws[5];

                $gender=$rws[2];
                $mobile=$rws[7];
                $email=$rws[8];

                $_SESSION['login_id']=$account_no;
                $_SESSION['name']=$name;

                $account_no=cleanData($con,$account_no);
                $name=cleanData($con,$name);

                $sql="SELECT * FROM passbook".$account_no; ;
                $result=  mysqli_query($con,$sql) or die(mysqli_error($con));
                while($rws=  mysqli_fetch_array($result))
                {
                $balance=$rws[7];
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
        <title>Home - Online Banking</title>

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
              <h1>Customer Summary</h1><br><br>
              <p><span class="heading">Account No: </span><?php echo $account_no;?></p>
              <p><span class="heading">Branch: </span><?php echo $branch;?></p>
              <p><span class="heading">Branch Code: </span><?php echo $branch_code;?></p>
              <p><span class="heading">Balance: EUR </span><?php echo $balance;?></p>
              <p><span class="heading">Account status: </span><?php echo $acc_status;?></p>
              <p><span class="heading">Last Login: </span><?php echo $last_login;?></p>
            </div>
            </div>
    </body>
</html>
