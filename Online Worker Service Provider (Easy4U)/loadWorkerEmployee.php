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
$sqlDeptCheck = "SELECT * FROM dept";
    $resultDept = mysqli_query($conn, $sqlDeptCheck);
    $sqlAreaCheck = "SELECT * FROM area";
    $resultArea = mysqli_query($conn, $sqlAreaCheck);
if(isset($_POST['searchButton'])){
    $st = $_POST['search'];
    $sql = "SELECT * FROM worker JOIN dept ON dept.DID = worker.DID JOIN area ON area.AreaID = worker.AreaID
            WHERE userName LIKE '%$st%';";
    $result = mysqli_query($conn, $sql);
}
else{
  $sqlUserCheck="SELECT * FROM worker JOIN dept ON dept.DID = worker.DID JOIN area ON area.AreaID = worker.AreaID LIMIT $startingRow, $perPage;";;
  $result=mysqli_query($conn, $sqlUserCheck);
  //$row=mysqli_num_rows($result);
}
  $sqlRowCount="SELECT * FROM worker";
  $resultRowCount=mysqli_query($conn, $sqlRowCount);
  $rowCount=mysqli_num_rows($resultRowCount);

  $totalPage = ceil($rowCount / $perPage);
  if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
  if(isset($_POST['signout'])){
       $_SESSION['userName'] = "";
       header("Refresh:0; url=Home.php");
    }
  if(!empty($_POST['userName'])){
        $userName = $_POST['userName'];
    }
    if(!empty($_POST['firstName'])){
        $firstName = $_POST['firstName'];
    }
    if(!empty($_POST['lastName'])){
        $lastName = $_POST['lastName'];
    }
    if(!empty($_POST['phone'])){
        $phone = $_POST['phone'];
    }
    if(!empty($_POST['email'])){
        $email = $_POST['email'];
    }
    if(!empty($_POST['DOB'])){
        $DOB = $_POST['DOB'];
    }
    if(!empty($_POST['NID'])){
        $NID = $_POST['NID'];
    }
    if(!empty($_POST['address'])){
        $address = $_POST['address'];
    }
    if(!empty($_POST['selectedDept'])){
        $selectedDept = $_POST['selectedDept'];
    }
    if(!empty($_POST['selectedArea'])){
        $selectedArea = $_POST['selectedArea'];
    }
    if(!empty($_POST['active'])){
        $active = $_POST['active'];
    }
      $sqlUserW="SELECT DID FROM dept where name = '$selectedDept'";
     $resultUserW=mysqli_query($conn, $sqlUserW);
     while($rowW = mysqli_fetch_assoc($resultUserW)){
      $DID = $rowW['DID'];
  }
  $sqlUserA="SELECT AreaID FROM area where AreaName = '$selectedArea'";
     $resultUserA=mysqli_query($conn, $sqlUserA);
     while($rowA = mysqli_fetch_assoc($resultUserA)){
      $AreaID = $rowA['AreaID'];
  }
   if(isset($_POST['updateButton'])){   
     $sqlUserCheckToUpdate="SELECT * FROM worker where userName = '$userName'";
     $resultUser=mysqli_query($conn, $sqlUserCheckToUpdate);
     $rowUser=mysqli_num_rows($resultUser);
     if($rowUser < 1){
      $message = "User not available to update";
     }
    else{
    $sql = "UPDATE worker SET firstName='$firstName', lastName='$lastName', userName='$userName', email='$email', phone='$phone', NID='$NID', address='$address', DOB='$DOB', DID='$DID', AreaID='$AreaID', Active='$active' WHERE userName = '$userName'";

    $sql2 = "UPDATE login SET userName='$userName', phone='$phone' WHERE userName = '$userName'";
              mysqli_query($conn, $sql);
              mysqli_query($conn, $sql2);
              $message = "Update done!";
              header("Refresh:0; url=loadWorker.php");
         }
    }

if(isset($_POST['addButton'])){   
     $sqlUserCheckToUpdate="SELECT * FROM worker where userName = '$userName'";
     $resultUser=mysqli_query($conn, $sqlUserCheckToUpdate);
     $rowUser=mysqli_num_rows($resultUser);
    if($rowUser < 1){
      $sql = "INSERT INTO worker (firstName, lastName, userName, email, phone, NID, address, DOB, DID, AreaID, Active)
              VALUES ('$firstName', '$lastName', '$userName', '$email', '$phone', '$NID', '$address', '$DOB', '$DID', '$AreaID', '1');";
      $sql2 = "INSERT INTO login (userName, phone, password, status)
              VALUES ('$userName', '$phone', '1234', '3');";

              mysqli_query($conn, $sql);
              mysqli_query($conn, $sql2);
              header("Refresh:0; url=loadWorker.php");
   }
   else{
    $message = "User name or Phone already exist! Try another one!";
    }

    }

    if(isset($_POST['deleteButton'])){   
     $sqlUserCheckToUpdate="SELECT * FROM worker where userName = '$userName'";
     $resultUser=mysqli_query($conn, $sqlUserCheckToUpdate);
     $rowUser=mysqli_num_rows($resultUser);
     if($rowUser < 1){
     $message = "User not available to delete";
   }
   else{
      $sql = "DELETE FROM worker WHERE userName = '$userName'";

    $sql2 = "DELETE FROM login WHERE userName = '$userName'";
              mysqli_query($conn, $sql);
              mysqli_query($conn, $sql2);
    $message = "Successfully Delete!";
    header("Refresh:0; url=loadWorker.php");
  }
}
if(isset($_POST['refreshButton'])){ 
      header("Refresh:0; url=loadWorker.php");
    }
if(isset($_POST['refreshTable'])){ 
      header("Refresh:0; url=loadWorker.php");
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Easy4U</title>
  <link rel="stylesheet" href="./css/Home.CSS">
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
            <li><a href="PreviousRecordEmployee.php">Prevoius Record</a></li><br><br>
            <li class="current"><a href="loadWorkerEmployee.php">Workers</a></li><br><br>
            <li><a href="loadCustomerEmployee.php">Customers</a></li><br><br>
            <li><a href="EmployeeSetting.php">Settings</a></li><br><br>
          </ul>
        </nav>
      </form>
       </div>
     </section>

<form id="loadCustomer" action="loadWorkerEmployee.php" method="post">
     <section id="Customerload">
       <div class="container">
        <aside id="load">
             <h2><span class="highlight">Hello</span>, <?php echo $username ?> <h2>
              <button type="submit" id="refreshTable" class="Refresh" name="refreshTable"> Refresh </button>
              <input type="text" id="search" onkeyup="Search()" placeholder="Search for USER.." name="search">
              <button type="submit" id="searchButton" class="search" name="searchButton"> Search </button>
              <table id="show" class="tableLayout" style="width: 100%">
                <thead>
                <th><h2>User Name</h2></th>
                <th><h2>First Name</h2></th>
                <th><h2>Last Name</h2></th>
                <th><h2>Phone</h2></th>
                <th><h2>Email</h2></th>
                <th><h2>NID</h2></th>
                <th><h2>DOB</h2></th>
                <th><h2>Address</h2></th>
                <th><h2>Depeartment</h2></th>
                <th><h2>Area</h2></th>
                <th><h2>Active</h2></th>
              </thead>
              <tr><br></tr>
                <?php
                  while($row=mysqli_fetch_assoc($result))
                    {
                ?>
              <tr>
                <td><?php echo $row['userName']; ?></td>
                <td><?php echo $row['firstName']; ?></td>
                <td><?php echo $row['lastName']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['NID']; ?></td>
                <td><?php echo $row['DOB']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['AreaName']; ?></td>
                <td><?php echo $row['Active']; ?></td>
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
              <script
                 src="http://code.jquery.com/jquery-3.4.1.js"
                 integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
                 crossorigin="anonymous"></script>
              <script>
              var table = document.getElementById("show");
                for(var i = 1; i < table.rows.length; i++)
                {
                    table.rows[i].onclick = function()
                    {
                         rIndex = this.rowIndex;
                         console.log(rIndex);
                         document.getElementById("userName").value = this.cells[0].innerHTML;
                         document.getElementById("firstName").value = this.cells[1].innerHTML;
                         document.getElementById("lastName").value = this.cells[2].innerHTML;
                         document.getElementById("phone").value = this.cells[3].innerHTML;
                         document.getElementById("email").value = this.cells[4].innerHTML;
                         document.getElementById("NID").value = this.cells[5].innerHTML;
                         document.getElementById("DOB").value = this.cells[6].innerHTML;
                         document.getElementById("address").value = this.cells[7].innerHTML;
                         document.getElementById("selectedDept").value = this.cells[8].innerHTML;
                         document.getElementById("selectedArea").value = this.cells[9].innerHTML;
                         document.getElementById("active").value = this.cells[10].innerHTML;
                    };
                  }

                  /*$(document).ready(function(){
                    $('#search').on('blur',function(){
                    $('#show').load('loadCustomer.php',{search: document.getElementById('search').value});
                     });
                     });*/
       

                 function Search() {
                var input = document.getElementById("search");
                var filter = input.value.toUpperCase();
                var tr = table.getElementsByTagName("tr");
                var txtValue, td, tdPhone, tr, i;
                for (i = 0; i < tr.length; i++) {
                   td = tr[i].getElementsByTagName("td")[0];
                   if (td) {
                     txtValue = td.textContent || td.innerText;
                     if (txtValue.toUpperCase().indexOf(filter) > -1) {
                       tr[i].style.display = "";
                       console.log(tr[i]);
                     }
                    else {
                       tr[i].style.display = "none";
                      }
                    }
                };

              }


       </script>
       <div id="buttonpg">
       <a href="loadWorkerEmployee.php?prev=<?php echo $a-1; ?>" class="buttonpg">Previous</a>
       <?php
      for($i=1; $i<=$totalPage; $i++){ ?>
       <a href="loadWorkerEmployee.php?pg=<?php echo $i; ?>" class="buttonpg"><?php echo $i; ?></a>
       <?php
      }
      ?>
       <a href="loadWorkerEmployee.php?next=<?php echo $a+1; ?>" class="buttonpg">Next</a>
     </div>

       </aside>
       <aside id="loadUpdate">
                <div>
                    <button type="submit" id="refreshButton" class="Refresh" name="refreshButton"> Refresh </button>
                </div>
                <div>
                    <label>User Name: </label>
                    <input type="text" name="userName" id="userName">
                </div>
                <div>
                    <label>First Name: </label>
                </div>
                    <input type="text" name="firstName" id="firstName" >
                <div>
                    <label>Last Name: </label>
                    <input type="text" name="lastName" id="lastName" >
                </div>              
                <div>
                    <label>Phone number: </label>
                    <input type="Phone" name="phone" id="phone">
                </div>
                <div>
                    <label>Email: </label>
                    <input type="Email" name="email" id="email" >
                </div>
                <div>
                    <label>National ID card: </label>
                    <input type="number" name="NID" id="NID" >
                </div>
                <div>
                    <label>Date Of Birth: </label>
                    <input type="Date" name="DOB" id="DOB" >
                </div>
                <div>
                    <label>Address: </label>
                    <input type="text" name="address" id="address" >
                </div>
                <div>
                <label>Department</label>
                <select name="selectedDept" id="selectedDept">
                  <?php
                  while($rowDept=mysqli_fetch_assoc($resultDept))
                     {
                     ?>
                     <option value="<?php echo $rowDept['name']; ?>" required><?php echo $rowDept['name']; ?></option>
                <?php
                   } 
                   ?>
                  </select><br><br>
                </div>
                <div>
                  <label>AREA</label>
                   <select name="selectedArea" id="selectedArea">
                <?php
                  while($rowArea=mysqli_fetch_assoc($resultArea))
                    {
                ?>
                <option value="<?php echo $rowArea['AreaName']; ?>" required><?php echo $rowArea['AreaName']; ?></option>
               <?php
                } 
              ?>
      </select><br><br>
               </div>
               <div>
                    <label>Active: </label>
                    <input type="text" name="active" id="active" >
                </div>
                <div>
                    <button type="submit" class="Update" name="updateButton"> Update </button>
                    <button type="submit" class="Add" name="addButton"> Add </button>
                    <button type="submit" class="Delete" name="deleteButton"> Delete </button>
                    <span style="color:red"><?php echo $message; ?></span>
                </div>
       </aside>
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