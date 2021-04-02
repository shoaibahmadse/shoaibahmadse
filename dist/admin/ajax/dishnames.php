<?php 
session_start();
include "../../includes/connection.inc.php";
include "../../includes/constant.inc.php";
require_once "../login/authCookieSessionValidate.php";

if(!$isLoggedIn && !isset($_SESSION['userUId'])) {
  header("Location: ../../not-found.php");
  die();
} else{
    if(isset($_GET['category-id'])) {
        $categoryId = mysqli_real_escape_string($conn, $_GET['category-id']);
        $dishSql = "SELECT * FROM dish WHERE category_id='$categoryId'";
        $result = mysqli_query($conn, $dishSql);
        $dishNames = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($dishNames);
    } else {
        echo "Error not found";
    }
}