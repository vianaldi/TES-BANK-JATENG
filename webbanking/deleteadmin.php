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
$id=  cleanData($con,$_REQUEST['customer_id']);

$sql=$con->prepare("SELECT * FROM `admin` WHERE id= ?");
$sql->bind_param('s', $id);
$sql->execute();
$result = $sql->get_result();

$row = $result->fetch_assoc();
$rws=array_values($row);
?>
<?php
                    $delete_id=  cleanData($con,$_REQUEST['customer_id']);
                    if(isset($_REQUEST['submit2_id'])){

                      $ds=ldap_connect("localhost");
                      ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
                      ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

                      if ($ds) {

                            if ($rws[5]=='developer')
                              $clients = ", ou=Admin,OU=Manager, O=Axis, c=EL";
                            else
                              $clients = ", ou=subAdmin,OU=Manager, O=Axis, c=EL";

                          $ldapuser = 'cn=' . $rws[1]. $clients;

                          $r=ldap_bind($ds,'cn=Manager,c=EL','ellas');

                          $r=ldap_delete($ds,$ldapuser);
                          if($r) {
                            $sql=$con->prepare("DELETE FROM `admin` WHERE `id` = ?");
                            $sql->bind_param('s', $delete_id);
                            $sql->execute() or die(mysqli_error($con));

                            echo '<script>alert("Account Successfully Deleted!");';
                            echo 'window.location= "delete_admin.php";</script>';
                          }
                          else
                           echo '<script>alert("Account Not Deleted!");</script>';
                      }
                      else {
                       echo "Unable to connect to LDAP server";
                      }

}
?>
