

<!DOCTYPE html>
<html>
<body style="background-color:  #d1dffa;">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=1024">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="mystyle.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <noscript><meta http-equiv="refresh" content="0;url=no-js.php"></noscript>
        <title>Admin Login - Online Banking</title>
    </head>

    <div class="container">
      <div class="jumbotron2 text-center">
    <form action='' method='POST'>
        <table class="table" align="center">
            <tr><td><h3>Admin Login</h3></td></tr>
            <tr><td colspan="3"><hr></td></tr>
            <tr><td>Username:</td></tr>
            <tr><td><input type="text" class="form-control" name="uname" required></td></tr>
            <tr><td>Password:</td></tr>
            <tr><td><input type="password" class="form-control" name="pwd" required></td></tr>
            <tr><td class="button1"><input type="submit" name="submitBtn" value="Log In" class="btn btn-info"></td></tr>
        </table>
    </form>
          </div>
        </div>

<?php
include 'dbconn.php';
include 'cleandata.php';
if(isset($_REQUEST['submitBtn'])){
  $username=  cleanData($con,$_REQUEST['uname']);
  $password=  cleanData($con,$_REQUEST['pwd']);

  $ds=ldap_connect("localhost");
  ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
  ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
  $clients = ", ou=Admin,OU=Manager, O=Axis, c=EL";
  $clients2 = ", ou=subAdmin,OU=Manager, O=Axis, c=EL";
  $ldapuser = 'cn=' . $username. $clients;
  $ldapuser2 = 'cn=' . $username. $clients2;
  $ldappass=$password;

  if ($ds) {
    $r=ldap_bind($ds, $ldapuser, $ldappass);
    $r2=ldap_bind($ds, $ldapuser2, $ldappass);

    if ($r) {
      session_start();
      $_SESSION['admin_login']=1;
      $_SESSION['admin_id']=$username;
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + (15*60);
      header('location:admin_hompage.php');
        }
      else if($r2) {
        session_start();
        $_SESSION['admin_login']=2;
        $_SESSION['admin_id']=$username;
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + (15*60);
        header('location:admin_hompage.php');
      }
      else{
          session_start();
          $_SESSION['admin_login']=0;
          $_SESSION['start'] = time();
          $_SESSION['expire2'] = $_SESSION['start'] + (10);
          header('location:ErrorAdminLoginPage.php');
      }
  }else {
    echo "Unable to connect to LDAP server";
  }
}
?>

<?php
session_start();

if(isset($_SESSION['admin_login'])){
  if ($_SESSION['admin_login']==0)
    header('location:ErrorAdminLoginPage.php');
  else
    header('location:admin_hompage.php');
  }
?>
