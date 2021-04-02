<?php 
session_start();
include "../includes/connection.inc.php";
include "../includes/constant.inc.php";
require_once "login/authCookieSessionValidate.php";

if(!$isLoggedIn && !isset($_SESSION['userUId'])) {
  header("Location: ../not-found.php");
}

$username = $_SESSION['userUId'];

$currentPathString = $_SERVER['REQUEST_URI'];
$currentPathArray = explode('/', $currentPathString);
$currentPathFull = $currentPathArray[count($currentPathArray) - 1];
//This gives Path without appended variables in link
if(strpos($currentPathFull, '?') !== False) {
  $currentPath = substr($currentPathFull, 0, strpos($currentPathFull, "?"));
} else {
  $currentPath = $currentPathFull;
}
$pageTitle = '';

if($currentPath == '' || $currentPath == 'index.php') {
  $pageTitle = 'Dashboard';
} else if($currentPath == 'categories.php' || $currentPath == 'addCategories.php' || $currentPath == 'editCategories.php') {
  $pageTitle = 'Categories Management';
} else if($currentPath == 'dish.php' || $currentPath == 'addDish.php' || $currentPath == 'editDish.php') {
  $pageTitle = 'Dish Management';
} else {
  $pageTitle = 'error';
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=MuseoModerno&family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.17.1/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="../style.min.css" />
    <link rel="stylesheet" href="../fonts.css">
    <link rel="stylesheet" href="../global_css/global.css">
    <link rel="stylesheet" href="css/custom.css" />
    <script
      src="https://kit.fontawesome.com/294f177ac8.js"
      crossorigin="anonymous"
    ></script>
    <title><?php if($pageTitle !== ''){ echo $pageTitle ;} else{ echo SITE_NAME ;}?></title>
  </head>
  <body class="h-full bg-gray-300 general-font">
    <div class="wrapper-full"></div>
    <header class="flex justify-between bg-orange-200 shadow-lg z-30 sticky top-0 fancy-font">
      <div class="burger" onclick="slideIn()">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
      </div>
      <div>
        <h2 class="text-orange-600 text-3xl font-bold">Cafe Pyala</h2>
      </div>
      <div class="flex text-xl my-auto mr-3 cursor-pointer trigger" onclick="showLogout()">
        <h2 class="mr-3 hidden sm:block capitalize"><?php echo $username ?></h2>
        <span>
          <i class="fas fa-caret-down"></i>
        </span>
        <form action="logout.php" method="post" class="flex bg-gray-200 absolute mt-12 right-5 z-10 hidden log-out px-4 py-2">
          
          <button type="submit" class="text-sm py-2"><i class="fas fa-power-off mt-2 mr-3 text-sm py-2"></i>Logout</a>
        </form>
      </div>
    </header>
    <nav class="h-full p-0 w-screen text-center text-sm sm:w-40 nav-bar bg-orange-200 shadow-xl shadow-inner transform -translate-x-full sm:translate-x-0" >
      <a
        class="block text-orange-700 mt-4 mb-3 p-2 mx-auto hover:bg-orange-700 hover:text-orange-200 <?php if($pageTitle == "Dashboard"){ echo "active-page";} ?>"
        href="index.php"
        >Dashboard</a
      >
      <a
        class="block text-orange-700 mt-6 mb-3 p-2 mx-auto hover:bg-orange-700 hover:text-orange-200  <?php if($pageTitle == "Categories Management"){ echo "active-page";} ?>"
        href="categories.php"
        >Category Management</a
      >
      <a
        class="block text-orange-700 mt-6 mb-3 p-2 mx-auto hover:bg-orange-700 hover:text-orange-200  <?php if($pageTitle == "Dish Management"){ echo "active-page";} ?>"
        href="dish.php"
        >Dish Management</a
      >
    </nav>
