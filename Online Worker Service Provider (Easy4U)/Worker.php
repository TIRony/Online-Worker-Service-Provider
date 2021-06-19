<?php
include "includes/db_connect.inc.php";

session_start();
$empty = "";
$username = $_SESSION['userName'];

if($_SERVER["REQUEST_METHOD"] == "POST")
 {
   if(isset($_POST['signout'])){
       $_SESSION['userName'] = $empty;
       header("Refresh:0; url=Home.php");
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
      <form method="post" action="Worker.php">
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
        <nav>
          <ul>
            <li><button type="submit" name="signout" id="logout">Logout</button></li>
          </ul>
        </nav>
        </div>
        <nav>
          <ul>
            <li class="current"><a href="Home.php">Home</a></li>
            <li><a href="">About</a></li>
            <li><a href="">Services</a></li>
            <li><a href="">How it works</a></li>
          </ul>
        </nav>
      </form>
    </div>
  </header>


<section id="CustomerSidebar">
      <div class="container">
        <form class="EmployeeSidebar">
        <nav>
          <ul>
            <div class="HireNowBorder">
            <li class="current"><a href="worker.php">My Account</a></li><br><br>
          </div>
            <li><a href="WorkerAccountInfo.php">My Account Information</a></li><br><br><br>
            <li><a href="PreviousRecordWorker.php">Prevoius Record</a></li><br><br>
            <br><li><a href="WorkerSetting.php">Settings</a></li><br><br>
          </ul>
        </nav>
      </form>
       </div>
     </section>

<form id="Customerbar">
     <section id="customerTextbar">
       <div class="container">
         <form class="textbarContact">
             <h2><span class="highlight">Hello</span>, <?php echo $username ?> <h2>

              <h3>Customer is everything!! Take care of them...</h3>
           
         </form>


<aside id="WorkToDo">
  <div class="HireNowBack1">
    <h3><span class="highlight">Next</span> Work</h3>
  </div>
  <div class="HireNowBack2">
      <div>
        <form class="request">
          <h3>No work yet...</h3>
        </form>
     </div>
    </aside>
   </form>
  </div>
</section>

    <section id="myTranjection">
      <div class="container">
        <div class="tran">
          <form class="size">
          <img src="./img/surved.jpg">
          <h1>00</h1>
          <h3>Service Done</h3>
        </div>
        <div class="tran">
          <img src="./img/tranjection.jpg">
          <h1>00</h1>
          <h3>Total Earn</h3>
        </div>
        <div class="tran"><er>
          <img src="./img/rating.jpg">
          <h1>00</h1>
          <h3>Rating</h3>
        </div>
      </form>
      </div>
    </section>

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