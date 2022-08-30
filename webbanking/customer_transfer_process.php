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
<?php
     $t_amount=$_REQUEST['t_val'];
     $sender_id=$_SESSION["login_id"];
     $reciever_id=$_REQUEST['transfer'];

     //select last transaction id in reciever's passbook.
     include 'dbconn.php';
     include 'cleandata.php';

     $sender_id=cleanData($con,$sender_id);
     $reciever_id=cleanData($con,$reciever_id);
     $sql="SELECT MAX(transactionid) from passbook".$reciever_id;
     $result=mysqli_query($con,$sql) or die(mysqli_error($con));
     $rws=  mysqli_fetch_array($result);
     $r_last_tid=$rws[0];

    //select the details in the last row of reciever's passbook.
    $sql="SELECT * from passbook".$reciever_id." WHERE transactionid='$r_last_tid'";
    $result=mysqli_query($con,$sql) or die(mysql_error($con));
    while($rws= mysqli_fetch_array($result)){
    $r_amount=$rws[7];
    $r_name=$rws[2];
    $r_branch=$rws[3];
    $r_ifsc=$rws[4];
    }

   //select the last transaction id in the sender's passbook
     $sql="SELECT MAX(transactionid) from passbook".$sender_id;
     $result=mysqli_query($con,$sql) or die(mysqli_error($con));
     $rws=  mysqli_fetch_array($result);
     $s_last_tid=$rws[0];

    //select the details in the last row of sender's passbook.
    $sql="SELECT * from passbook".$sender_id." WHERE transactionid='$s_last_tid'";
    $result=mysqli_query($con,$sql) or die(mysqli_error($con));
    while($rws= mysqli_fetch_array($result)) {
    $s_amount=$rws[7];
    $s_name=$rws[2];
    $s_branch=$rws[3];
    $s_ifsc=$rws[4];
    }

    $date=date("Y-m-d");

    $s_total=$s_amount-$t_amount; //sender's final balance.

    if($s_amount<=500)
    {
        echo '<script>alert("Your account balance is less than EU 500.\n\nYou must maintain a minimum balance of EU. 500 in order to proceed with the transfer.");';
        echo 'window.location= "customer_transfer.php";</script>';
    }
    elseif($t_amount<100){
         echo '<script>alert("You cannot transfer less than EU 100");';
        echo 'window.location= "customer_transfer.php";</script>';
    }
    elseif($s_total<500)
    {
        echo '<script>alert("You do not have enough balance in your account to proceed this transfer.\n\nYou must maintain a minimum of EU 500 in your account.");';
        echo 'window.location= "customer_transfer.php";</script>';
    }

    else{
        //insert statement into reciever passbook.
        $r_total=$r_amount+$t_amount;
        $sql1="insert into passbook".$reciever_id." (`transactiondate`, `name`, `branch`, `ifsc`, `credit`, `debit`, `amount`, `narration`)  values('$date','$r_name','$r_branch','$r_ifsc','$t_amount','0','$r_total','BY $s_name')";
        mysqli_query($con,$sql1) or die(mysqli_error($con));

        //insert statement into sender passbook.
        $s_total=$s_amount-$t_amount;
        $sql2="insert into passbook".$sender_id." (`transactiondate`, `name`, `branch`, `ifsc`, `credit`, `debit`, `amount`, `narration`)
         values('$date','$s_name','$s_branch','$s_ifsc','0','$t_amount','$s_total','TO $r_name')";
         mysqli_query($con,$sql2) or die(mysqli_error($con));

        echo '<script>alert("Transfer Successful.");';
        echo 'window.location= "customer_transfer.php";</script>';
    }
?>
