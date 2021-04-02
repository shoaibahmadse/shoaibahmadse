<?php
    include "layout/header.php";
    $cat_sql = "SELECT * FROM category WHERE status='1' ORDER BY id";
    $cat_res = mysqli_query($conn, $cat_sql);
    $cat_name = "";
    $all = false;

    if(isset($_GET['name'])) {
        $cat_name = mysqli_real_escape_string($conn, $_GET['name']);
        /*WRITE PARAMATIZED QUERY */
    } else{
        $all = true;
    }
?>


    <main class="main-container relative bg-gray-200">
        <nav class="cat-nav text-lg overflow-x-auto whitespace-no-wrap md:whitespace-normal flex bg-orange-500">
            <div class="sm:mx-auto">
                <button id="all" onclick="changeCat('all')" class="<?php if($all){ echo "bg-yellow-300"; } ?> cat-btn p-1 sm:p-3 md:p-4 hover:bg-orange-300 focus:outline-none">
                    All
                </button>
                <?php  
                    if(mysqli_num_rows($cat_res)  > 0 ){
                    while($cat_row = mysqli_fetch_assoc($cat_res)){
                ?>
                <button 
                    onclick="changeCat('<?php echo $cat_row['category'] ?>')" 
                    id="<?php echo $cat_row['category'] ?>" 
                    class="<?php if($cat_row['category'] == $cat_name){ echo "bg-yellow-300"; } ?> cat-btn p-1 sm:p-3 md:p-4 hover:bg-orange-300 focus:outline-none"
                >
                    <?php echo $cat_row['category'] ?>
                </button>
                <?php 
                        }
                    } 
                ?>
            </div>
        
        </nav>
        
        <div class="loader hidden text-center">
            <img class="inline" src="assets/Infinity-1.3s-200px.svg" alt="loading..">
            <p class="text-orange-400 fancy-font">Loading Please Wait.....</p>
        </div>
        <section id="dish-container" class="deals-section text-center p-2">
            <?php
                if(isset($cat_name) && $cat_name != ''){
                    $cat_id_sql = "SELECT id FROM category WHERE category=?";
                    $stmt = mysqli_stmt_init($conn);

                    if(!mysqli_stmt_prepare($stmt, $cat_id_sql)){
                        header("Location: not-found.php");
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $cat_name);
                        mysqli_stmt_execute($stmt);
                        $cat_id_res = mysqli_stmt_get_result($stmt);
                        $cat_id_row = mysqli_fetch_assoc($cat_id_res);
                        $cat_id = $cat_id_row['id'];
                        $dish_sql = "SELECT * FROM dish WHERE category_id='$cat_id'";
                        $dish_res = mysqli_query($conn, $dish_sql);
                    }
                } else {
                    $dish_sql = "SELECT * FROM dish ORDER BY id ASC";
                    $dish_res = mysqli_query($conn, $dish_sql);
                }
                if(mysqli_num_rows($dish_res) > 0){
                    while($dish_row = mysqli_fetch_assoc($dish_res)) {                    
            ?>
                <article id="dish-card" class="deal-card m-3 bg-white shadow-lg hover:shadow-2xl rounded-t-lg">
                    <div class = "deal-img-container" >
                        <img id="dish-image" class="inline w-full h-full deal-img rounded-t-lg" src="<?php echo SITE_DISH_IMAGE.$dish_row['image'] ?>" alt="<?php echo $dish_row['dish'] ?>">
                    </div>
                    <div class="disc border-t-2 border-black">
                        <h2 id="dish-name" class="fancy-font text-md md:text-lg font-bold text-left p-2"><?php echo $dish_row['dish'] ?></h2>
                        <p id="dish-disc" class="p-2 text-left text-sm"><?php echo $dish_row['dish_detail'] ?></p>
                    </div>
                    <div class="price-select m-1">
                        <select class="w-full rounded-md bg-gray-400 text-lg p-1">
                        <?php
                            $dish_id = $dish_row['id'];                  
                            $dish_attr_sql = "SELECT * FROM dish_details WHERE dish_id='$dish_id' ORDER BY price ASC";
                            $dish_attr_res = mysqli_query($conn, $dish_attr_sql);
                            while($dish_attr_row = mysqli_fetch_assoc($dish_attr_res)) {
                        ?>
                            <option value="<?php echo $dish_attr_row['attribute'] ?>"><?php echo $dish_attr_row['attribute'].':'; echo ' Rs'.$dish_attr_row['price']?></option>
                        <?php 
                            }
                        ?>
                        </select>
                    </div>
                </article>
                            <?php 
                            
                        }
                    } else {
                        ?>
                        <p class="text-xl m-auto text-center">
                            Oops, No dish is available in this category right now!
                        </p>
                    <?php
                        }
                    ?>
        </section>
    </main>
    <script src="category.js"></script>
<?php include "layout/footer.php" ?>