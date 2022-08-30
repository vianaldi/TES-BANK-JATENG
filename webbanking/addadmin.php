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
  <script src="checkpass.js"></script>

        <title>Add Admin</title>

    </head>
    <?php include 'admin_navbar.php'?>

<div class="container">
<div class="jumbotron2 text-center">
<form action="add_admin.php" method="POST">
            <table align="center">
                <tr><td colspan='2' align='center' style='color:#2E4372;'><h3><u>Add Admin</u></h3></td></tr>
                <tr>
                    <td> Admin's name:</td>
                    <td><input type="text" class="form-control" name="customer_name" required=""/></td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td>
                        M<input type="radio" name="customer_gender" value="M" checked/>
                        F<input type="radio" name="customer_gender" value="F" />
                    </td>
                </tr>
                <tr>
                    <td>
                        DOB:
                    </td>
                    <td>
                        <input type="date" class="form-control" name="customer_dob" required=""/>
                    </td>
                </tr>
                <tr>
                    <td>Relationship:</td>
                    <td>
                        <select name="customer_nominee" class="form-control">
                          <option>married</option>
                          <option>unmarried</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Department:</td>
                    <td>
                        <select name="customer_account" class="form-control">
                            <option>developer</option>
                            <option>finance</option>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Address:</td>
                    <td><textarea name="customer_address" class="form-control" required=""></textarea></td>
                </tr>
                <tr>
                    <td>Mobile:</td>
                    <td><input type="text" class="form-control" name="customer_mobile" required=""/></td>
                </tr>

                <tr>
                    <td>Password:</td>
                    <td><input type="password" class="form-control" name="customer_pwd" required=""/></td>
                </tr>
                <tr>
                    <td colspan="2" align='center' style='padding-top:20px'><input type="button" name="add_customer" value="Add Admin" class="btn btn-info"/></td>
                </tr>
            </table>
        </form>
      </div>
    </div>
    </body>
</html>
