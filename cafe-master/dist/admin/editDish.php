<?php 
include_once "layout/header.php";
include_once "../includes/constant.inc.php";
include "../includes/connection.inc.php";
$error = false;
$ii = -1;
if(isset($_GET['id']) && isset($_GET['catName'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
	$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM dish WHERE id='$id'"));
    $catName = $_GET['catName'];
    $catId = $row['category_id'];
	$dishName = $row['dish'];
	$dishDetail = $row['dish_detail'];
	

} else {
    header('Location: dish.php?notDefined');
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

$categories = mysqli_query($conn, "SELECT * FROM category WHERE status='1' ORDER BY category ");
?>



<main class="sm:ml-48 sm:mr-6 mt-4">
    <div class="container bg-white p-5 shadow-lg">
        <p class="text-center text-xl md:text-3xl font-extrabold">Add Dish Item</p>
        <a class="underline text-sm text-blue-500" href="dish.php">Return To Dish Management Page</a>
    </div>
    <div class="modalBox text-center bg-gray-300 modal-box m-auto tracking-wider p-2 shadow-lg z-50 hidden">
        <p class="msg">Do you really want to delete this?</p>
        <div class="m-2 p-2">
            <button onclick="delAtt(<?php echo $id ?>)" class="del-link text-white p-1 m-4 bg-green-500">Confirm</button>
            <button class="font-bold p-1 m-4 focus:outline-none text-white bg-red-500" onclick="clearModal()">Deny</button>
        </div>
    </div>
    <form class="container text-center text-lg mt-3 bg-white shadow-lg" method="post" action="includes/editDish.inc.php" enctype="multipart/form-data">
        <label class="m-3 p-2 text-2xl" for="name">Dish Name</label>
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input class="m-3 p-2 rounded-md bg-gray-200" type="text" value="<?php echo $dishName ?>" placeholder="Write Dish Name" name="name">
        <div>
            <label class="m-3 p-2 text-2xl" for="Category">Category</label>
            <select name="category">
                <option>Select Category</option>
                <?php 
                    while($row_category = mysqli_fetch_assoc($categories)) {
                        if($row_category['id'] == $catId) {
                            echo "<option value='".$row_category['id']."' selected>".$row_category['category']."</option>";
                        } else {
                            echo "<option value='".$row_category['id']."'>".$row_category['category']."</option>";
                        }
                        
                    }
                ?>
            </select>
        </div>
        <label class="m-3 p-2 text-2xl" for="image">Dish Image</label>
        <input class="m-3 p-2 rounded-md bg-gray-200" type="file" placeholder="Dish Image" name="image"><br>
        <label class="m-3 p-2 text-2xl" for="name">Dish Details</label><br>
        <textarea class="m-3 p-2 rounded-md bg-gray-200 resize-none" type="text" placeholder="Write Dish Details" name="details"><?php echo $dishDetail ?></textarea><br>
        <div id="attribute-box">
        <?php 
            $dish_att = mysqli_query($conn, "SELECT * FROM dish_details WHERE dish_id='$id'"); 
            while($dish_details_row=mysqli_fetch_assoc($dish_att)) {    
        ?>
        
            <div class="flex justify-around flex-column sm:flex-row">
                <div>
                    <label class="block sm:inline" for="attribute">Dish Attribute</label>
                    <input class="m-3 p-2 rounded-md bg-gray-200" type="text" placeholder="Write Dish Attribute" required name="attribute[]" value="<?php echo $dish_details_row['attribute'] ?>">
                </div>
                <input type="hidden" name="dish_details_id[]" value="<?php echo $dish_details_row['id'] ?>">
                <div>
                    <input class="m-3 p-2 rounded-md bg-gray-200" type="text" placeholder="Write Price" required name="price[]" value="<?php echo $dish_details_row['price'] ?>">
                </div>
            </div>
        <?php
                $attId = $dish_details_row['id']; 
                $ii++;
            }
        ?>
        </div>
        <button class="m-3 p-2 cursor-pointer bg-orange-400 hover:bg-orange-500 rounded-md" type="submit" name="submit">Submit</button>
        <button class="m-3 p-2 cursor-pointer bg-orange-400 hover:bg-orange-500 rounded-md" type="button" onclick="addMore()">Add More</button>
        <?php 
            if($ii >= 1) {
        ?>
            <button id="remove-btn" class="m-3 p-2 cursor-pointer bg-orange-400 hover:bg-orange-500 rounded-md" type="button" onclick="callModal(<?php echo $attId ?>)">Remove</button>
        <?php    
            } else {
        ?>
            <button id="remove-btn" class="m-3 p-2 cursor-pointer bg-orange-400 hover:bg-orange-500 rounded-md hidden" type="button" onclick="callModal()">Remove</button>
        <?php                
            }     
        ?>
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