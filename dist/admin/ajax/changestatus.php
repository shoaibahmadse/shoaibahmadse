<?php
session_start();
include "../../includes/connection.inc.php";
include "../../includes/constant.inc.php";
require_once "../login/authCookieSessionValidate.php";

if(!$isLoggedIn && !isset($_SESSION['userUId'])) {
  header("Location: ../login.php");
} else {
    if(isset($_GET['id']) && isset($_GET['status']) ){
        
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $status = $_GET['status'];
        if($status == 'active') {
            $stat = 0;
        } else {
            $stat = 1;
        }
        //parameterize it in production
        mysqli_query($conn,"UPDATE category SET status='$stat' WHERE id='$id'");
    }
}