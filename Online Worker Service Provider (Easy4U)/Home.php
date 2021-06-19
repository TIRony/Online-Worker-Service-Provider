<?php

include "includes/db_connect.inc.php";
session_start();
$empty = "";
if(empty($_SESSION['userName']))
{
    $userName = "";
}
else{
$userName = $_SESSION['userName'];
}
$TC = 0;
$sqlT = "SELECT cost FROM history";
    $resultT = mysqli_query($conn, $sqlT);

  while($rowT = mysqli_fetch_assoc($resultT)){
      $T = $rowT['cost'];
      $TC = $TC+$T;
  }

$TW = 0;
$sqlTW = "SELECT Active FROM worker";
    $resultTW = mysqli_query($conn, $sqlTW);

  while($rowTW = mysqli_fetch_assoc($resultTW)){
      $Tg = $rowTW['Active'];
      $TW = $TW+$Tg;
  }

  $TA = 0;
$sqlTA = "SELECT Assign FROM assignworker";
    $resultTA = mysqli_query($conn, $sqlTA);

  while($rowTA = mysqli_fetch_assoc($resultTA)){
      $Ta = $rowTA['Assign'];
      $TA = $TA+$Ta;
  }



if($_SERVER["REQUEST_METHOD"] == "POST")
{
   if(isset($_POST['signout'])){
       $_SESSION['userName'] = $empty;
       header("Refresh:0; url=Home.php");
    }
    if(isset($_POST['myAccount'])){
        $sqlUserCheck = "SELECT userName, phone, password, status FROM login WHERE userName = '$userName'";
        $result = mysqli_query($conn, $sqlUserCheck);

        while($row = mysqli_fetch_assoc($result)){
            $passwordInDB = $row['password'];
            $phoneInDB = $row['phone'];
            $statusInDB = $row['status'];

            if($statusInDB == 1)
                {
                    $_SESSION['userName'] = $userName;
                    $_SESSION['password'] = $password;
                    header("Location: Admin.php");
                }
                else if($statusInDB == 2)
                {
                    $_SESSION['userName'] = $userName;
                    $_SESSION['password'] = $password;
                header("Location: Employee.php");
                }
                else if($statusInDB == 3)
                {
                    $_SESSION['userName'] = $userName;
                    $_SESSION['password'] = $password;
                    header("Location: Customer.php");
                }
                else if($statusInDB == 4)
                {
                    $_SESSION['userName'] = $userName;
                    $_SESSION['password'] = $password;
                header("Location: Worker.php");
                }
    }
}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Easy4U</title>
	<link rel="stylesheet" href="./CSS/Home.css">
</head>
<body>
	<header>
		<div class="container">
		<div id="branding">
          <h1><span class="highlight">Easy4U</span></h1>
        </div>
        <div id="upperRightBranding">
        <nav>
          <ul>
            <li><a href="">Contact</a></li>
            <h5>Call: 01951265659</h5>
          </ul>
        </nav>
        </div>
        <div id="upperLeft">
        <form method="post" action="Home.php">
        <nav>
          <ul>
            <li id="login"><a href="LoginSignup.php">Sign Up or Login</a></li>
            <!--<li><a href="Home.php" onclick="wsListSalons();" name="signout">Sign Out</a></li>-->
            <li><button type="submit" name="signout" id="logout">Logout</button></li>
            <li><button type="submit" name="myAccount" id="accountFromHome">My Account</button></li>
          </ul>
        </nav>
        </div>
    </form>
        <nav>
          <ul>
            <li class="current"><a href="Home.php">Home</a></li>
            <li><a href="">About</a></li>
            <li><a href="">Services</a></li>
            <li><a href="">How it works</a></li>
          </ul>
        </nav>
		</div>

        <script>
         var userName = "<?php echo $userName ?>";
         if(userName != ""){
         document.getElementById('login').style.display = 'none';
     }
     else{
       document.getElementById('logout').style.display = 'none';
        document.getElementById('accountFromHome').style.display = 'none';
     }
         
        </script>
	</header>
	<section id="showcase">
      <div class="container">
        <h1>MAKE YOUR LIFE EASY!!</h1>

      </div>
    </section>

    <section id="tranjection">
    	<div class="container">
    		<div class="tran">
    			<h1><?php echo $TC; ?></h1>
    			<h4>Tranjection</h4>
    		</div>
    		<div class="tran">
    			<h1><?php echo $TW; ?></h1>
    			<h4>Active Workers</h4>
    		</div>
    		<div class="tran">
    			<h1><?php echo $TA; ?></h1>
    			<h4>Inactive Workers</h4>
    		</div>
    	</div>
    </section>

    <section id="menuPara">
       <div class="container">
    	<div id="branding">
          <p><span class="highlight">Easy4U</span> Proudly serving Bangladeshi people while making lives easy and stress free</p>
        </div>
       </div>
    </section>

    <section id="ourServices">
    	<div class="container">
    		<h2>Our <span class="highlight">Services</span></h2>
    		<div class="service">
    			<img src="./img/plumber.jpg">
    			<nav>
    				<ul>
    					<li><a href="">Plumbing</a></li>
    				</ul>
    			</nav>
    		</div>
    		<div class="service">
    			<img src="./img/electric.png">
    			<nav>
    				<ul>
    					<li><a href="">Electrical</a></li>
    				</ul>
    			</nav>
    		</div>
    		<div class="service">
    			<img src="./img/labor.jpg">
    			<nav>
    				<ul>
    					<li><a href="">Labor</a></li>
    				</ul>
    			</nav>
    		</div>
    		<div class="service">
    			<img src="./img/guard.jpg">
    			<nav>
    				<ul>
    					<li><a href="">Guard</a></li>
    				</ul>
    			</nav>
    		</div>
    	</div>
    </section>
    <section id="menuPara">
       <div class="container">
        <div id="branding">
          <p>For worker position do <span class="highlight"><a href="registration.php">REGISTRATION</a></span> here!</p>
        </div>
       </div>
    </section>

    <section id="contactlist">
      <div class="container">
      	<div class="contact">
      		<h4>Call Us</h4><er>
      		<h4>01951265659</h4>
      	</div>
      	<div class="contact">
      		<h4>Mail Us</h4><er>
      		<h4>Easy4U@gmail.com</h4>
      	</div>
      	<div class="contact">
      		<h4>Visit Us</h4><er>
      		<h4>Road 1, House 4, Gulshan</h4>
      	</div>
      </div>
    </section>
    <footer>
    	<div class="container">
    		<div class="Footer">
    			<div id="FooterTitle">
    			<h2>Easy4U</h2>
    		    </div>
    			<div id="FooterAboutUs">
    			<h3>About us</h3><er>
    			<nav>
    				<ul>
    					<li><a href="">Terms of use</a></li>
    					<li><a href="">Privacy policy</a></li>
    					<li><a href="">Contact us</a></li>
    				</ul>
    			</nav>
    		</div>
    		</div>
    		<div class="Footer">
    			<div id="FooterService">
    			<h3>Services</h3><er>
    			<nav>
    				<ul>
    					<li><a href="">Plumping</a></li>
    					<li><a href="">Electrical</a></li>
    					<li><a href="">Labor</a></li>
    					<li><a href="">Guard</a></li>
    				</ul>
    			</nav>
    			</div>
    		</div>
    	</div>
    	<p>Easy4U, Copyright &copy; 2019</p>
    </footer>
</body>
</html>