<?php
include "includes/db_connect.inc.php";

session_start();
$username = $_SESSION['userName'];


  if(isset($_POST['passwordChangeButton'])){ 
    if (count($_POST) > 0) {
    $result = mysqli_query($conn, "SELECT *from login WHERE userName='" . $_SESSION["userName"] . "'");
    $row = mysqli_fetch_array($result);
    if ($_POST["currentPassword"] == $row["password"]) {
        mysqli_query($conn, "UPDATE login set password='" . $_POST["newPassword"] . "' WHERE userName='" . $_SESSION["userName"] . "'");
       $message = "Password change";
    } else
        $message = "Current Password is not correct";
}
}
 if(isset($_POST['phoneChangeButton'])){    
if (count($_POST) > 0) {
    $result = mysqli_query($conn, "SELECT *from login WHERE userName='" . $_SESSION["userName"] . "'");
    $row = mysqli_fetch_array($result);
    if ($_POST["currentPhone"] == $row["phone"]) {
        mysqli_query($conn, "UPDATE login set phone='" . $_POST["newPhone"] . "' WHERE userName='" . $_SESSION["userName"] . "'");
        mysqli_query($conn, "UPDATE worker set phone='" . $_POST["newPhone"] . "' WHERE userName='" . $_SESSION["userName"] . "'");
        $message2 = "Phone number Changed";
    } else
        $message2 = "Current Phone number is not correct";
}

}


if(isset($_POST['emailChangeButton'])){    
if (count($_POST) > 0) {
    $result = mysqli_query($conn, "SELECT * from worker WHERE userName='" . $_SESSION["userName"] . "'");
    $row = mysqli_fetch_array($result);
    if ($_POST["currentEmail"] == $row["email"]) {
       
        mysqli_query($conn, "UPDATE worker set email='" . $_POST["newEmail"] . "' WHERE userName='" . $_SESSION["userName"] . "'");
        $message3 = "Email number Changed";
    } else
        $message3 = "Current Email is not correct";
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
        <nav>
          <ul>
            <li><a href="Home.php">Log Out</a></li>
          </ul>
        </nav>
        </div>
        <nav>
          <ul>
            <li class="current"><a href="">Home</a></li>
            <li><a href="">About</a></li>
            <li><a href="">Services</a></li>
            <li><a href="">How it works</a></li>
          </ul>
        </nav>
    </div>
  </header>


   <section id="CustomerSidebar">
      <div class="container">
        <form class="EmployeeSidebar">
        <nav>
          <ul>
            <div class="HireNowBorder">
            <li ><a href="Employee.php">My Account</a></li><br><br>
          </div>
            <li><a href="EmployeeAccountInfo.php">My Account Information</a></li><br><br><br>
            <li><a href="">Prevoius Record</a></li><br><br>
            <li><a href="">Workers</a></li><br><br>
            <li><a href="loadCustomer">Customers</a></li><br><br>
            <li><a href="">Tranjection</a></li><br><br>
            <li class="current"><a href="EmployeeSetting.php">Settings</a></li><br><br>
          </ul>
        </nav>
      </form>
       </div>
     </section>







     <style>


/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  width: 100%;

}

/* Style the buttons inside the tab */
.tab button {
  background-color: green;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 10px 20px;
  transition: 1s;
  font-size: 15.65px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: gray;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>

 
  


<section id="LoginSignupbar">

       <div class="container">
         <aside id="Signupbar">
                  <div class="HireNowBack1">
                    <h2> <span class="highlight"></span> Change Your Securing Information</h2>
                    <div class="message" id="loadMessage"><?php if(isset($message)) { echo $message; } ?></div>
                    <div class="message" id="loadMessage2"><?php if(isset($message2)) { echo $message2; } ?></div>
                     <div class="message" id="loadMessage3"><?php if(isset($message3)) { echo $message3; } ?></div>


                  </div>
                 <div class="HireNowBack2">


 

                  <div class="tab">

                           <button class="tablinks" onclick="openCity(event, 'passwordChange')" >Password Change</button>
                           <button class="tablinks" onclick="openCity(event, 'phoneChange')">Phone number change</button>
                           <button class="tablinks" onclick="openCity(event, 'Tokyo')">email change</button>
                 </div>
             
              

 <form class="contact" name="passwordChange" method="post" action="" onSubmit="return validatePassword()">

<div id="passwordChange" class="tabcontent">

             <div>
                    <label>Current Password</label><br>
                    <input type="password" name="currentPassword" required="" />
                    <span id="currentPassword" class="required"></span><br>
          </div>
          
          <div>
                    <label>New Password:</label><br>
                    <input type="password" name="newPassword" required="" />
                    <span id="newPassword"class="required"></span><br>
          </div>
                
           <div>
                    <label>Confirm Password: </label><br>
                    <input type="password" name="confirmPassword"  required="">
                    <span id="confirmPassword" class="required"></span><br><br>
           </div>
                  <div>
                    <button input type="submit" name="passwordChangeButton"value="Submit" class="Signup" id="passwordChange" >Update</button>
                       
                   


                </div>
</div>

</form>





 <form class="contact" name="phoneChange" method="post" action="" onSubmit="return validatePhone()">

<div id="phoneChange" class="tabcontent">

             <div>
                    <label>Current Phone Number</label><br>
                    <input type="phone" name="currentPhone"  />
                    <span id="currentPhone" class="required"></span><br>
          </div>
          
          <div>
                    <label>New Phone Number:</label><br>
                    <input type="phone" name="newPhone"  />
                    <span id="newPhone"class="required"></span><br>
          </div>
                
           <div>
                    <label>Confirm Phone Number: </label><br>
                    <input type="phone" name="confirmPhone" required="">
                    <span id="confirmPhone" class="required"></span><br><br>
           </div>
                  <div>
                    <button input type="submit" name="phoneChangeButton"value="Submit" class="Signup">Update</button>
                   
                </div>

</div>


</form>




 <form class="contact" name="frmChange" method="post" action="" onSubmit="return validateEmail()">

<div id="Tokyo" class="tabcontent">

             <div>
                    <label>Current Email :</label><br>
                    <input type="email" name="currentEmail"  />
                    <span id="currentEmail" class="required"></span><br>
          </div>
          
          <div>
                    <label>New Email :</label><br>
                    <input type="email" name="newEmail"  />
                    <span id="newEmail"class="required"></span><br>
          </div>
                
           <div>
                    <label>Confirm Email: </label><br>
                    <input type="email" name="confirmEmail" required="">
                    <span id="confirmEmail" class="required"></span><br><br>
           </div>
                  <div>
                    <button input type="submit" name="emailChangeButton"value="Submit" class="Signup">Update</button>
                   
                      
                </div>

</div>


</form>










</form>
</div>
</aside>
</div>
</section>


<script>

function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";

document.getElementById("loadMessage").style.display = "none";
document.getElementById("loadMessage2").style.display="none";
document.getElementById("loadMessage3").style.display="none";

}





function validatePassword() {
var currentPassword,newPassword,confirmPassword,output = true;

currentPassword = document.passwordChange.currentPassword;
newPassword = document.passwordChange.newPassword;
confirmPassword = document.passwordChange.confirmPassword;

if(!currentPassword.value) {
  currentPassword.focus();
  document.getElementById("currentPassword").innerHTML ="required";
  output = false;
}
else if(!newPassword.value) {
  newPassword.focus();
  document.getElementById("newPassword").innerHTML = "required";
  output = false;
}
else if(!confirmPassword.value) {
  confirmPassword.focus();
  document.getElementById("confirmPassword").innerHTML = "required";
  output = false;
}
if(newPassword.value != confirmPassword.value) {
  newPassword.value="";
  confirmPassword.value="";
  newPassword.focus();
  document.getElementById("confirmPassword").innerHTML = "not same";
  output = false;
}   
return output;
}





function validatePhone() {
var currentPhone,newPhone,confirmPhone,output = true;

currentPhone = document.phoneChange.currentPhone;
newPhone = document.phoneChange.newPhone;
confirmPhone = document.phoneChange.confirmPhone;

if(!currentPhone.value) {
  currentPhone.focus();
  document.getElementById("currentPhone").innerHTML = "required";
  output = false;
}
else if(!newPhone.value) {
  newPhone.focus();
  document.getElementById("newPhone").innerHTML = "required";
  output = false;
}
else if(!confirmPhone.value) {
  confirmPhone.focus();
  document.getElementById("confirmPhone").innerHTML = "required";
  output = false;
}
if(newPhone.value != confirmPhone.value) {
  newPhone.value="";
  confirmPhone.value="";
  newPhone.focus();
  document.getElementById("confirmPhone").innerHTML = "not same";
  output = false;
}   
return output;
}



function validateEmail() {
var currentEmail,newEmail,confirmEmail,output = true;

currentEmail = document.frmChange.currentEmail;
newEmail = document.frmChange.newEmail;
confirmEmail = document.frmChange.confirmEmail;

if(!currentEmail.value) {
  currentEmail.focus();
  document.getElementById("currentEmail").innerHTML = "required";
  output = false;
}
else if(!newEmail.value) {
  newEmail.focus();
  document.getElementById("newEmail").innerHTML = "required";
  output = false;
}
else if(!confirmEmail.value) {
  confirmEmail.focus();
  document.getElementById("confirmEmail").innerHTML = "required";
  output = false;
}
if(newEmail.value != confirmEmail.value) {
  newEmail.value="";
  confirmEmail.value="";
  newEmail.focus();
  document.getElementById("confirmEmail").innerHTML = "not same";
  output = false;
}   
return output;
}


</script>

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
  </from>  
</body>
</html>



