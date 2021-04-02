<?php 
session_start();
include "../../includes/connection.inc.php";
include "../../includes/constant.inc.php";
require_once "../login/authCookieSessionValidate.php";

if(!$isLoggedIn && !isset($_SESSION['userUId'])) {
  header("Location: ../login.php");
} else {
    if(isset($_GET['att-id'])) {
        $id = $_GET['att-id'];
        $sql = "DELETE FROM dish_details WHERE id=?";
        
        $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo mysqli_stmt_error($stmt);
        } else {
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            echo "Delete SuccessFull".$id;
        }
    }
}
    