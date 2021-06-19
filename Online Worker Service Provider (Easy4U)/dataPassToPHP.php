<?php

  include "includes/db_connect.inc.php";
session_start();
  if(isset($_POST['selectedAreaInNext'])){
    $selectedArea = $_POST['selectedAreaInNext'];
    $selectedDept = $_POST['selectedDeptInNext'];
    $noOfWorker = $_POST['noOfWorkerInNext'];
    $address = $_POST['addressInNext'];
    $CID = $_SESSION['CID'];
    date_default_timezone_set("Asia/Dhaka");
    $currentDate = date("Y-m-d");
    $currentTimeHour = date("g");
    $currentTimeMin = date("i");
    $current = date("a");
    $currentTime = $currentTimeHour.":".$currentTimeMin.$current;
    
    $sqlRequestSetWorker="SELECT * FROM worker 
                                            JOIN dept ON dept.DID = worker.DID 
                                            JOIN area ON area.AreaID = worker.AreaID
                                            where name='$selectedDept' and AreaName='$selectedArea'";
                      $resultRequestSetWorker=mysqli_query($conn, $sqlRequestSetWorker);
                      $rowCountSetWorker = mysqli_num_rows($resultRequestSetWorker);
                     
if($rowCountSetWorker >= $noOfWorker){
    $sql = "INSERT INTO request (selectedDept, selectedArea, noOfWorker, currentDate, currentTimeHour, currentTimeMin, current, address, CID)
              VALUES ('$selectedDept', '$selectedArea', '$noOfWorker', '$currentDate', '$currentTimeHour', '$currentTimeMin', '$current', '$address', '$CID');";
    mysqli_query($conn, $sql);
    $message = "Done";
    echo "<script type='text/javascript'>alert('$message');</script>";
    /*header("location:Customer.php");*/
}
else{
    $message = "Number of worker is not Available! For your Area and Department currently we have ".$rowCountSetWorker." worker";
     echo "<script type='text/javascript'>alert('$message');</script>";
     echo '<span style="color:#FF0000;text-align:center;">Number of worker is not Available! For your Area and Department currently we have </span>';
     echo $rowCountSetWorker;
     echo '<span style="color:#FF0000;text-align:center;"> worker! </span>';
 }
}
?>