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
$name=  cleanData($con,$_REQUEST['edit_name']);
$gender=  cleanData($con,$_REQUEST['edit_gender']);
$dob=  cleanData($con,$_REQUEST['edit_dob']);
$id=  cleanData($con,$_REQUEST['current_id']);
$type=  cleanData($con,$_REQUEST['edit_account']);
$nominee=  cleanData($con,$_REQUEST['edit_nominee']);
$address=  cleanData($con,$_REQUEST['edit_address']);
$mobile=  cleanData($con,$_REQUEST['edit_mobile']);
$email=  cleanData($con,$_REQUEST['edit_email']);

$sql=$con->prepare("SELECT * FROM `customer` WHERE id= ?");
$sql->bind_param('s', $id);
$sql->execute();
$result = $sql->get_result();

$row = $result->fetch_assoc();
$rws=array_values($row);

$ds=ldap_connect("localhost");
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

if ($ds) {

      if ($rws[5]=='current')
        $clients = ", ou=registeredUsers,OU=Finance, O=Axis, c=EL";
      else
        $clients = ", ou=unregisteredUsers,OU=Finance, O=Axis, c=EL";

      $ldapuser = 'cn=' . $rws[8]. $clients;

        $r=ldap_bind($ds,'cn=Manager,c=EL','ellas');

        $r=ldap_delete($ds,$ldapuser);

        if($r) {

          if ($type=='current')
            $clients = ", ou=registeredUsers,OU=Finance, O=Axis, c=EL";
          else
            $clients = ", ou=unregisteredUsers,OU=Finance, O=Axis, c=EL";

          $ldapuser = 'cn=' . $email. $clients;


          $directory_entry["cn"]=$email;
          $directory_entry["userPassword"]=$rws[9];
          $directory_entry["objectclass"][0]="top";
          $directory_entry["objectclass"][1]="person";
          $directory_entry["objectclass"][2]="organizationalPerson";

          $r2=ldap_add($ds,$ldapuser,$directory_entry);
          if($r2) {

            $sql=$con->prepare("UPDATE customer SET  name=?, dob=?, nominee=?, account=?,
                 address=?,
                    mobile=?, gender=?,email=? WHERE id=?");
            $sql->bind_param('ssssssssi', $name,$dob,$nominee,$type,$address,
            $mobile,$gender,$email,$id);
            $sql->execute() or
              die("<script type='text/javascript'>alert('Username already exists!');window.location= 'admin_hompage.php'; </script>");

            echo '<script>alert("Customer Account Successfully Edited!");</script>';
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
