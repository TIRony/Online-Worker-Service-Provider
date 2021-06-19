<?php
include "includes/db_connect.inc.php";

session_start();
$password = $userName = $message = $messageSignup = $rowCount = $result = $passwordInDB = $phoneInDB = $userNameInDB = $confirmPassword = "";
$firstName = $lastName = $email = $phone = $confirmPhone = $DOB = $NID = $address = "";
$status = 3;

if($_SERVER["REQUEST_METHOD"] == "POST")
{
   if(isset($_POST['loginButton'])){    
    if(!empty($_POST['userName'])){
        $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    }
    if(!empty($_POST['password'])){
        $password = mysqli_real_escape_string($conn, $_POST['password']);
    }
    $sqlPhoneCheck = "SELECT userName, phone, password, status FROM login WHERE phone = '$userName'";
    $resultPhone = mysqli_query($conn, $sqlPhoneCheck);
    $rowCountPhone= mysqli_num_rows($resultPhone);

    $sqlUserCheck = "SELECT userName, phone, password, status FROM login WHERE userName = '$userName'";
    $result = mysqli_query($conn, $sqlUserCheck);
    $rowCount = mysqli_num_rows($result);

    if($rowCount >= 1){
        while($row = mysqli_fetch_assoc($result)){
            $passwordInDB = $row['password'];
            //$password = $row['password'];
            $phoneInDB = $row['phone'];
            $statusInDB = $row['status'];
            if($passwordInDB == $password){
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
            else{
                $message = "Wrong Password!";
            }
        }
    }
    else if($rowCountPhone >= 1)
    {
        while($rowPhone = mysqli_fetch_assoc($resultPhone)){
            $userNameInDB = $rowPhone['userName'];
            $passwordInDB = $rowPhone['password'];
            $phoneInDB = $rowPhone['phone'];
            $statusInDB = $rowPhone['status'];
            if($passwordInDB == $password){
                if($statusInDB == 1)
                {
                    $_SESSION['userName'] = $userNameInDB;
                    header("Location: Admin.php");
                }
                else if($statusInDB == 2)
                {
                    $_SESSION['userName'] = $userNameInDB;
                header("Location: Employee.php");
                }
                if($statusInDB == 3)
                {
                    $_SESSION['userName'] = $userNameInDB;
                    header("Location: Customer.php");
                }
                else if($statusInDB == 4)
                {
                    $_SESSION['userName'] = $userNameInDB;
                header("Location: Worker.php");
                }
            }
            else{
                $message = "Wrong Password!";
            }
        }

    }
    else{
                $message = "Phone or User name doesn,t exist!";
            }
 }
 if(isset($_POST['signupButton'])){
    if(!empty($_POST['userName'])){
        $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    }
    if(!empty($_POST['firstName'])){
        $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    }
    if(!empty($_POST['lastName'])){
        $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    }
    if(!empty($_POST['password'])){
        $password = mysqli_real_escape_string($conn, $_POST['password']);
    }
    if(!empty($_POST['confirmPassword'])){
        $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);
    }
    if(!empty($_POST['phone'])){
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    }
    if(!empty($_POST['confirmPhone'])){
        $confirmPhone = mysqli_real_escape_string($conn, $_POST['confirmPhone']);
    }
    if(!empty($_POST['email'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
    }
    if(!empty($_POST['DOB'])){
        $DOB = mysqli_real_escape_string($conn, $_POST['DOB']);
    }
    if(!empty($_POST['NID'])){
        $NID = mysqli_real_escape_string($conn, $_POST['NID']);
    }
    if(!empty($_POST['address'])){
        $address = mysqli_real_escape_string($conn, $_POST['address']);
    }

    if($phone == $confirmPhone && $password == $confirmPassword){
        $phone = $confirmPhone;
        $password = $confirmPassword;
        $sqlUserCheck = "SELECT userName FROM login WHERE userName = '$userName'";
        $result = mysqli_query($conn, $sqlUserCheck);

  while($row = mysqli_fetch_assoc($result)){
      $userNameInDB = $row['userName'];
  }

    $sqlPhoneCheck = "SELECT phone FROM customer WHERE phone = '$phone'";
    $resultPhone = mysqli_query($conn, $sqlPhoneCheck);

  while($rowPhone = mysqli_fetch_assoc($resultPhone)){
      $phoneInDB = $rowPhone['phone'];
  }
if($userNameInDB == $userName){
      $messageSignup = "User Name already exist!";
    }
   else if($phoneInDB == $phone){
      $messageSignup = "Phone already exist!";
    }
    else{
      $sql = "INSERT INTO customer (firstName, lastName, userName, email, phone, NID, address, DOB)
              VALUES ('$firstName', '$lastName', '$userName', '$email', '$phone', '$NID', '$address', '$DOB');";
      $sql2 = "INSERT INTO login (userName, phone, password, status)
              VALUES ('$userName', '$phone', '$password', '3');";
              mysqli_query($conn, $sql);
              mysqli_query($conn, $sql2);
              $messageSignup = "Signup done!";
    }
 }
 else
 {
    $messageSignup = "Please Confirm your phone or Password!";
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
        
        <nav>
          <ul>
            <li class="current"><a href="Home.php">Home</a></li>
            <li><a href="">About</a></li>
            <li><a href="">Services</a></li>
            <li><a href="">How it works</a></li>
          </ul>
        </nav>
        </div>
    </header>




<section id="LoginSignupbar">
       <div class="container">
         <aside id="Signupbar">
                  <div class="HireNowBack1">
                    <h2> <span class="highlight">Sign up</span> Here!</h2>
                  </div>
                 <div class="HireNowBack2">
                 <form class="contact" method="post" action="LoginSignup.php">
                <div>
                    <label>User Name: </label>
                    <input type="text" name="userName" placeholder="Type here.." required id="userName" value="<?php echo $userName; ?>">
                </div>
                <div>
                    <label>Password: </label>
                    <input type="password" name="password" placeholder="Type here.." required id="password" value="<?php echo $password; ?>">
                </div>
                <div>
                    <label>Confirm Password: </label>
                    <input type="password" name="confirmPassword" placeholder="Type here.." required id="confirmPassword" value="<?php echo $confirmPassword; ?>">
                </div>
                <div>
                    <label>First Name: </label>
                    <input type="text" name="firstName" placeholder="Type here.." required id="firstName" value="<?php echo $firstName; ?>">
                </div>
                <div>
                    <label>Last Name: </label>
                    <input type="text" name="lastName" placeholder="Type here.." required id="lastName" value="<?php echo $lastName; ?>">
                </div>              
                <div>
                    <label>Phone number: </label>
                    <input type="Phone" name="phone" placeholder="Type here.." required id="phone" value="<?php echo $phone; ?>">
                </div>
                <div>
                    <label>Confirm Phone number: </label>
                    <input type="Phone" name="confirmPhone" placeholder="Type here.." required id="confirmPhone" value="<?php echo $confirmPhone; ?>">
                </div>
                <div>
                    <label>Email: </label>
                    <input type="Email" name="email" placeholder="Type here.." required id="email" value="<?php echo $email; ?>">
                </div>
                <div>
                    <label>Date Of Birth: </label>
                    <input type="Date" name="DOB" placeholder="Type here.." required id="DOB" value="<?php echo $DOB; ?>">
                </div>
                <div>
                    <label>National ID card: </label>
                    <input type="number" name="NID" placeholder="Type here.." required id="NID" value="<?php echo $NID; ?>">
                </div>
                <div class="Add">
                    <label>Address: </label>
                    <input type="text" name="address" placeholder="Type here.."align=" " required id="address" value="<?php echo $address; ?>">
                </div>
                <div>
                    <button type="submit" class="Signup" name="signupButton">Sign Up</button><br>
                    <span style="color:red"><?php echo $messageSignup; ?></span>
                </div>
              </form>
              </div>
         </aside>


<aside id="Loginbar">
  <div class="HireNowBack1">
    <h2> <span class="highlight">Login</span> Here!</h2>
  </div>
  <div class="HireNowBack2">
    <form class="contact" action="LoginSignup.php" method="post">
      <div>
                    <input type="text" name="userName" placeholder="User name or Phone" required>
                </div>                
                <div>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                </div>
                    <button type="submit" class="Login" name="loginButton">Log In</button>
                    <span style="color:red"><?php echo $message; ?></span>
                </div>
     </form>
    </div>
   </aside>
 </div>
</section>




    <section id="tranjection">
        <div class="container">
            <div class="tran">
                <h1>00</h1>
                <h4>Tranjection</h4>
            </div>
            <div class="tran">
                <h1>00</h1>
                <h4>Workers</h4>
            </div>
            <div class="tran">
                <h1>00</h1>
                <h4>Successfully served</h4>
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