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
$id=  cleanData($con,$_REQUEST['current_id']);
$relationship=  cleanData($con,$_REQUEST['customer_nominee']);
$department=  cleanData($con,$_REQUEST['customer_account']);
$address=  cleanData($con,$_REQUEST['customer_address']);
$mobile=  cleanData($con,$_REQUEST['customer_mobile']);
$login_id=  cleanData($con,$_REQUEST['edit_email']);

$sql=$con->prepare("SELECT * FROM `admin` WHERE id= ? and department='finance'");
$sql->bind_param('s', $id);
$sql->execute();
$result = $sql->get_result();

$row = $result->fetch_assoc();
$rws=array_values($row);

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

          if ($department=='developer')
            $clients = ", ou=Admin,OU=Manager, O=Axis, c=EL";
          else
            $clients = ", ou=subAdmin,OU=Manager, O=Axis, c=EL";

          $ldapuser = 'cn=' . $name. $clients;


          $directory_entry["cn"]=$name;
          $directory_entry["userPassword"]=$rws[9];
          $directory_entry["objectclass"][0]="top";
          $directory_entry["objectclass"][1]="person";
          $directory_entry["objectclass"][2]="organizationalPerson";

          $r2=ldap_add($ds,$ldapuser,$directory_entry);
          if($r2) {

            $sql=$con->prepare("UPDATE admin SET  name=?, dob=?, relationship=?, department=?,
                 address=?,
                    mobile=?, gender=? ,login_id=? WHERE id=?");
            $sql->bind_param('ssssssssi', $name,$dob,$relationship,$department,$address,
            $mobile,$gender,$login_id,$id);
            $sql->execute() or
              die("<script type='text/javascript'>alert('Username already exists!');window.location= 'admin_hompage.php'; </script>");

            echo '<script>alert("Admin Account Successfully Edited!");</script>';
            echo '<script>window.location= "admin_hompage.php";</script>';

          }
          else
           echo '<script>alert("Account Not Edited!");</script>';
      }else
       echo '<script>alert("Account Not Edited!");</script>';
}else {
 echo "Unable to connect to LDAP server";
}

?>
