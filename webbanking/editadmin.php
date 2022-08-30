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
$sql->bind_param('i', $id);
$sql->execute();
$result = $sql->get_result();

$row = $result->fetch_assoc();
$rws=array_values($row);

$id=  cleanData($con,$_REQUEST['customer_id']);
$sql="SELECT * FROM `admin` WHERE id=$id";
$result=  mysqli_query($con,$sql) or die(mysqli_error($con));
$rws=  mysqli_fetch_array($result);
  $rws[0]=cleanData($con,$rws[0]);
  $rws[1]=cleanData($con,$rws[1]);
  $rws[2]=cleanData($con,$rws[2]);
  $rws[3]=cleanData($con,$rws[3]);
  $rws[4]=cleanData($con,$rws[4]);
  $rws[5]=cleanData($con,$rws[5]);
  $rws[6]=cleanData($con,$rws[6]);
  $rws[7]=cleanData($con,$rws[7]);
  $rws[8]=cleanData($con,$rws[8]);
?>

<!DOCTYPE HTML>
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

        <title>staff editing</title>

    </head>

    <?php include 'admin_navbar.php'?>
    <div class="container-fluid">
    <div class="jumbotron2 text-center">
      <h3 style='color:#2E4372;'><u>Edit Admin Details</u></h3><br><br>
            <form action="alter_admin.php" method="POST">
                          <table align="center">
                            <input type="hidden" name="current_id" value="<?php echo $id;?>"/>
                              <tr>
                                  <td> Admin's name:</td>
                                  <td><input type="text" class="form-control" name="customer_name" value="<?php echo $rws[1];?>" required=""/></td>
                              </tr>
                              <tr>
                                  <td>Gender:</td>
                                  <td>
                                      M<input type="radio" name="customer_gender" value="M" <?php if($rws[2]=="M") echo "checked";?>/>
                                      F<input type="radio" name="customer_gender" value="F" <?php if($rws[2]=="F") echo "checked";?> />
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                      DOB:
                                  </td>
                                  <td>
                                      <input type="date" class="form-control" name="customer_dob" value="<?php echo $rws[3];?>" required=""/>
                                  </td>
                              </tr>
                              <tr>
                                  <td>Relationship:</td>
                                  <td>
                                      <select name="customer_nominee" class="form-control" value="<?php echo $rws[4];?>">
                                        <option>married</option>
                                        <option>unmarried</option>
                                      </select>
                                  </td>
                              </tr>

                              <tr>
                                  <td>Department:</td>
                                  <td>
                                      <select name="customer_account" class="form-control" value="<?php echo $rws[5];?>">
                                          <option>developer</option>
                                          <option>finance</option>

                                      </select>
                                  </td>
                              </tr>

                              <tr>
                                  <td>Address:</td>
                                  <td><textarea name="customer_address" class="form-control" required=""><?php echo $rws[6];?></textarea></td>
                              </tr>
                              <tr>
                                  <td>Mobile:</td>
                                  <td><input type="text" class="form-control" name="customer_mobile" value="<?php echo $rws[7];?>" required=""/></td>
                              </tr>

                              <tr>
                                  <td>login id:</td>
                                  <td><input type="text" class="form-control" name="edit_email" value="<?php echo $rws[8];?>" required=""/></td>
                              </tr>
                              <tr>
                                  <td colspan="2" align='center' style='padding-top:20px'><input type="submit" name="edit_customer" value="Edit Admin" class="btn btn-info"/></td>
                              </tr>
                          </table>
                      </form>

        </div>
        </div>


    </body>
</html>
