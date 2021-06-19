<?php
include "includes/db_connect.inc.php";

session_start();
$username = $_SESSION['userName'];
$message = "";
$totalPage = 0;
$perPage = 3;
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
if(isset($_POST['signout'])){
       $_SESSION['userName'] = "";
       header("Refresh:0; url=Home.php");
    }
if(isset($_POST['searchButton'])){
    $st = $_POST['search'];
    $sql = "SELECT * FROM history
            WHERE RecordID LIKE '%$st%';";

    $result = mysqli_query($conn, $sql);
    //$row=mysqli_num_rows($result);
}
else{
  $sqlUserCheck="SELECT * FROM history LIMIT $startingRow, $perPage;";
  $result=mysqli_query($conn, $sqlUserCheck);
  //$row=mysqli_num_rows($result);
}



  $sqlRowCount="SELECT * FROM history";
  $resultRowCount=mysqli_query($conn, $sqlRowCount);
  $rowCount=mysqli_num_rows($resultRowCount);

  $totalPage = ceil($rowCount / $perPage);


  if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
  if(!empty($_POST['DID'])){
        $DID = $_POST['DID'];
    }
    if(!empty($_POST['name'])){
        $name = $_POST['name'];
    }
    if(!empty($_POST['Rate'])){
        $Rate = $_POST['Rate'];
    }
    
  if(isset($_POST['updateButton'])){   
     $sqlUserCheckToUpdate="SELECT * FROM dept where DID = '$DID'";
     $resultUser=mysqli_query($conn, $sqlUserCheckToUpdate);
     $rowUser=mysqli_num_rows($resultUser);
    if($rowUser < 1){
     $message = "User not available to update";
   }
   else{
    $sql = "UPDATE dept SET name='$name',Rate='$Rate'  WHERE DID = '$DID'";

              mysqli_query($conn, $sql);
              $message = "Update done!";
         }
    }

if(isset($_POST['addButton'])){   
     $sqlUserCheckToUpdate="SELECT * FROM dept where name = '$name'";
     $resultUser=mysqli_query($conn, $sqlUserCheckToUpdate);
     $rowUser=mysqli_num_rows($resultUser);
    if($rowUser < 1){
      $sql = "INSERT INTO dept (name,Rate)
              VALUES ('$name','$Rate');";
   
              mysqli_query($conn, $sql);
              $message = "Add done!";

            
   }
   else{
    $message = "Department name already exist! Try another one!";
    }

    }

    if(isset($_POST['deleteButton'])){   
     $sqlUserCheckToUpdate="SELECT * FROM dept where DID = '$DID'";
     $resultUser=mysqli_query($conn, $sqlUserCheckToUpdate);
     $rowUser=mysqli_num_rows($resultUser);
     if($rowUser < 1){
     $message = "User not available to delete";
   }
   else{
      $sql = "DELETE FROM dept WHERE DID = '$DID'";

              mysqli_query($conn, $sql);
              mysqli_query($conn, $sql2);
    $message = "Successfully Delete!";
  }
}
if(isset($_POST['refreshButton'])){ 
      header("Refresh:0; url=AddDepartment.php");
    }
if(isset($_POST['refreshTable'])){ 
      header("Refresh:0; url=AddDepartment.php");
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Easy4U</title>
  <link rel="stylesheet" href="./css/Home.css">
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
        <form class="EmployeeSidebar">
        <nav>
          <ul>
            <div class="HireNowBorder">
            <li><a href="Employee.php">My Account</a></li><br><br>
          </div>
            <li><a href="EmployeeAccountInfo.php">My Account Information</a></li><br><br><br>
            <li class="current"><a href="PreviousRecordEmployee.php">Prevoius Record</a></li><br><br>
            <li><a href="loadWorkerEmployee.php">Workers</a></li><br><br>
            <li><a href="loadCustomerEmployee.php">Customers</a></li><br><br>
            <li><a href="EmployeeSetting.php">Settings</a></li><br><br>
          </ul>
        </nav>
      </form>
       </div>
     </section>

<form id="loadCustomer" action="PrevoiusRecord.php" method="post">
     <section id="Customerload">
       <div class="container">
        
             <h2><span class="highlight">Hello</span>, <?php echo $username ?> <h2>
              <button type="submit" id="refreshTable" class="Refresh" name="refreshTable"> Refresh </button>
              <input type="text" id="search" onkeyup="Search()" placeholder="Search for Department" name="search">
              <button type="submit" id="searchButton" class="search" name="searchButton"> Search </button>
              <table id="show" class="tableLayout" style="width: 100%">
                <thead>
                <th><h2>RecordID</h2></th>
                <th><h2>CID</h2></th>
                <th><h2>WID</h2></th>
                <th><h2>Worker Name</h2></th>
                <th><h2>Customer Name</h2></th>
                <th><h2>Area</h2></th>
                <th><h2>Dept</h2></th>
                <th><h2>No.of worker</h2></th>
                <th><h2>Start Time</h2></th>
                <th><h2>Start Date</h2></th>
                <th><h2>End Time</h2></th>
                <th><h2>End Date</h2></th>
                <th><h2>Cost</h2></th>
                <th><h2>Address</h2></th>



               
              </thead>
              <tr><br></tr>
                <?php
                  while($row=mysqli_fetch_assoc($result))
                    {
                ?>
              <tr>
                <td><?php echo $row['RecordID']; ?></td>
                <td><?php echo $row['CID']; ?></td>
                <td><?php echo $row['WID']; ?></td>
                <td><?php echo $row['workerName']; ?></td>
                <td><?php echo $row['customerName']; ?></td>
                <td><?php echo $row['area']; ?></td>
                <td><?php echo $row['dept']; ?></td>
                <td><?php echo $row['noOfWorker']; ?></td>
                <td><?php echo $row['startTime']; ?></td>
                <td><?php echo $row['startDate']; ?></td>
                <td><?php echo $row['endTime']; ?></td>
                <td><?php echo $row['endDate']; ?></td>
                <td><?php echo $row['cost']; ?></td>
                <td><?php echo $row['address']; ?></td>


                
              </tr>
              <?php
                } 
              ?>
              </table>
              <span style="color:red"><?php echo $message; ?></span>
              <style>
                table thead{
                  background-color: #29a329;
                  border: 3px solid black;
                 }
                table tr:not(:first-child):hover{background-color: #666; color: #ffffff}
              </style>
              <br><br><br>
    
<aside id="load">
       </aside>
       
     </section>
   </form>
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