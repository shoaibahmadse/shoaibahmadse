<?php 
include_once "layout/header.php";
include_once "../includes/constant.inc.php";
include "../includes/connection.inc.php";
$error = false;
$ii = -1;
if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
	$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM site_details WHERE id='$id'"));
    $phone = $row['phone_contact'];
	$email = $row['email_contact'];
	$img = $row['menu_image'];
	

} else {
    header('Location: index.php');
}
if(isset($_GET['error'])) {
    $error = true;
    if($_GET['error'] == 'dish-already-exists') {
        $msg = 'Dish Already Exists';
    } else if($_GET['error'] == 'empty-fields') {
        $msg = "Please Fill all Fields";
    }

}

if(isset($_GET['status'])) {
    if($_GET['status'] == 'successful') {
        $msg = "Edited Successfully";
    } else {
        $msg = "Some error occurred please try again!";
    }
}

?>



<main class="sm:ml-48 sm:mr-6 mt-4">
    <div class="container bg-white p-5 shadow-lg">
        <p class="text-center text-xl md:text-3xl font-extrabold">Edit Site Details</p>
        <a class="underline text-sm text-blue-500" href="index.php">Return To Site Details Page</a>
    </div>
    <form class="container text-center text-lg mt-3 bg-white shadow-lg" method="post" action="includes/editDetails.inc.php" enctype="multipart/form-data">
        <label class="m-3 p-2 text-2xl" for="phone">Phone Number</label>
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input class="m-3 p-2 rounded-md bg-gray-200" type="number" value="<?php echo $phone ?>" placeholder="Write Site Phone Number" name="phone"><br>
        <label class="m-3 p-2 text-2xl" for="email">Email</label>
        <input class="m-3 p-2 rounded-md bg-gray-200" type="email" value="<?php echo $email ?>" placeholder="Write Site Email" name="email"><br>
        <label class="m-3 p-2 text-2xl" for="image">Menu Image</label>
        <input class="m-3 p-2 rounded-md bg-gray-200" type="file" placeholder="Menu Image" name="image"><br>
        <button class="m-3 p-2 cursor-pointer bg-orange-400 hover:bg-orange-500 rounded-md" type="submit" name="submit">Submit</button>
        <div class="p-2 font-bold <?php if($error){ echo "text-red-600"; } else{ echo "text-green-600"; } ?>">
            <?php if(isset($msg)){
                echo $msg;    
                }
            ?>
        </div>
    </form>
</main>
<?php 
include_once "layout/footer.php";
?>