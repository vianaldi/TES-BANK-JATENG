<?php
if(isset($_REQUEST['submitBtn'])){
    ob_start();
    include 'dbconn.php';
    $username=$_REQUEST['uname'];

    //salting of password
    $salt="@g26jQsG&nh*&#8v";
    $password= sha1($_REQUEST['pwd'].$salt);

    $sql="SELECT email,password FROM customer WHERE email='$username' AND password='$password'";
    $result=mysqli_query($con,$sql) or die(mysqli_error($con));
    $rws=  mysqli_fetch_array($result);

    $user=$rws[0];
    $pwd=$rws[1];

    if($user==$username && $pwd==$password){
        session_start();
        $_SESSION['customer_login']=1;
        $_SESSION['cust_id']=$username;
    header('location:customer_account_summary.php');
    $message ="";
    echo $message;
    }
else{
  $message = "Invalid Credentials ! Please try again.";
  echo $message;
}}
?>
