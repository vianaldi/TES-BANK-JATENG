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
if(isset($_REQUEST['submit_id']))
{
include 'dbconn.php';
$customer_id=$_REQUEST["customer_id"];

$sql=$con->prepare("UPDATE beneficiary1 SET status='ACTIVE' WHERE id=?");
$sql->bind_param('i',$customer_id);
$sql->execute() or die("<script type='text/javascript'>alert('Beneficiary Already Approved!');window.location= 'admin_hompage.php'; </script>");

$sql="UPDATE beneficiary1 SET status='ACTIVE' WHERE id='$customer_id'";
mysqli_query($con,$sql) or die("<script type='text/javascript'>alert('Beneficiary Already Approved!');window.location= 'admin_hompage.php'; </script>");
echo '<script>alert("Beneficiary Successfully Approved!");';
echo 'window.location= "admin_hompage.php";</script>';
}
?>
