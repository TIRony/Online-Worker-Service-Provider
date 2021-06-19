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

if(isset($_POST['searchButton'])){
    $st = $_POST['search'];
    $sql = "SELECT * FROM area
            WHERE AreaName LIKE '%$st%';";

    $result = mysqli_query($conn, $sql);
    //$row=mysqli_num_rows($result);
}
else{
  $sqlUserCheck="SELECT * FROM area LIMIT $startingRow, $perPage;";
  $result=mysqli_query($conn, $sqlUserCheck);
  //$row=mysqli_num_rows($result);
}
  $sqlRowCount="SELECT * FROM area";
  $resultRowCount=mysqli_query($conn, $sqlRowCount);
  $rowCount=mysqli_num_rows($resultRowCount);

  $totalPage = ceil($rowCount / $perPage);
  if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
  if(isset($_POST['signout'])){
       $_SESSION['userName'] = "";
       header("Refresh:0; url=Home.php");
    }
  if(!empty($_POST['AreaId'])){
        $AreaId = $_POST['AreaId'];
    }
    if(!empty($_POST['AreaName'])){
        $AreaName = $_POST['AreaName'];
    }
 
    
  if(isset($_POST['updateButton'])){   
     $sqlUserCheckToUpdate="SELECT * FROM area where AreaId= '$AreaId'";
     $resultUser=mysqli_query($conn, $sqlUserCheckToUpdate);
     $rowUser=mysqli_num_rows($resultUser);
    if($rowUser < 1){
     $message = "User not available to update";
   }
   else{
    $sql = "UPDATE area SET AreaName='$AreaName' WHERE AreaId = '$AreaId'";

              mysqli_query($conn, $sql);
              $message = "Update done!";
         }
    }

if(isset($_POST['addButton'])){   
     $sqlUserCheckToUpdate="SELECT * FROM area where AreaName = '$AreaName'";
     $resultUser=mysqli_query($conn, $sqlUserCheckToUpdate);
     $rowUser=mysqli_num_rows($resultUser);
    if($rowUser < 1){
      $sql = "INSERT INTO area(AreaName)
              VALUES ('$AreaName');";
   
              mysqli_query($conn, $sql);
              $message = "Area added!";

            
   }
   else{
    $message = "Area name already exist! Try another one!";
    }

    }

    if(isset($_POST['deleteButton'])){   
     $sqlUserCheckToUpdate="SELECT * FROM area where AreaId = '$AreaId'";
     $resultUser=mysqli_query($conn, $sqlUserCheckToUpdate);
     $rowUser=mysqli_num_rows($resultUser);
     if($rowUser < 1){
     $message = "User not available to delete";
   }
   else{
      $sql = "DELETE FROM area WHERE AreaId = '$AreaId'";

              mysqli_query($conn, $sql);
              
    $message = "Successfully Delete!";
  }
}
if(isset($_POST['refreshButton'])){ 
      header("Refresh:0; url=Area.php");
    }
if(isset($_POST['refreshTable'])){ 
      header("Refresh:0; url=Area.php");
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
            <li><a href="Admin.php">My Account</a></li><br><br>
          </div>
            <li><a href="AdminAccountInfo.php">My Account Information</a></li><br><br><br>
            <li><a href="PreviousRecord.php">Prevoius Record</a></li><br><br>
            <li><a href="loadWorker.php">Worker</a></li><br><br>
            <li><a href="loadCustomer.php">Customer</a></li><br><br>
            <li><a href="loadEmployee.php">Employee</a></li><br><br>
            <li><a href="AddDepartment.php">Department</a></li><br><br>
            <li class="current"><a href="Area.php">Coverage Area</a></li><br><br>
          
            <li><a href="AdminSetting.php">Settings</a></li><br><br>
          </ul>
        </nav>
      </form>
       </div>
     </section>

<form id="loadCustomer" action="Area.php" method="post">
     <section id="Customerload">
       <div class="container">
        <aside id="load">
             <h2><span class="highlight">Hello</span>, <?php echo $username ?> <h2>
              <button type="submit" id="refreshTable" class="Refresh" name="refreshTable"> Refresh </button>
              <input type="text" id="search" onkeyup="Search()" placeholder="Search for Department" name="search">
              <button type="submit" id="searchButton" class="search" name="searchButton"> Search </button>
              <table id="show" class="tableLayout" style="width: 100%">
                <thead>
                <th><h2>Area ID</h2></th>
                <th><h2>Area Name</h2></th>
              
               
              </thead>
              <tr><br></tr>
                <?php
                  while($row=mysqli_fetch_assoc($result))
                    {
                ?>
              <tr>
                <td><?php echo $row['AreaID']; ?></td>
                <td><?php echo $row['AreaName']; ?></td>
                
                
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
                         document.getElementById("AreaId").value = this.cells[0].innerHTML;
                         document.getElementById("AreaName").value = this.cells[1].innerHTML;
                         
                    };
                  }

                  /*$(document).ready(function(){
                    $('#search').on('blur',function(){
                    $('#show').load('loadCustomer.php',{search: document.getElementById('search').value});
                     });
                     });*/
       

                 /*function Search() {
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

              }*/


       </script>
       <div id="buttonpg">
       <a href="Area.php?prev=<?php echo $a-1; ?>" class="buttonpg">Previous</a>
       <?php
      for($i=1; $i<=$totalPage; $i++){ ?>
       <a href="Area.php?pg=<?php echo $i; ?>" class="buttonpg"><?php echo $i; ?></a>
       <?php
      }
      ?>
       <a href="Area.php?next=<?php echo $a+1; ?>" class="buttonpg">Next</a>
     </div>

       </aside>
       <aside id="loadUpdate">
                <div>
                    <button type="submit" id="refreshButton" class="Refresh" name="refreshButton"> Refresh </button>
                </div>
                <div>
                    <label>Area Id </label>
                    <input readonly="" type="text" name="AreaId" id="AreaId">
                </div>
                <div>
                    <label>Area Name: </label>
                </div>
                    <input type="text" name="AreaName" id="AreaName" >
                            
               
                <div>
                    <button type="submit" class="Update" name="updateButton"> Update </button>
                    <button type="submit" class="Add" name="addButton"> Add </button>
                    <button type="submit" class="Delete" name="deleteButton"> Delete </button>
                    <span style="color:red"><?php echo $message; ?></span>
                </div>
       </aside>
     </section>
   </form>
    </section>
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