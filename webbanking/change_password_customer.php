<?php
session_start();
include 'dbconn.php';
include 'sessionexpire.php';
include 'ErrorHandling.php';

if(session_status() == PHP_SESSION_NONE){
    header('location:index.php');
}else {
  if(!($_SESSION['customer_login']==1 || $_SESSION['customer_login']==2)){
    session_destroy();
    header('location:index.php');
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
    </head>
    <script>
    $(document).ready(function(){

      var reg = /^S*(?=\S*[\W])(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/;

      $('input[type="button"]').click(function() {
        if($("input[name=new_password]").val().length<8) {
            alert('Password should be at least 8 characters');
        }
        else if (reg.test($("input[name=new_password]").val())==false) {
            alert('Password should have at least a capital letter,a small letter,a digit and special symbol');
        }
         else {
            $('form').submit();
        }
        });

    });
    </script>

    <?php
      if(isset($_SESSION['customer_login'])){
          if ($_SESSION['customer_login']==1)
            include 'customer_navbar.php';
          else
            include 'customer_navbar2.php';
          }
    ?>

           <div class="container">
           <div class="jumbotron2 text-center">
    <h3 style="text-align:center;color:#2E4372;"><u>Change Password</u></h3>
    <br><br>
            <form action="" method="POST">
              <div class='form-group form-inline'>
              <label>Enter old password:</label>
              <input type="password" class="form-control" name="old_password" required=""/>
              </div>
              <div class='form-group form-inline'>
              <label>Enter new password:</label>
              <input type="password" class="form-control" name="new_password" required=""/>
              </div>
              <div class='form-group form-inline'>
              <label>Enter password again:</label>
              <input type="password" class="form-control" name="again_password" required=""/>
              </div>
              <input type="button" name="change_password" value="Change Password" class="btn btn-info"/>
            </form>
            <?php
            include 'cleandata.php';
            $change=$_SESSION['login_id'];
            $change=cleanData($con,$change);
            if (!empty($_POST)){
            $sql="SELECT * FROM customer WHERE id='$change'";
            $result=mysqli_query($con,$sql);
            $rws=  mysqli_fetch_array($result);


            $old=  $_REQUEST['old_password'];
            $new=  $_REQUEST['new_password'];
            $again=$_REQUEST['again_password'];
            $old=cleanData($con,$old);
            $new=cleanData($con,$new);
            $again=cleanData($con,$again);
            $salt="@g26jQsG&nh*&#8v";
            $old=  sha1($old.$salt);
            $new=  sha1($new.$salt);
            $again=sha1($again.$salt);

            $username=$rws[8];
            if($rws[9]==$old && $new==$again){


               $ds=ldap_connect("localhost");
               ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
               ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

               if ($ds) {

                 if(isset($_SESSION['customer_login'])){
                     if ($_SESSION['customer_login']==1)
                       $clients = ", ou=registeredUsers,OU=Finance, O=Axis, c=EL";
                     else
                       $clients = ", ou=unregisteredUsers,OU=Finance, O=Axis, c=EL";
                     }

                   $ldapuser = 'cn=' . $username. $clients;
                   $ldappass=$old;
                   $directory_entry["userPassword"]=$new;

                   $r=ldap_bind($ds,'cn=Manager,c=EL','ellas');

                   $r=ldap_modify($ds,$ldapuser,$directory_entry);
                   if($r) {
                     $sql=$con->prepare("UPDATE customer SET password=? WHERE id=?");
                     $sql->bind_param("si", $new, $change);
                     $sql->execute();

                     echo '<script>alert("Password Change Successful!");';
                     echo 'window.location= "change_password_customer.php";</script>';
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
                echo 'window.location= "change_password_customer.php";</script>';
            }
            }
            ?>

          </div>
        </div>
      </body>
