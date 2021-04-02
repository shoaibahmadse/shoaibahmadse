<?php 
include_once "layout/header.php";
include_once "../includes/constant.inc.php";

$error = false;

if(isset($_GET['error'])) {
    $error = true;
    if($_GET['error'] == 'dish-already-exists') {
        $msg = 'Dish Already Exists';
    } else if($_GET['error'] == 'empty-fields') {
        $msg = "Please Fill all Fields";
    } else if($_GET['error'] == 'invalid-file-format'){
        $msg = "Invalid File Format. Use jpeg or png";
    }

}

if(isset($_GET['status'])) {
    if($_GET['status'] == 'successful') {
        $msg = "Added Successfully";
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
    <form class="container text-center text-lg mt-3 bg-white shadow-lg" method="post" action="includes/addDish.inc.php" enctype="multipart/form-data">
        <label class="m-3 p-2 text-2xl" for="name">Dish Name</label>
        <input class="m-3 p-2 rounded-md bg-gray-200" type="text" placeholder="Write Dish Name" name="name">
        <div>
            <label class="m-3 p-2 text-2xl" for="Category">Category</label>
            <select name="category">
                <option value="">Select Category</option>
                <?php 
                    while($row_category = mysqli_fetch_assoc($categories)) {
                        echo "<option value='".$row_category['id']."'>".$row_category['category']."</option>";
                    }
                ?>
            </select>
        </div>
        <div class="mx-auto overflow-hidden">
            <label class="m-3 p-2 text-lg md:text-2xl" for="image">Dish Image</label>
            <input class="md:m-3 m-1 md:p-2 p-1 rounded-md bg-gray-200 text-sm" type="file" placeholder="Dish Image" required name="image"><br>
        </div>
        <label class="m-3 p-2 text-lg md:text-2xl" for="name">Dish Details</label><br>
        <textarea class="m-3 p-2 rounded-md bg-gray-200 resize-none" type="text" placeholder="Write Dish Details" name="details"></textarea><br>
        <div id="attribute-box">
            <div class="flex justify-around flex-col md:flex-row">
                <div>
                    <label for="attribute">Dish Attribute</label>
                    <input class="md:m-3 md:p-2 m-2 p-1 rounded-md bg-gray-200 text-sm" type="text" placeholder="Write Dish Attribute" required name="attribute[]">
                </div>
                <div>
                    <input class="md:m-3 md:p-2 m-2 p-1 text-sm rounded-md bg-gray-200" type="number" placeholder="Write Price" required name="price[]">
                </div>
            </div>
        </div>
        <button class="m-3 p-2 cursor-pointer bg-orange-400 hover:bg-orange-500 rounded-md" type="submit" name="submit">Submit</button>
        <button class="m-3 p-2 cursor-pointer bg-orange-400 hover:bg-orange-500 rounded-md" type="button" onclick="addMore()">Add More</button>
        <button id="remove-btn" class="m-3 p-2 cursor-pointer bg-orange-400 hover:bg-orange-500 rounded-md hidden" type="button" onclick="remove()">Remove</button>
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