<?php
if(isset($_REQUEST['submitBtn'])){
    include 'dbconn.php';
    include 'ErrorHandling.php';
    $username=$_REQUEST['uname'];

    //salting of password
    $salt="@g26jQsG&nh*&#8v";
    $ldappass= sha1($_REQUEST['pwd'].$salt);

    ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
    $ds=ldap_connect("localhost");
    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

    $clients = ", ou=registeredUsers,OU=Finance,O=Axis,c=EL";
    $clients2 = ", ou=unregisteredUsers,OU=Finance,O=Axis,c=EL";
    $ldapuser = 'cn=' . $username. $clients;
    $ldapuser2 = 'cn=' . $username. $clients2;

    if ($ds) {
    	$r=ldap_bind($ds, $ldapuser, $ldappass);
      $r2=ldap_bind($ds, $ldapuser2, $ldappass);

    	if ($r) {
        session_start();
        $_SESSION['customer_login']=1;
        $_SESSION['cust_id']=$username;
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + (15*60);
        header('location:customer_account_summary.php');
        	}
        else if($r2) {
          session_start();
          $_SESSION['customer_login']=2;
          $_SESSION['cust_id']=$username;
          $_SESSION['start'] = time();
          $_SESSION['expire'] = $_SESSION['start'] + (15*60);
          header('location:customer_account_summary.php');
        }
    		else{
            session_start();
            $_SESSION['customer_login']=0;
            $_SESSION['start'] = time();
            $_SESSION['expire2'] = $_SESSION['start'] + (10);
            header('location:ErrorLoginPage.php');
    		}
    }
else {
  echo "Unable to connect to LDAP server";
}
}
?>
<?php
session_start();

if(isset($_SESSION['customer_login'])){
  if ($_SESSION['customer_login']==0)
    header('location:ErrorLoginPage.php');
  else
    header('location:customer_account_summary.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>HomePage</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="mystyle.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#about">ABOUT</a></li>
        <li><a href="#services">SERVICES</a></li>
        <li><a href="#contact">CONTACT</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>E-banking BANK JATENG</h1>
  <p>Login to your account</p>
  <p id="test1" style="color:#FFA07A;"></p>
  <div class="container">
    <form action="" method="POST">
      <div class="form-group">
        <input type="text" class="form-control" name="uname" placeholder="Enter email" required>
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="pwd" placeholder="Enter password" required>
      </div>
      </div>
      <button name="submitBtn" id="btn1" class="btn btn-warning">Login</button>
    </form>
  </div>
</div>

<!-- Container (About Section) -->
<div id="about" class="container-fluid" style="padding-bottom:20px">
  <div class="row">
    <div class="col-sm-8">
      <h2>TENTANG PERUSAHAAN</h2><br>Identitas Bank Jateng di lambangkan dengan bentuk SINAR MATAHARI, yang merupakan sumber kehidupan dan cahaya penuntun bagi Bank Jateng dalam menjalankan roda bisnisnya dan menunjukkan kemajuan dalam setiap pola pikir dan pembaharuan bagi lingkungan dalam mencapai prestasi dan melambangkan kesehatan serta kesejahteraan bank, termasuk semua pihak yang terkait didalamnya ( karyawan, stakeholder, konsumen).</h4><br>
      <p>Pancarannya merupakan sumber energy yang tidak terbatas, begitu luas hingga mengjangkau pelosok daerah. Kehadirannya setiap hari menunjukkan komitment, integritas, kekuatan dan kebanggan yang abadi. Huruf yang digunakan adalah jenis sans-serif modifikasi. Jenis huruf ini menunjukkan fleksibilitas, modernitas, tanpa meninggalkan nilai-nilai warisan</p>
      <br><a href="#contact"><button class="btn btn-default btn-lg" >Get in Touch</button></a>
    </div>
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-signal logo"></span>
    </div>
  </div>
</div>

<div class="container-fluid bg-grey" style="padding:20px">
  <div class="row">
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-globe logo slideanim"></span>
    </div>
    <div class="col-sm-8">
      <h2>Our Values</h2><br>
      <h4><strong>MISSION:</strong> Memberikan layanan prima didukung oleh kehandalan SDM dengan teknologi modern, serta jaringan yang luas dan Membangun budaya Bank dan mempertahankan Bank sehat.</h4><br>
      <p><strong>VISION:</strong> Bank Terpercaya, menjadi kebanggaan masyarakat, mampu menunjang pembangunan daerah</p>
    </div>
  </div>
</div>

<!-- Container (Services Section) -->
<div id="services" class="container-fluid text-center" style="padding-bottom:20px">
  <h2>SERVICES</h2>
  <h4>What we offer</h4>
  <br>
  <div class="row slideanim">
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-off logo-small"></span>
      <h4>PROFESIONAL</h4>
      <p>Lorem ipsum dolor sit amet..</p>
    </div>
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-heart logo-small"></span>
      <h4>INTEGRITAS</h4>
      <p>Lorem ipsum dolor sit amet..</p>
    </div>
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-lock logo-small"></span>
      <h4>DISIPLIN</h4>
      <p>Lorem ipsum dolor sit amet..</p>
    </div>
  </div>
  <br><br>
  <div class="row slideanim">
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-leaf logo-small"></span>
      <h4>INOVASI</h4>
      <p>Lorem ipsum dolor sit amet..</p>
    </div>
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-certificate logo-small"></span>
      <h4>CERTIFIED</h4>
      <p>Lorem ipsum dolor sit amet..</p>
    </div>
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-wrench logo-small"></span>
      <h4 style="color:#303030;">HARD WORK</h4>
      <p>Lorem ipsum dolor sit amet..</p>
    </div>
  </div>
</div>

<!-- Container (Contact Section) -->
<div id="contact" class="container-fluid bg-grey">
  <h2 class="text-center">CONTACT</h2>
  <div class="row">
    <div class="col-sm-5">
      <p>Contact us and we'll get back to you within 24 hours.</p>
      <p><span class="glyphicon glyphicon-map-marker"></span> Gedung Grinatha Lt. 1-7, Jalan Pemuda No. 142 Semaran</p>
      <p><span class="glyphicon glyphicon-phone"></span>Kantor Pusat 024-3547541</p>
      <p><span class="glyphicon glyphicon-envelope"></span> myemail@something.com</p>
    </div>
    <div class="col-sm-7 slideanim">
      <div class="row">
        <div class="col-sm-6 form-group">
          <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
        </div>
        <div class="col-sm-6 form-group">
          <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
        </div>
      </div>
      <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea><br>
      <div class="row">
        <div class="col-sm-12 form-group">
          <button class="btn btn-default pull-right" type="submit">Send</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){

  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){

        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });

  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        if (pos < winTop + 600) {
          $(this).addClass("slide");
        }
    });
  });
})
</script>

</body>
</html>
