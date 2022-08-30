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
    <?php
include 'dbconn.php';
include 'cleandata.php';
include 'ErrorHandling.php';
$name=  cleanData($con,$_REQUEST['customer_name']);
$gender=  cleanData($con,$_REQUEST['customer_gender']);
$dob=  cleanData($con,$_REQUEST['customer_dob']);
$nominee=  cleanData($con,$_REQUEST['customer_nominee']);
$type=  cleanData($con,$_REQUEST['customer_account']);
$credit=  cleanData($con,$_REQUEST['initial']);
$address=  cleanData($con,$_REQUEST['customer_address']);
$mobile=  cleanData($con,$_REQUEST['customer_mobile']);
$email= cleanData($con,$_REQUEST['customer_email']);

//salting of password
$password=cleanData($con,$_REQUEST['customer_pwd']);
$salt="@g26jQsG&nh*&#8v";
$password=  sha1($password.$salt);

$branch=  cleanData($con,$_REQUEST['branch']);
$date=date("Y-m-d");
switch($branch){
case 'ATHENS': $ifsc="K421A";
    break;
case 'PATRA': $ifsc="D30AC";
    break;
case 'THESSALONIKI': $ifsc="B6A9E";
    break;
}
$date=date("Y-m-d");
$sql3="SELECT MAX(id) from customer";
$result=mysqli_query($con,$sql3) or die(mysqli_error($con));
$rws=  mysqli_fetch_array($result);
$id=$rws[0]+1;
$id=  cleanData($con,$id);

$ds=ldap_connect("localhost");
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

if ($ds) {

      if ($type=='current')
        $clients = ", ou=registeredUsers,OU=Finance, O=Axis, c=EL";
      else
        $clients = ", ou=unregisteredUsers,OU=Finance, O=Axis, c=EL";



    $ldapuser = 'cn=' . $email. $clients;

    $directory_entry["cn"]=$email;
    $directory_entry["userPassword"]=$password;
    $directory_entry["objectclass"][0]="top";
    $directory_entry["objectclass"][1]="person";
    $directory_entry["objectclass"][2]="organizationalPerson";

    $r=ldap_bind($ds,'cn=Manager,c=EL','ellas');

    $r=ldap_add($ds,$ldapuser,$directory_entry);
    if($r) {
      $sql1="CREATE TABLE passbook".$id."
          (transactionid int(5) AUTO_INCREMENT, transactiondate date, name VARCHAR(255), branch VARCHAR(255), ifsc VARCHAR(255), credit int(10), debit int(10),
          amount float(10,2), narration VARCHAR(255), PRIMARY KEY (transactionid))";

      $sql=$con->prepare("insert into customer (`id`,`name`, `gender`, `dob`, `nominee`, `account`, `address`, `mobile`, `email`, `password`, `branch`, `ifsc`,`lastlogin`, `accstatus`)
       values(?,?,?,?,?,?,?,?,
          ?,?,?,?,?,'ACTIVE')");
      $sql->bind_param('issssssssssss', $id,$name,$gender,$dob,$nominee,$type,$address,
      $mobile,$email,$password,$branch,$ifsc,$date);
      $sql->execute() or die("<script type='text/javascript'>alert('Username already exists!'); </script>");

      mysqli_query($con,$sql1) or die(mysqli_error($con));

      $sql4=$con->prepare("insert into passbook".$id." (`transactiondate`, `name`, `branch`, `ifsc`, `credit`, `debit`, `amount`, `narration`)
       values(?,?,?,?,?,'0',?,'Account Open')");
      $sql4->bind_param('ssssss',$date,$name,$branch,$ifsc,$credit,$credit);
      $sql4->execute() or die(mysqli_error($con));

      echo '<script>alert("Customer Account Successfully Added!");';
      echo 'window.location= "admin_hompage.php";</script>';

    }
    else
     echo '<script>alert("Customer Account Not Added!");</script>';
}
else {
 echo "Unable to connect to LDAP server";
}


?>
