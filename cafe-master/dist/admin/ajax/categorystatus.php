<?php
session_start();
include "../../includes/connection.inc.php";
include "../../includes/constant.inc.php";
require_once "../login/authCookieSessionValidate.php";

if(!$isLoggedIn && !isset($_SESSION['userUId'])) {
  header("Location: ../login.php");
} else {
    if(isset($_GET['category-id'])) {
        $categoryId = mysqli_real_escape_string($conn, $_GET['category-id']);
        $statusSql = "SELECT * FROM category WHERE id='$categoryId'";
        $result = mysqli_query($conn, $statusSql);
        $status = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($status);
    } else {
        echo "Error not found";
    }
}
