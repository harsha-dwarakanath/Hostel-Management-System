<?php
session_start();
if (isset($_POST['update-submit'])) 
{

  require 'config.inc.php';

  $fname = $_POST['student_fname'];
  $lname = $_POST['student_lname'];
  $mobile = $_POST['mobile_no'];
  $mail = $_POST['mail'];
  $year = $_POST['year_of_study'];
  //$password = $_POST['pwd'];
  //$cnfpassword = $_POST['confirmpwd'];


  if(!preg_match("/^[a-zA-Z0-9]*$/",$_SESSION['roll'])){
    echo"<script>alert('Invalid Roll Number');window.location='../update.php'</script>";
    exit();
  }
  //else if($password !== $cnfpassword){
   // echo"<script>alert('Passwords enetered do not match');window.location='../signup.php'</script>";
    //exit();
 // }
  else {

    $sql = "SELECT Student_id FROM Student WHERE Student_id=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      echo"<script>window.location='../update_profile.php'</script>";
      exit();
    }
    else
     {
      mysqli_stmt_bind_param($stmt, "s", $_SESSION['roll']);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) 
      {
        $sql="UPDATE Student SET Fname='$fname',Lname='$lname',Mob_no='$mobile',Mail='$mail', Year_of_study='$year' WHERE Student_id='".$_SESSION['roll']."'";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            echo"<script>window.location='../update_profile.php'</script>";
            exit();
        }
        else
        {
        mysqli_stmt_bind_param($stmt, "sssss", $fname, $lname, $mobile , $mail, $year);
        mysqli_stmt_execute($stmt);
        echo"<script>window.location='../index.php'</script>";
        exit();
         }
      }
      else 
      {
        echo"<script>alert('cant update profile');window.location='../update_profile.php'</script>";
        exit();
      }
        }
    }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);

}
else {
  echo"<script>window.location='../update_profile.php'</script>";
  exit();
}
