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
  if($_SESSION['admin_login']==2)
    header('location:admin_hompage.php');
}
?>
    <?php
include 'dbconn.php';
include 'cleandata.php';
$name=  cleanData($con,$_REQUEST['customer_name']);
$gender=  cleanData($con,$_REQUEST['customer_gender']);
$dob=  cleanData($con,$_REQUEST['customer_dob']);
$relationship=  cleanData($con,$_REQUEST['customer_nominee']);
$department=  cleanData($con,$_REQUEST['customer_account']);
$address=  cleanData($con,$_REQUEST['customer_address']);
$mobile=  cleanData($con,$_REQUEST['customer_mobile']);

//salting of password

$password=  $_REQUEST['customer_pwd'];
$password=  cleanData($con,$password);

$date=date("Y-m-d");
$sql3="SELECT MAX(id) from admin";
$result=mysqli_query($con,$sql3) or die(mysqli_error($con));
$rws=  mysqli_fetch_array($result);
$id=$rws[0]+1;
$id=  cleanData($con,$id);

$ds=ldap_connect("localhost");
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

if ($ds) {

      if ($department=='developer')
        $clients = ", ou=Admin,OU=Manager, O=Axis, c=EL";
      else
        $clients = ", ou=subAdmin,OU=Manager, O=Axis, c=EL";


    $ldapuser = 'cn=' . $name. $clients;

    $directory_entry["cn"]=$name;
    $directory_entry["userPassword"]=$password;
    $directory_entry["objectclass"][0]="top";
    $directory_entry["objectclass"][1]="person";
    $directory_entry["objectclass"][2]="organizationalPerson";

    $r=ldap_bind($ds,'cn=Manager,c=EL','ellas');

    $r=ldap_add($ds,$ldapuser,$directory_entry);
    if($r) {
      $sql=$con->prepare("insert into admin (`id`,`name`,`gender`,`dob`,`relationship`,`department`,
        `address`, `mobile`,`login_id`,`pwd`,`lastlogin`)
       values(?,?,?,?,?,?,?,?,?,?,?)");
      $sql->bind_param('issssssssss', $id,$name,$gender,$dob,$relationship,$department,$address,$mobile,
      $name,$password,$date);
      $sql->execute() or die("<script type='text/javascript'>alert('Username already exists!'); </script>");

      echo '<script>alert("Admin Account Successfully Added!");';
      echo 'window.location= "admin_hompage.php";</script>';

    }
    else
     echo '<script>alert("Account Not Added!");</script>';
}
else {
 echo "Unable to connect to LDAP server";
}

?>
