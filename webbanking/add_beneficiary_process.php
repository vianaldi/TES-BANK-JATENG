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
  if ($_SESSION['customer_login']==2){
    header('location:customer_account_summary.php');
  }
}
?>
<?php
                include 'cleandata.php';
                include 'dbconn.php';
                $sender_id=$_SESSION["login_id"];
                $sender_name=$_SESSION["name"];

                $Payee_name=$_REQUEST['name'];
                $acc_no=$_REQUEST['account_no'];
                $branch=$_REQUEST['branch_select'];
                $ifsc=$_REQUEST['ifsc_code'];

                $Payee_name=cleanData($con,$Payee_name);
                $acc_no=cleanData($con,$acc_no);
                $branch=cleanData($con,$branch);
                $ifsc=cleanData($con,$ifsc);

                $sql=$con->prepare("SELECT * FROM beneficiary1 WHERE sender_id=? AND reciever_id=?");
                $sql->bind_param('ss', $sender_id,$acc_no);
                $sql->execute();
                $result = $sql->get_result();

                $row = $result->fetch_assoc();
                $rws1=array_values($row);

                $s1=$rws1[1];
                $s2=$rws1[3];

                $sql=$con->prepare("SELECT * FROM customer WHERE id=? AND name=?");
                $sql->bind_param('ss', $acc_no,$Payee_name);
                $sql->execute();
                $result = $sql->get_result();

                $row = $result->fetch_assoc();
                $rws=array_values($row);

                if($sender_id==$rws[0]) //can't send request to himself
                {
                echo '<script>alert("You cant add yourself as a beneficiery!");';
                     echo 'window.location= "add_beneficiary.php";</script>';
                }

                elseif($s1==$sender_id && $s2==$acc_no)
                {
                    echo '<script>alert("You cant add a beneficiery twice!");';
                     echo 'window.location= "add_beneficiary.php";</script>';
                }

                elseif($rws[1]!=$Payee_name && $rws[0]!=$acc_no && $rws[11]!=$branch && $rws[12]!=$ifsc)
                {
                echo '<script>alert("Beneficiary Not Found!\nPlease enter correct details");';
                     echo 'window.location= "add_beneficiary.php";</script>';
                }


                else{

                    $status="PENDING";
                $sql="insert into beneficiary1 (`sender_id`, `sender_name`, `reciever_id`, `reciever_name`, `status`)  values('$sender_id','$sender_name','$acc_no','$Payee_name','$status')";
                mysqli_query($con,$sql) or die(mysqli_error($con));
                header("location:display_beneficiary.php");
                }
