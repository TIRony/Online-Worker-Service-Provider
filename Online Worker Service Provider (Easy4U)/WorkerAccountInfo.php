<?php
include "includes/db_connect.inc.php";

session_start();
$username = $_SESSION['userName'];
$userName = $message = $rowCount = $result = $err = "";
$firstName = $dept = $lastName = $email = $phone = $DOB = $NID = $address = "";

$sqlUserCheck = "SELECT firstName, lastName, userName, email, phone, NID, address, DOB FROM worker WHERE userName = '$username'";
  $result=mysqli_query($conn, $sqlUserCheck);
  $row=mysqli_num_rows($result);
  while($row=mysqli_fetch_assoc($result))
 {
  $userName = $row['userName'];
  $firstName = $row['firstName'];
  $lastName = $row['lastName'];
  $email = $row['email'];
  $phone = $row['phone'];
  $DOB = $row['DOB'];
  $NID = $row['NID'];
  $address = $row['address'];
}
//$sqldeptCheck = "SELECT firstName, lastName, userName, email, phone, NID, address, DOB FROM worker WHERE userName = '$username'";
$sqldeptCheck = "SELECT name FROM dept RIGHT JOIN worker ON worker.DID = dept.DID";
  $deptResult=mysqli_query($conn, $sqldeptCheck);
  //$deptRow=mysqli_num_rows($deptResult);
  while($deptRow = mysqli_fetch_assoc($deptResult))
 {
  $dept = $deptRow['name'];
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
  if(isset($_POST['signout'])){
       $_SESSION['userName'] = "";
       header("Refresh:0; url=Home.php");
    }
  if(isset($_POST['updateButton'])){    
    if(!empty($_POST['userName'])){
        $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    }
    if(!empty($_POST['firstName'])){
        $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    }
    if(!empty($_POST['lastName'])){
        $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    }
    if(!empty($_POST['phone'])){
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
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
    $sql = "UPDATE customer SET firstName='$firstName', lastName='$lastName', userName='$userName', email='$email', phone='$phone', NID='$NID', address='$address', DOB='$DOB' WHERE userName = '$username'";

    $sql2 = "UPDATE login SET userName='$userName', phone='$phone' WHERE userName = '$username'";
              mysqli_query($conn, $sql);
              mysqli_query($conn, $sql2);
              $message = "Update done!";
} 
if(isset($_POST["insert"]))  
 {  
      $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));  
      $sqlUserCheckPhoto="SELECT * FROM pictures where userName = '$username'";
     $resultUserPhoto=mysqli_query($conn, $sqlUserCheckPhoto);
     $rowUserPhoto=mysqli_num_rows($resultUserPhoto);
     if($rowUserPhoto < 1){
     $queryUpload = "INSERT into pictures (name, userName) values ('$file', '$username')";  
      mysqli_query($conn, $queryUpload);   
     }
     else{
      $queryUpdate = "UPDATE pictures set name =('$file') where userName= '$username'";  
      mysqli_query($conn, $queryUpdate);
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
      <form method="post" action="">
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
        <form class="CustomerSidebar">
        <nav>
          <ul>
            <div class="HireNowBorder">
            <li><a href="worker.php">My Account</a></li><br><br>
          </div>
            <li class="current"><a href="WorkerAccountInfo.php">My Account Information</a></li><br><br><br>
            <li><a href="PreviousRecordWorker.php">Prevoius Record</a></li><br><br>
            <br><li><a href="WorkerSetting.php">Settings</a></li><br><br>
          </ul>
        </nav>
      </form>
       </div>
     </section>

<section id="LoginSignupbar">
       <div class="container">
         <aside id="Signupbar">
                  <div class="HireNowBack1">
                    <h2> <span class="highlight">Information</span></h2>
                  </div>
                  <div>
                    <h2>Department: <span class="highlight"><?php echo $dept ?></span><h2>
                  </div>
                 <div class="HireNowBack2">
                 <form class="contact" method="post" action="customerAccountInfo.php">
                <div>
                    <label>User Name: </label>
                    <input type="text" name="userName" value="<?php echo $userName;?>" required>
                </div>
                <div>
                    <label>Phone number: </label>
                    <input type="Phone" name="phone" value="<?php echo $phone;?>" required>
                </div>
                <div>
                    <label>First Name: </label>
                    <input type="text" name="firstName" value="<?php echo $firstName;?>" required>
                </div>
                <div>
                    <label>Last Name: </label>
                    <input type="text" name="lastName" value="<?php echo $lastName;?>" required>
                </div>              
                <div>
                    <label>Email: </label>
                    <input type="Email" name="email" value="<?php echo $email;?>" required>
                </div>
                <div>
                    <label>Date Of Birth: </label>
                    <input type="Date" name="DOB" value="<?php echo $DOB;?>" required>
                </div>
                <div>
                    <label>National ID card: </label>
                    <input type="number" name="NID" readonly="" value="<?php echo $NID;?>" required>
                </div>
                <div class="Add">
                    <label>Address: </label>
                    <input type="text" name="address" value="<?php echo $address;?>" required>
                </div>
                <div>
                    <button type="submit" class="Signup" name="updateButton">Update</button>
                    <label style="color:red"><?php echo $err; ?></label>
                    <label style="color:red"><?php echo $message; ?></label>
                </div>
              </form>
              </div>
            </aside>

            <aside id="Loginbar2">
<h1 style="color: green" align="upperLeft">Profile Picture</h1>   

  <div class="HireNowBack3">
</div>

 
     
 <html>  
      <head>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  

      </head>  
      <body>  
           
           <div class="container" style="width:700px;">           

                <form method="post" enctype="multipart/form-data">
                  <br>

                <div id="pictureSize">

                <?php     
                $queryLoad = "SELECT * FROM pictures where userName='$username'";    
                $resultLoadPhoto=mysqli_query($conn, $queryLoad);
                $rowUserPhotoLoad=mysqli_num_rows($resultLoadPhoto);
                if($rowUserPhotoLoad >= 1){
                while($rowLoad = mysqli_fetch_array($resultLoadPhoto))  
                {  
                     echo '<img src="data:image/jpeg;base64,'.base64_encode($rowLoad['name'] ).'" height="50%" width="50%" class="img-thumnail" />';  
                }
                }  
                ?> 

      </div> 

                <div> <input type="file" name="image" id="image" style="color: red" /></div>  
                       
                <div > <input type="submit" name="insert" id="insert" style="color: white;background-color: green;" value="Update" class="btn btn-info " /> </div>  
              
                </form>  
   
                
           </div>  
           <script>  
                 $(document).ready(function(){  
                $('#insert').click(function(){  
                var image_name = $('#image').val();  
                if(image_name == '')  
                  {  
                    alert("Please Select Image");  
                    return false;  
                  }  
             else  
                 {  
                  var extension = $('#image').val().split('.').pop().toLowerCase();  
                  if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                    {  
                     alert('Invalid Image File');  
                     $('#image').val('');  
                     return false;  
                    }  
           }  
      });  
 });  
 </script>  
 <style >
   
aside#Loginbar2{
  align-items: right;
  float:right;
  padding-right: 100px ;
  width:25%;
  margin-top:260px;
  margin-bottom:20px;
  margin-left: 0px;
  background:;

}


img {
border-radius: 100%;

}
aside#loginbar2 .pictureSize{
  width: 10px;
  height: 10px;
  position: fixed;
}
 </style>
      </body>  
 </html>  

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