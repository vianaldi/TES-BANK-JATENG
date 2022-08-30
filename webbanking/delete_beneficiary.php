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
  if($_SESSION['customer_login']==2)
    header('location:customer_account_summary.php');
}
?>
<?php
if(isset($_REQUEST['submit_id']))
{
include 'dbconn.php';
include 'cleandata.php';
$customer_id=$_REQUEST["customer_id"];
$customer_id=cleanData($con,$customer_id);
$sql="DELETE FROM beneficiary1 WHERE id='$customer_id'";
$result=  mysqli_query($con,$sql) or die(mysqli_error($con));

echo '<script>alert("Beneficiary Deleted successfully.");';
                     echo 'window.location= "display_beneficiary.php";</script>';

}
?>
