<?php
include "includes/db_connect.inc.php";

session_start();
$empty = $message = $area = $dept = "";
$firstName = $lastName = $email = $phone = $address = $selectedArea = "";
$areaa = "lol";
$username = $_SESSION['userName'];
$firstName = $_SESSION['customerFirstName'];
$lastName = $_SESSION['customerLastName'];
$phone = $_SESSION['customerPhone'];
$email = $_SESSION['customerEmail'];
$address = $_SESSION['customerAddress'];
$CID = $_SESSION['CID'];
if($_SERVER["REQUEST_METHOD"] == "POST")
 {
   if(isset($_POST['signout'])){
       $_SESSION['userName'] = $empty;
       header("Refresh:0; url=Home.php");
    }
  }
$sqlAreaCheck = "SELECT * FROM area";
    $resultArea = mysqli_query($conn, $sqlAreaCheck);
    $rowCountArea = mysqli_num_rows($resultArea);
    if($rowCountArea < 1){
        $message = "Currently no AREA available now!";
      }
      $sqlDeptCheck = "SELECT * FROM dept";
    $resultDept = mysqli_query($conn, $sqlDeptCheck);
    $rowCountDept = mysqli_num_rows($resultDept);
    if($rowCountDept < 1){
        $message = "Currently no Department available now!";
      }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Easy4U</title>
  <link rel="stylesheet" href="./css/Home.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
  $(document).ready(function(){
    $("#secondStage").hide();
    $("#confirmationStage").hide();

    $('#address').on('blur',function(){
    if(!$('#address').val())
    {
      $("#addressMessage").show(); 
    }
    else{
     $("#addressMessage").hide();  
    }
    });
    $('#selectedArea').on('blur',function(){
    if(!$('#selectedArea').val())
    {
      $("#selectedAreaMessage").show(); 
    }
    else{
     $("#selectedAreaMessage").hide();  
    }
    });
    $('#selectedDept').on('blur',function(){
    if(!$('#selectedDept').val())
    {
      $("#selectedDeptMessage").show(); 
    }
    else{
     $("#selectedDeptMessage").hide();  
    }
    });
    $("#firstStageNextButton").click(function(){
      if(!$('#selectedArea').val() && !$('#selectedDept').val() && !$('#noOfWorker').val())
    {
      $("#firstStage").show();
      $("#selectedAreaMessage").show();
      $("#selectedDeptMessage").show();
    }
    else if(!$('#selectedArea').val())
    {
      $("#firstStage").show();
      $("#selectedAreaMessage").show(); 
    }
    else if(!$('#selectedDept').val())
    {
      $("#firstStage").show();
      $("#selectedDeptMessage").show(); 
    }
    if($('#selectedArea').val())
    {
      $("#firstStage").show();
      $("#selectedAreaMessage").hide(); 
    }
    if($('#selectedDept').val())
    {
      $("#firstStage").show();
      $("#selectedDeptMessage").hide(); 
    }
    if($('#selectedArea').val() && $('#selectedDept').val()){
      /*var selectedNoOFWorker = $('#noOfWorker').val();*/
      $("#firstStage, #secondStage").toggle();
    }
   });
    $("#secondStageNextButton").click(function(){
    if(!$('#address').val())
    {
      $("#secondStage").show();
      $("#addressMessage").show(); 
    }
    else if($('#selectedArea').val()){
      $("#addressMessage").hide();
      $("#secondStage, #confirmationStage").toggle();
    }
    });

      $("#backButton").click(function(){
      $("#secondStage, #firstStage").toggle();
   });
      $('#noOfWorker').on('blur',function(){
    if(!$('#noOfWorker').val())
    {
      $("#noOfWorkerMessage").show(); 
    }
    else{
     $("#noOfWorkerMessage").hide();  
    }
    });
      $("#confirmationStageButton").click(function(){
     if(!$('#noOfWorker').val())
      {
      $("#noOfWorkerMessage").show(); 
      }
      else{
        $("#noOfWorkerMessage").hide();
        /*$("#confirmationStage").hide();*/
        /*$("#firstStage").show();*/
      var selectedArea = $('#selectedArea').val();
      var selectedDept = $('#selectedDept').val();
      var noOfWorker = $('#noOfWorker').val();
      var address = $('#address').val();
      $('#noOfWorkerErrorMessageDiv').load('dataPassToPHP.php',{selectedAreaInNext: selectedArea, selectedDeptInNext: selectedDept, noOfWorkerInNext: noOfWorker, addressInNext: address});
  }
   });
      $("#confirmationStageBackButton").click(function(){
      $("#confirmationStage, #secondStage").toggle();
   });
      $("#selectedAreaMessage").hide();
      $("#selectedDeptMessage").hide();
      $("#noOfWorkerMessage").hide();
      $("#addressMessage").hide();
      $("#noOfWorkerErrorMessage").hide();

   });
</script>
</head>
<form method="post" action="Customer.php">
<body>
  <header>
    <div class="container" id="load">
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
            <li><a href="Home.php">Home</a></li>
            <li><a href="">About</a></li>
            <li><a href="">Services</a></li>
            <li><a href="">How it works</a></li>
          </ul>
        </nav>
    </div>
  </header>


    <section id="CustomerSidebar">
      <div class="container">
        <form class="CustomerSidebar">
        <nav>
          <ul>
            <div class="HireNowBorder">
            <li class="current"><a href="Customer.php">Hire Now</a></li><br><br>
          </div>
            <li><a href="CustomerAccountInfo.php">My Account Information</a></li><br><br><br>
            <li><a href="PreviousRecordCustomer.php">Prevoius Record</a></li><br><br>
            <li><a href="CustomerSetting.php">Settings</a></li><br><br>
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

              <h3>Hire our services and get befinited.</h3>
           <article id="main-col">
          <h1 class="highlight">Services</h1>
          <ul id="services">
            <li>
              <h3><span class="highlight">Plumbing</span></h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mi augue, viverra sit amet ultricies at, vulputate id lorem. Nulla facilisi.</p>

            </li>
            <li>
              <h3><span class="highlight">Electrical</span></h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mi augue, viverra sit amet ultricies at, vulputate id lorem. Nulla facilisi.</p>

            </li>
            <li>
              <h3><span class="highlight">Guard</span></h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mi augue, viverra sit amet ultricies at, vulputate id lorem. Nulla facilisi.</p>

            </li>
            <li>
              <h3><span class="highlight">Labor</span></h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mi augue, viverra sit amet ultricies at, vulputate id lorem. Nulla facilisi.</p>

            </li>
          </ul>
        </article>
         </form>


<aside id="CustomerHireNow">
    <div class="HireNowBack1">
    <h3> <span class="highlight">Hire</span> Here!</h3>
  </div>
  <div class="HireNowBack2" id="firstStage">
      <div class="HireNowBack1">
    <h3>Select Your <span class="highlight">Area and Services!</span></h3>
  </div>
    <form class="contact">
      <div>
      <label>AREA</label>
      <select name="selectedArea" id="selectedArea">
        <option value="">Select Area</option>
                <?php
                  while($rowArea=mysqli_fetch_assoc($resultArea))
                    {
                ?>
                <option value="<?php echo $rowArea['AreaName']; ?>" required><?php echo $rowArea['AreaName']; ?></option>
              <?php
                } 
              ?>
      </select><br><br>
      <span id="selectedAreaMessage" style="color:red">Please select an Area to continue!</span>
    </div>

    <div>
      <label>SERVICE</label>
      <select name="selectedDept" id="selectedDept">
        <option value="">Select Service</option>
        <?php
                  while($rowDept=mysqli_fetch_assoc($resultDept))
                    {
                ?>
                <option value="<?php echo $rowDept['name']; ?>" required><?php echo $rowDept['name']; ?></option>
              <?php
                } 
              ?>
      </select><br><br>
      <span id="selectedDeptMessage" style="color:red">Please select a Service to continue!</span>
    </div>
    <button type="button" class="HireNow" id="firstStageNextButton" name="firstStageNextButton">Next</button>
    </form>
  </div>


<div class="HireNowBack2" id="secondStage">
  <div class="HireNowBack1">
    <h3> <span class="highlight">Confirm Your </span>Details!</h3>
  </div>
    <form class="contact">
    <div class="HireNowBack1" style="border-bottom: #29a329 1px solid;">
      <label> NAME: <span class="highlight"><?php echo $firstName; ?> <?php echo $lastName; ?></span></label>
    </div>
    <div class="HireNowBack1" style="border-bottom: #29a329 1px solid;">
      <br><label> PHONE: <span class="highlight"><?php echo $phone; ?></span></label>
    </div>
    <div class="HireNowBack1" style="border-bottom: #29a329 1px solid;">
      <br><label> EMAIL: <span class="highlight"><?php echo $email; ?></span></label>
    </div>
    <div>
      <br><label>ADDRESS </label>
      <input type="text" name="address" required id="address" value="<?php echo $address; ?>">
    </div>
     <span id="addressMessage" style="color:red">Type your ADDRESS!!</span>
       <button type="button" class="HireNow" id="secondStageNextButton" name="secondStageNextButton">Next</button>
     <button type="button" class="HireNow" id="backButton" name="backButton">Back</button>
    </form>
  </div>

<div class="HireNowBack2" id="confirmationStage">
  <div class="HireNowBack1">
    <h3>Total <span class="highlight">Cost Confirmation!</span></h3>
  </div>
    <form class="contact">
    <div>
      <label>NUMBER OF WORKER</label>
      <input type="text" name="noOfWorker" id="noOfWorker" required>
    </div>
    <div id="noOfWorkerErrorMessageDiv">
    <span id="noOfWorkerErrorMessage" style="color:red">Number of worker not available!</span>
  </div>
    <div class="HireNowBack1" style="border-bottom: #29a329 1px solid;">
      <br><label> COST PER HOUR: <span class="highlight">i47 </span>tk</label>
    </div>
    <span style="color:red"><?php echo $message; ?></span>
    <span id="noOfWorkerMessage" style="color:red">Please select number of worker!</span>
     <button type="button" class="HireNow" id="confirmationStageButton" name="confirmationStageButton">Confirm</button>
     <button type="button" class="HireNow" id="confirmationStageBackButton" name="confirmationStageBackButton">Back</button>
    </form>
  </div>
  <!-- /////////////////// jQuery /////////////////-->
  <!--<script>
    document.getElementById('firstStage').style.display = 'block';
    document.getElementById('confirmationStage').style.display = 'none';
    document.getElementById('secondStage').style.display = 'none';
    function myFunction() {
      document.getElementById('firstStage').style.display = 'none';
      document.getElementById('secondStage').style.display = 'block';
    }
</script>-->
</aside>

</div>
</section>
</form>
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
  </form>
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