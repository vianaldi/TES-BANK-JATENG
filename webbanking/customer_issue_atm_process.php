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
include 'dbconn.php';
include 'cleandata.php';
$name=$_SESSION['name'];
$account_no=$_SESSION['login_id'];
$option=$_REQUEST['transfer'];

$option=cleanData($con,$option);
$account_no=cleanData($con,$account_no);
$name=cleanData($con,$name);

$atm_status=$cheque_book_status="NOT REQUESTED";
if($option=='ATM')
    $atm_status="PENDING";
else
    $cheque_book_status="PENDING";


    $sql="SELECT * FROM cheque_book WHERE account_no='$account_no'";
    $result=mysqli_query($con,$sql) or die(mysqli_error($con));
    $rws=mysqli_fetch_array($result);
    $c_status=$rws[3];
    $c_id=$rws[2];

    $sql="SELECT * FROM atm WHERE account_no='$account_no'";
    $result=  mysqli_query($con,$sql) or die(mysqli_error($con));
    $rws=  mysqli_fetch_array($result);
    $a_status=$rws[3];
    $a_id=$rws[2];


    if(($option=='ATM' && (($a_status=='PENDING')||($a_status=='ISSUED'))) || ($option=='CHEQUE' && (($c_status=='PENDING')||($c_status=='ISSUED'))))
    {
        echo '<script>alert("You have already made a request!");';
   echo 'window.location= "customer_issue_atm.php";</script>';
}

elseif($option=='ATM'){
  $sql=$con->prepare("insert into atm (`cust_name`, `account_no`, `atm_status`) values(?,?,?)");
  $sql->bind_param("sis", $name, $account_no,$atm_status);
  $sql->execute();

$sql="insert into atm (`cust_name`, `account_no`, `atm_status`) values('$name','$account_no','$atm_status')";
mysqli_query($con,$sql) or die(mysql_error($con));

echo '<script>alert("Request succesfull. You will recieve confirmation from branch very soon.");';
echo 'window.location= "customer_issue_atm.php";</script>';
}
else {
  $sql=$con->prepare("insert into cheque_book (`cust_name`, `account_no`, `cheque_book_status`)  values(?,?,?)");
  $sql->bind_param("sis", $name, $account_no,$cheque_book_status);
  $sql->execute();

echo '<script>alert("Request succesfull. You will recieve confirmation from branch very soon.");';
echo 'window.location= "customer_issue_atm.php";</script>';
}


?>
