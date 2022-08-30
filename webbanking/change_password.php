<?php
session_start();
include 'dbconn.php';
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
  <script>
  $(document).ready(function(){

    var reg = /^S*(?=\S*[\W])(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/;

    $('input[type="button"]').click(function() {
      if($("input[name=new_password]").val().length<8) {
          alert('Password should be at least 8 characters');
      }
      else if (reg.test($("input[name=new_password]").val())==false) {
          alert('Password should have at least a capital letter,a small letter,digit and special symbol');
      }
       else {
          $('form').submit();
      }
      });

  });
  </script>

        <title>Change Password</title>

    </head>

           <?php include 'admin_navbar.php'?>
           <div class="container">
             <div class="jumbotron2 text-center">
            <form action="" name="change_form" method="POST">
                <table align="center">
                    <tr>
                        <td>Enter old password</td>
                        <td><input type="password" class="form_control" name="old_password" required=""/></td>
                    </tr>
                    <tr>
                        <td>Enter new password</td>
                        <td><input type="password" class="form_control" name="new_password" required=""/></td>
                    </tr>
                    <tr>
                        <td>Enter password again</td>
                        <td><input type="password" class="form_control" name="again_password" required=""/></td>
                    </tr>
                    <tr>

                        <td colspan="2" align='center' style='padding-top:20px'><input type="button" name="change_password" value="Change Password" class="btn btn-info"/></td>
                    </tr>
                </table>
            </form>
                </div>
            </div>

            <?php

            if (!empty($_POST)){
              include 'cleandata.php';
            $change=$_SESSION['admin_id'];
            $change=cleanData($con,$change);
            $sql="SELECT * FROM admin WHERE name='$change'";
            $result=mysqli_query($con,$sql);
            $rws=  mysqli_fetch_array($result);
            $old=  cleanData($con,$_REQUEST['old_password']);
            $new=  cleanData($con,$_REQUEST['new_password']);
            $again=  cleanData($con,$_REQUEST['again_password']);

            $username=$rws[8];

            if($rws[9]==$old && $new==$again){

              $ds=ldap_connect("localhost");
              ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
              ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

              if ($ds) {

                if(isset($_SESSION['admin_login'])){
                    if ($_SESSION['admin_login']==1)
                      $clients = ", ou=Admin,OU=Manager, O=Axis, c=EL";
                    else
                      $clients = ", ou=Admin,OU=Manager, O=Axis, c=EL";
                    }

                  $ldapuser = 'cn=' . $username. $clients;
                  $ldappass=$old;
                  $directory_entry["userPassword"]=$new;

                  $r=ldap_bind($ds,'cn=Manager,c=EL','ellas');

                  $r=ldap_modify($ds,$ldapuser,$directory_entry);
                  if($r) {
                    $sql=$con->prepare("UPDATE admin SET pwd=? WHERE id=?");
                    $sql->bind_param("si", $new, $change);
                    $sql->execute() or die(mysqli_error($con));
                      echo '<script>alert("Password Change Successful!");';
                      echo 'window.location= "admin_hompage.php";</script>';
                  }
                  else
                   echo '<script>alert("Password Change Not Successful!");</script>';
              }
              else {
               echo "Unable to connect to LDAP server";
              }

           }
            else{
              echo '<script>alert("Wrong Password or Mismatch!Try Again!");';
              echo 'window.location= "change_password.php";</script>';
            }
            }
            ?>


        </div>
