<?php
include "includes/db_connect.inc.php";
session_start();
$empty = $message = $RID = $RIDsplit = $RIDToDelete = $RIDlabel = "";
$confirmTime = $confirmCustomerName = $confirmCustomerPhone = $confirmArea = $confirmDept = $confirmNoOfWorker = $confirmCurrentDate = $confirmAddress = $WuserName = "";
$userName = $_SESSION['userName'];
$totalPage = 0;
$perPage = 3;
$time = "";
$a = 1;

  if(isset($_GET['next'])){
    $a = $_GET['next'];
  }
  else if(isset($_GET['prev'])){
    $a = $_GET['prev'];
  }
  else if(isset($_GET['pg'])){
    $a = $_GET['pg'];
  }
  $startingRow = ($a-1) * $perPage;
  if(isset($_POST['searchButton'])){
    $st = $_POST['search'];
    $sql = "SELECT * FROM worker JOIN dept ON dept.DID = worker.DID JOIN area ON area.AreaID = worker.AreaID
            WHERE userName LIKE '%$st%';";
    $result = mysqli_query($conn, $sql);
}
else{
  /*$sqlUserCheck="SELECT * FROM worker LIMIT $startingRow, $perPage;";*/
  $sqlUserCheck="SELECT * FROM worker JOIN dept ON dept.DID = worker.DID JOIN area ON area.AreaID = worker.AreaID LIMIT $startingRow, $perPage;";
  /*$sqlUserCheck="SELECT * FROM worker JOIN dept ON dept.DID = worker.DID LIMIT $startingRow, $perPage;";*/

/*  SELECT * FROM worker 
JOIN dept ON dept.DID = worker.DID 
JOIN area ON area.AreaID = worker.AreaID
where name="labor" and AreaName = "gulshan"
order by Rating ASC LIMIT 1;*/
  $result=mysqli_query($conn, $sqlUserCheck);
}
  $sqlRowCount="SELECT * FROM worker";
  $resultRowCount=mysqli_query($conn, $sqlRowCount);
  $rowCount=mysqli_num_rows($resultRowCount);
  $totalPage = ceil($rowCount / $perPage);
  $sqlRequest="SELECT * From request JOIN customer ON customer.CID = request.CID";
  $resultRequest=mysqli_query($conn, $sqlRequest);

  $sqlCalculation="SELECT * FROM assignworker 
                        JOIN worker ON worker.WID = assignworker.WID 
                        JOIN request ON request.RID = assignworker.RID";
  $resultRequestCalculation=mysqli_query($conn, $sqlCalculation);


  $resultRequestOnClick=mysqli_query($conn, $sqlRequest);
  $sqlRequestDelete="SELECT * From request";
  $resultRequestDelete=mysqli_query($conn, $sqlRequestDelete);
  $sqlRequestStart="SELECT * From assignworker";
  $resultRequestStart=mysqli_query($conn, $sqlRequestStart);
    $rowCountSetWorker = "";
if($_SERVER["REQUEST_METHOD"] == "POST")
 {
   if(isset($_POST['signout'])){
       $_SESSION['userName'] = $empty;
       header("Refresh:0; url=Home.php");
    }
 while($rowRequestDelete = mysqli_fetch_assoc($resultRequestDelete)){ 
    $RIDToDelete = "Dd".$rowRequestDelete['RID'];
    $RIDToSearch = "Ss".$rowRequestDelete['RID'];
              if(isset($_POST[$RIDToDelete])){
                      $RIDsplit = explode("d", $RIDToDelete);
                      $RIDToDelete = $RIDsplit[1];
                  $sqlD = "DELETE FROM request WHERE RID = '$RIDToDelete'";
                  mysqli_query($conn, $sqlD);
                   header("Refresh:0; url=Admin.php");
              }
              if(isset($_POST[$RIDToSearch])){
                      $RIDsplit = explode("s", $RIDToSearch);
                      $RIDToSearch = $RIDsplit[1];
                      $sqlRequestSearh="SELECT * From request JOIN customer ON customer.CID = request.CID where RID = '$RIDToSearch'";
                      $resultRequestSearch=mysqli_query($conn, $sqlRequestSearh);
                      while($rowRequestSearch = mysqli_fetch_assoc($resultRequestSearch)){
                      $confirmTime = $rowRequestSearch['currentTimeHour'].":".$rowRequestSearch['currentTimeMin'].$rowRequestSearch['current'];
                       $RID = $rowRequestSearch['RID'];
                       $confirmCustomerName = $rowRequestSearch['firstName']." ".$rowRequestSearch['lastName'];
                       $confirmCustomerPhone = $rowRequestSearch['phone'];
                       $confirmArea = $rowRequestSearch['selectedArea'];
                       $confirmDept = $rowRequestSearch['selectedDept'];
                       $confirmNoOfWorker = $rowRequestSearch['noOfWorker'];
                       $confirmCurrentDate = $rowRequestSearch['currentDate'];
                       $confirmAddress = $rowRequestSearch['address'];
                      }
                      $sqlRequestSetWorker="SELECT * FROM worker 
                                            JOIN dept ON dept.DID = worker.DID 
                                            JOIN area ON area.AreaID = worker.AreaID
                                            where name='$confirmDept' and AreaName='$confirmArea' and Active=1
                                            order by Rating DESC LIMIT $confirmNoOfWorker;";
                      $resultRequestSetWorker=mysqli_query($conn, $sqlRequestSetWorker);
                      $resultRequestAssignWorker=mysqli_query($conn, $sqlRequestSetWorker);
                          $rowCountSetWorker = mysqli_num_rows($resultRequestSetWorker);       
                          }
                          }
           while($rowRequestStart = mysqli_fetch_assoc($resultRequestStart)){ 
                   $RIDToStart = "St".$rowRequestStart['RID'];
                   $RIDToEnd = "Ee".$rowRequestStart['RID'];
                   $RIDToDeleteA = "Di".$rowRequestStart['RID'];
                   $WID = $rowRequestStart['WID'];
                if(isset($_POST[$RIDToDeleteA])){

                  $sqlT = "SELECT endTimeHour,endTimeMin FROM assignworker";
                   $resultT = mysqli_query($conn, $sqlT);

                    while($rowT = mysqli_fetch_assoc($resultT)){
                        $TH = $rowT['endTimeHour'];
                        $TM = $rowT['endTimeMin'];
                        if($TH != 0 && $TM != 0)
                        {
                            $RIDsplit = explode("i", $RIDToDeleteA);
                            $RIDToDeleteA = $RIDsplit[1];
                            $sqlD = "DELETE FROM assignworker WHERE RID = '$RIDToDeleteA'";
                            mysqli_query($conn, $sqlD);
                            header("Refresh:0; url=Admin.php");
                        }
                       }
              }
                if(isset($_POST[$RIDToStart])){
                      $RIDStartsplit = explode("t", $RIDToStart);
                      $RIDToStart = $RIDStartsplit[1];
                      date_default_timezone_set("Asia/Dhaka");
                      $startTimeHour = date("g");
                      $startTimeMin = date("i");
                      $start = date("a");
                      $startDate = date("Y-m-d");
                  $sqlAssignWorkerStart = "UPDATE assignworker SET startTimeHour='$startTimeHour', startTimeMin='$startTimeMin', start='$start', workingDate='$startDate' WHERE RID = '$RIDToStart'";
                  mysqli_query($conn, $sqlAssignWorkerStart);
                   header("Refresh:0; url=Admin.php");
                 }
              if(isset($_POST[$RIDToEnd])){
                      $RIDEndsplit = explode("e", $RIDToEnd);
                      $RIDToEnd = $RIDEndsplit[1];
                      date_default_timezone_set("Asia/Dhaka");
                      $endTimeHour = date("g");
                      $endTimeMin = date("i");
                      $end = date("a");
                      $endDate = date("Y-m-d");
                      $sqlAssignWorkerEnd = "UPDATE assignworker SET endTimeHour='$endTimeHour', endTimeMin='$endTimeMin', endTime='$end', endDate='$endDate' WHERE RID = '$RIDToEnd'";
                      mysqli_query($conn, $sqlAssignWorkerEnd);
                      $sqlConfirmAssign = "UPDATE worker SET Active= 1 where WID = '$WID'";
                            mysqli_query($conn, $sqlConfirmAssign);
                            header("Refresh:0; url=Admin.php");
                             $sqlConfirmAssignActive = "UPDATE assignworker SET Assign= 1";
                            mysqli_query($conn, $sqlConfirmAssignActive);
                  }
  }     
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Easy4U</title>
  <link rel="stylesheet" href="./css/home.css">
</head>
<body>
  <header>
    <div class="container">
      <form method="post" action="Admin.php">
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
            <!--<?php // ?>-->
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
            <li class="current"><a href="">My Account</a></li><br><br>
          </div>
            <li><a href="AdminAccountInfo.php">My Account Information</a></li><br><br><br>
            <li><a href="PreviousRecord.php">Prevoius Record</a></li><br><br>
            <li><a href="loadWorker.php">Worker</a></li><br><br>
            <li><a href="loadCustomer.php">Customer</a></li><br><br>
            <li><a href="loadEmployee.php">Employee</a></li><br><br>
            <li><a href="AddDepartment.php">Department</a></li><br><br>
            <li><a href="Area.php">Coverage Area</a></li><br><br>
      
            <li><a href="AdminSetting.php">Settings</a></li><br><br>
          </ul>
        </nav>
      </form>
       </div>
     </section>
<form id="loadCustomer" action="Admin.php" method="post">
  <section id="Customerload">
    <div class="container">
        <aside id="load">
             <h2><span class="highlight">Hello</span>,<?php echo $userName ?><h2>
              <button type="submit" id="refreshTable" class="Refresh" name="refreshTable"> Refresh </button>
              <input type="text" id="search" placeholder="Search for WORKER.." name="search">
              <button type="submit" id="searchButton" class="search" name="searchButton"> Search </button>
              <div class="scrollOFTable">
              <table id="show" class="tableLayout" style="width: 100%">
                <thead>
                <th><h2>User Name</h2></th>
                <th><h2>First Name</h2></th>
                <th><h2>Last Name</h2></th>
                <th><h2>Phone</h2></th>
                <th><h2>Department</h2></th>
                <th><h2>Area</h2></th>
                <th><h2>Rating</h2></th>
                <th style="border-right: 2px solid black;"><h2>Active</h2></th>
              </thead>
              <tr><br></tr>
                <?php
                  while($row=mysqli_fetch_assoc($result))
                    {
                      /*$assignWorkerUserName = $row['userName'];
                      $assignWorkerButtonId = "Button".$assignWorkerUserName;*/
                      ?>
              <tr>
                <td><?php echo $row['userName']; ?></td>
                <td><?php echo $row['firstName']; ?></td>
                <td><?php echo $row['lastName']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['AreaName']; ?></td>
                <td><?php echo $row['Rating']; ?></td>
                <td><?php echo $row['Active']; ?></td>
                <!-- <td style="border: 2px solid #f4f4f4;"><button style="border: 1px solid black;" type="submit" id="<?php $assignWorkerButtonId; ?>" class="search" name="assignWorkerButton"><?php $assignWorkerButtonId; ?></button></td> -->
              </tr>
              <?php } ?>
              </table>
            </div>
              <span style="color:red"><?php echo $message; ?></span>
              <style>
                table thead{
                  background-color: #29a329;
                  border: 3px solid black;
                 }
                table tr:not(:first-child):hover{background-color: #666; color: #ffffff}
              </style>
              <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
              <script>
                $(document).ready(function(){
                      });
                function DivFunction(RID, customerName, customerPhone, Area, Dept, noOfWorker, time, currentDate, address){
                  var RID = RID;
                  var customerName = customerName;
                  var customerPhone = customerPhone;
                  var Area = Area;
                  var Dept=Dept;
                  var noOfWorker=noOfWorker;
                  var time=time;
                  var currentDate=currentDate;
                  var address=address;
                  
                  <?php while($rowRequestOnclick=mysqli_fetch_assoc($resultRequestOnClick))
                   {
                   $RID = $rowRequestOnclick['RID']; 
                    ?>
                    if(RID == <?php echo $RID; ?>)
                    {
                      document.getElementById("confirmCustomerName").value = customerName;
                      document.getElementById("confirmCustomerPhone").value = customerPhone;
                      document.getElementById("confirmArea").value = Area;
                      document.getElementById("confirmDept").value = Dept;
                      document.getElementById("confirmnoOfWorker").value = noOfWorker;
                      document.getElementById("confirmTime").value = time;
                      document.getElementById("confirmDate").value = currentDate;
                      document.getElementById("confirmAddress").value = address;
                    }
                    <?php } ?>

                }
                    </script>
                <script>
              var table = document.getElementById("show");
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         rIndex = this.rowIndex;
                         console.log(rIndex);
                    };
                  }        
           </script>
       <div id="buttonpg">
       <a href="Admin.php?prev=<?php echo $a-1; ?>" class="buttonpg">Previous</a>
       <?php
      for($i=1; $i<=$totalPage; $i++){ ?>
       <a href="Admin.php?pg=<?php echo $i; ?>" class="buttonpg"><?php echo $i; ?></a>
       <?php } ?>
       <a href="Admin.php?next=<?php echo $a+1; ?>" class="buttonpg">Next</a>
     </div>
     <div id="confirmRequest">
       <aside class="leftConfirm">
        <div class="loadRequestDown">
            
            <label>Customer Name:<span class="highlight"><?php echo $confirmCustomerName ?></span></label><br>
            <label>Customer Phone: <span class="highlight"><?php echo $confirmCustomerPhone; ?></span></label><br>
            <label>Area: <span class="highlight"><?php echo $confirmArea; ?></span></label><br>
            <label>Department: <span class="highlight"><?php echo $confirmDept ; ?></span></label><br>
            <label>No of worker: <span class="highlight"><?php echo $confirmNoOfWorker; ?></span></label><br>  <label>Time: <span class="highlight"><?php echo $confirmTime; ?></span></label><br>
            <label>Date: <span class="highlight"><?php echo $confirmCurrentDate ?></span></label><br>
            <label>Address: <span class="highlight"><?php echo $confirmAddress; ?></span></label><br>
            </div>
       </aside>
       <aside class="rightConfirm">
         <ul>
          <?php
          if($rowCountSetWorker == ""){
            $WuserName = "";
          }
          else{
          while($rowRequestSetWorker = mysqli_fetch_assoc($resultRequestSetWorker)){
                  $WuserName = $rowRequestSetWorker['userName'];
                  $WID = $rowRequestSetWorker['WID'];
                  $Wname = $rowRequestSetWorker['firstName']." ".$rowRequestSetWorker['lastName'];
                  $sqlAssignWorker = "INSERT INTO assignworker (WID, RID) VALUES ('$WID', '$RID');";
                  mysqli_query($conn, $sqlAssignWorker);
                  $sqlAssignWorker = "INSERT INTO history (WID, workerName) VALUES ('$WID', '$Wname');";
                  mysqli_query($conn, $sqlAssignWorker);
                  $sqlConfirmAssign = "UPDATE worker SET Active= 0 where WID = '$WID'";
                            mysqli_query($conn, $sqlConfirmAssign);
                  ?>
                  <li><?php echo $WuserName; ?><span class="close">&times;</span></li>
          <?php }}?>
         </ul>
         <script>
           var closebtns = document.getElementsByClassName("close");
           var i;
           for (i = 0; i < closebtns.length; i++) {
           closebtns[i].addEventListener("click", function() {
           this.parentElement.style.display = 'none';
          });
         }
       </script>
       </aside>
       <button type="submit" id="assignWorkerButton" class="search" name="assignWorkerButton" style="margin-left: 380px;"> Ok Got it!</button>
     </div>


     <div id="confirmRequest">
      <div class="loadAssignWorkerTop">
          <label>Amount Calculation</label>
        </div>
        <div class="scrollOFAssignWorker">
          <?php while($rowRequestCalculation=mysqli_fetch_assoc($resultRequestCalculation))
          {
            $RID = $rowRequestCalculation['RID'];

            $WID = $rowRequestCalculation['WID'];
            $CID = $rowRequestCalculation['CID'];
            $sqlAssignCustomer = "SELECT * FROM customer WHERE CID = '$CID'";
            $resultAssignCustomer = mysqli_query($conn, $sqlAssignCustomer);
            while($rowAssignCustmer = mysqli_fetch_assoc($resultAssignCustomer)){
                $customerName = $rowAssignCustmer['firstName']." ".$rowAssignCustmer['lastName'];
                $customerPhone = $rowAssignCustmer['phone'];
            }
            $workerName = $rowRequestCalculation['firstName']." ".$rowRequestCalculation['lastName'];
            $workerPhone = $rowRequestCalculation['phone'];
            $Area = $rowRequestCalculation['selectedArea'];
            $Dept = $rowRequestCalculation['selectedDept'];
            $noOfWorker = $rowRequestCalculation['noOfWorker'];
            $address = $rowRequestCalculation['address'];
            $startTH = $rowRequestCalculation['startTimeHour'];
            $startTM  = $rowRequestCalculation['startTimeMin'];
            $startT = $rowRequestCalculation['start'];
            $startTime = $startTH.":".$startTM.$startT;
            $startTimeD = $startTH.":".$startTM.":"."00";
            $startDateFromDB = $rowRequestCalculation['workingDate'];

            $endTH = $rowRequestCalculation['endTimeHour'];
            $endTM = $rowRequestCalculation['endTimeMin'];
            $endT = $rowRequestCalculation['endTime'];
            $endTime = $endTH.":".$endTM.$endT;
            $endTimeD = $endTH.":".$endTM.":"."00";
            $endDateFromDB = $rowRequestCalculation['endDate'];
            $startID = "St".$RID;
            $endID = "Ee".$RID;
            $deleteID = "Di".$RID;
            $sqlgetRate = "SELECT * FROM dept WHERE name = '$Dept'";
            $resultRate = mysqli_query($conn, $sqlgetRate);
            while($rowgetRate = mysqli_fetch_assoc($resultRate)){
              $rate = $rowgetRate['Rate'];
              if($startTH == 0 && $startTM == 0){
                $timeDiff = 0;
                $totalCost = 0;
              }
              else if($endTH == 0 && $endTM == 0){
                $timeDiff = 0;
                $totalCost = 0;
              }
                else{
              $to_time = strtotime($startTimeD);
              $from_time = strtotime($endTimeD);
              $timeDiff =  round(abs($to_time - $from_time) / 60,2);
              /*echo $timeDiff;*/
              $ratePerMin = round($rate / 60,2);
              $totalCost = round($ratePerMin * $timeDiff,2);
              if($totalCost <= 100)
              {
                $totalCost = 100.00;
              }
            }
            }
            $sqlUpateToHistory = "UPDATE history SET CID='$CID', customerName='$customerName', area='$Area', dept='$Dept', noOfWorker='$noOfWorker', startTime='$startTime', startDate='$startDateFromDB', endTime='$endTime', endDate='$endDateFromDB', cost='$totalCost', address='$address' WHERE WID = '$WID'";
                  mysqli_query($conn, $sqlUpateToHistory);
              ?> 
          <aside class="toAssignLeft">
          <div class="loadAssignWorkerDown">
            <label id="labelID" name="labelID">Total Cost: <span class="highlight"><?php echo $totalCost." "."Tk" ?></span></label><br>
            <label>Start Time: <span class="highlight"><?php echo $startTime ?></span></label><br>
            <label>Start Date: <span class="highlight"><?php echo $startDateFromDB ?></span></label><br>
            <label>End Time: <span class="highlight"><?php echo $endTime ?></span></label><br>
            <label>End Date: <span class="highlight"><?php echo $endDateFromDB ?></span></label><br>
            <label id="customerName">Customer Name: <span class="highlight"><?php echo $customerName ?></span></label><br>
            <label>Customer Phone: <span class="highlight"><?php echo $customerPhone; ?></span></label><br>
            <label>Worker Name: <span class="highlight"><?php echo $workerName ?></span></label><br>
            <label>Worker Phone: <span class="highlight"><?php echo $workerPhone; ?></span></label><br>
            <label>Area: <span class="highlight"><?php echo $Area; ?></span></label><br>
            <label>Department: <span class="highlight"><?php echo $Dept ; ?></span></label><br>
            <label>No of worker: <span class="highlight"><?php echo $noOfWorker; ?></span></label><br>
            <label>Address: <span class="highlight"><?php echo $address; ?></span></label><br>
            </div>
            <div class="loadAssignButtonSet">
          <button type="submit" class="loadRequestSearchButton"id="<?php echo $startID; ?>" name="<?php echo $startID; ?>">Start</button>
          <button type="submit" class="loadRequestDeleteButton" id="<?php echo $endID; ?>" name="<?php echo $endID; ?>"> End </button>
          <button type="submit" class="loadRequestDeleteButton" id="<?php echo $deleteID; ?>" name="<?php echo $deleteID; ?>"> Delete </button>
            </div>
          </aside>
        <?php } ?>
          </div>
     </div>


      </aside>
       <aside id="loadRequest">
        <div class="loadRequestTop">
          <label>CUSTOMER REQUEST</label>
        </div>
        <div class="scrollOFRequest">
            <?php while($rowRequest=mysqli_fetch_assoc($resultRequest))
            { ?> 
            <?php 
            $time = $rowRequest['currentTimeHour'].":".$rowRequest['currentTimeMin'].$rowRequest['current'];
            $RID = $rowRequest['RID'];
            $customerName = $rowRequest['firstName']." ".$rowRequest['lastName'];
            $customerPhone = $rowRequest['phone'];
            $Area = $rowRequest['selectedArea'];
            $Dept = $rowRequest['selectedDept'];
            $noOfWorker = $rowRequest['noOfWorker'];
            $currentDate = $rowRequest['currentDate'];
            $address = $rowRequest['address'];
            $deleteID = "Dd".$RID;
            $search = "Ss".$RID;
            $requestDiv = "Div.".$RID;
            ?>
            <div class="loadRequestDown" id="<?php echo $requestDiv; ?>" onclick="DivFunction('<?php echo $RID; ?>', '<?php echo $customerName; ?>', '<?php echo $customerPhone; ?>', '<?php echo $Area; ?>', '<?php echo $Dept; ?>', '<?php echo $noOfWorker; ?>', '<?php echo $time; ?>', '<?php echo $currentDate; ?>', '<?php echo $address; ?>')">
            <label id="labelID" name="labelID">RID: <span class="highlight"><?php echo $RID; ?></span></label><br>
            <label>Delete Button: <span class="highlight"><?php echo $deleteID ?></span></label><br>
            <label>Select Button: <span class="highlight"><?php echo $search ?></span></label><br>
            <label id="customerName">Customer Name: <span class="highlight"><?php echo $customerName ?></span></label><br>
            <label>Customer Phone: <span class="highlight"><?php echo $customerPhone; ?></span></label><br>
            <label>Area: <span class="highlight"><?php echo $Area; ?></span></label><br>
            <label>Department: <span class="highlight"><?php echo $Dept ; ?></span></label><br>
            <label>No of worker: <span class="highlight"><?php echo $noOfWorker; ?></span></label><br>  <label>Time: <span class="highlight"><?php echo $time; ?></span></label><br>
            <label>Date: <span class="highlight"><?php echo $currentDate ?></span></label><br>
            <label>Address: <span class="highlight"><?php echo $address; ?></span></label><br>
            </div>
            <div class="loadRequestButtonSet">
          <button type="submit" id="<?php echo $search; ?>" class="loadRequestSearchButton" name="<?php echo $search; ?>" onclick="DivFunction('<?php echo $RID; ?>', '<?php echo $customerName; ?>', '<?php echo $customerPhone; ?>', '<?php echo $Area; ?>', '<?php echo $Dept; ?>', '<?php echo $noOfWorker; ?>', '<?php echo $time; ?>', '<?php echo $currentDate; ?>', '<?php echo $address; ?>')">Assign</button>
          <button type="submit" id="<?php echo $deleteID; ?>" class="loadRequestDeleteButton" name="<?php echo $deleteID; ?>"> Delete </button>
            </div>
            <?php } ?>
      </div>
       </aside>
     </section>
   </form>
    <section id="availableWorker">
      <div class="container">
        <div class="tran">
          <form class="size">
          <img src="./img/plumber.jpg">
          <h1>00</h1>
          <h3>Plumber</h3>
        </div>
        <div class="tran">
          <img src="./img/electric.png">
          <h1>00</h1>
          <h3>Electrician</h3>
        </div>
        <div class="tran"><er>
          <img src="./img/labor.jpg">
          <h1>00</h1>
          <h3>Labor</h3>
        </div>
        <div class="tran">
          <img src="./img/guard.jpg">
          <h1>00</h1>
          <h3>Guard</h3>
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