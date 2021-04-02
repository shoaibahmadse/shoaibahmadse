<?php 
include_once "layout/header.php";


if(isset($_GET['action']) && $_GET['type']!=='' && isset($_GET['id']) && $_GET['id'] > 0){
	$type = mysqli_real_escape_string($conn, $_GET['action']);
	$id = mysqli_real_escape_string($conn, $_GET['id']);
    
    if($type =='delete'){
        mysqli_query($conn,"DELETE FROM category WHERE id='$id'");
        mysqli_query($conn, "DELETE FROM dish WHERE category_id='$id'");
		header('Location:categories.php');
    }

	if($type =='active' || $type =='deactive'){
		$status = 1;
 		if($type=='deactive'){
			$status = 0;
		}
        mysqli_query($conn,"UPDATE category SET status='$status' WHERE id='$id'");
        header("Location: categories.php");
	}
}

$sql = "SELECT * FROM category ORDER BY id";
$res = mysqli_query($conn, $sql);

?>

<main class="sm:ml-48 mx-3 sm:mr-6 mt-4 relative">
    <div class="bg-white p-5 shadow-lg w-full">
        <p class="text-center text-2xl md:text-3xl font-extrabold m-2">Categories</p>
        <div>
            <a class="p-1 sm:p-2 bg-green-400 text-xs sm:text-sm md:text-lg" href="addCategories.php">
                <i class="fas fa-plus"></i>
                Add Categories
            </a>
           
        </div>
    </div>
    <div class="my-4 p-2 shadow-lg table-responsive bg-white">
        <div class="modalBox text-center bg-gray-300 modal-box m-auto tracking-wider p-2 shadow-lg z-50 hidden">
            <p class="msg">Do you really want to delete this category?</p>
            <p class="dishes"></p>
            <div class="m-2 p-2">
                <a class="del-link text-white p-1 m-4 bg-green-500">Confirm</a>
                <button class="font-bold p-1 m-4 focus:outline-none text-white bg-red-500" onclick="clearModal()">Deny</button>
            </div>
        </div>
        <table 
            id="table-main" 
            data-toggle="table"
            data-pagination="true"
            data-search="true"
            class="table text-sm sm:text-lg p-2"
        >

            <thead class="thead-dark">
            <tr class="m-2 p-2 border-b-2 font-bold">
                <th data-sortable="true" data-field="id">ID</th>
                <th data-sortable="true" data-field="name">Categories</th>
                <th data-sortable="true" data-field="status">Status</th>
                <th data-field="actions">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php 
                $i = 1;
                if(mysqli_num_rows($res) > 0) { 
                    while($row = mysqli_fetch_assoc($res)){
                        
            ?>
            <tr class="leading-9">
                <td class="text-center p-2"><?php echo $row['id']?></td>
                <td class="text-center p-2" id="row-name"><?php echo $row['category']?></td>
                <td class="text-center p-3">
                    <?php 
                        $status = $row['status'];
                        $row_id = $row['id'];
                        if($status == 1) {
                    ?>
                        <span class="mr-2 p-1 rounded-md bg-green-400 hover:bg-green-500">
                            <a href='?action=deactive&id=<?php echo $row_id?>'>
                                Active
                            </a>
                        </span>
                    <?php
                        } else {
                     ?>
                        <span class="mr-2 p-1 rounded-md bg-red-500 hover:bg-red-600">
                            <a href='?action=active&id=<?php echo $row_id?>'>
                                Deactive
                            </a>
                        </span>
                    <?php 
                       }
                   ?>
                    
                </td>
                
                <td class="text-center">
                    <span class="mr-2 p-1 text-orange-400 hover:text-orange-500">
                        <a href='editCategories.php?id=<?php echo $row['id']?>&&cat-name=<?php echo $row['category'] ?>'>
                            <i class="fas fa-edit fa-2x"></i>
                        </a>
                    </span>
                    
                    <span class="mr-2 text-red-600 hover:text-red-700">
                        <button class="focus:outline-none" onclick="showModal(<?php echo $row_id ?>, '<?php echo $row['category'] ?>', true)">
                            <i class="fas fa-trash fa-2x"></i>
                        </button>
                    </span>
                </div>        
                </td>
                    
            </tr>
            <?php 
                    $i++;
                    }
                }
                else{ ?>
            
                <td colspan="4" class="text-center">No data found</td>
            <?php
                }
            ?>
            </tbody>
        </table>
    </div>


</main>
<?php 
include_once "layout/footer.php";
?>