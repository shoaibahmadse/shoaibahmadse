<?php
    session_start();
    require "../../includes/connection.inc.php";
    require "../../includes/constant.inc.php";
    if(isset($_POST['submit']) && $_SESSION['userUId'] != ''){
        if(isset($_POST['name']) && $_POST['name'] !== '' && isset($_POST['category']) && $_POST['category'] !== '' && isset($_POST['details']) && $_POST['details'] !== '' && isset($_POST['attribute']) && $_POST['attribute'] !== ''){
             
            $name = $_POST['name'];
            $catId = $_POST['category'];
            $dishDetail = $_POST['details'];
            $sql = "SELECT * FROM dish WHERE dish=?";
            $stmt = mysqli_stmt_init($conn);
            $added_on = date('Y-m-d');
            $type = $_FILES['image']['type'];
            $attributeArr = $_POST['attribute'];
            $priceArr = $_POST['price'];
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../addDish.php?error=sql1error");
                exit();

            } else {
                mysqli_stmt_bind_param($stmt, "s", $name);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                
                if ($resultCheck > 0) {
                    header("Location: ../addDish.php?error=dish-already-exists");
                    exit();

                } else {
                    if($type != 'image/jpeg' && $type !='image/png') {
                        header('Location: ../addDish.php?error=invalid-file-format');
                    }else {
                        $img = rand(111111111, 999999999).'_'.$_FILES['image']['name'];
                        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_DISH_IMAGE.$img);
                        $sql = "INSERT INTO dish (category_id, dish, dish_detail, image, added_on) VALUES (?, ?, ?, ?, ?)";
                        $stmt = mysqli_stmt_init($conn);
    
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ../addDish.php?error=sql2error");
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "sssss", $catId, $name, $dishDetail, $img, $added_on);
                            mysqli_stmt_execute($stmt);
                            $dishId = mysqli_insert_id($conn);
                            foreach($attributeArr as $key=>$val) {
                                $attribute = $val;
                                $price = $priceArr[$key];
                                $detailSQL = "INSERT INTO dish_details (dish_id, attribute, price, added_on) VALUES (?, ?, ?, ?)";
                                
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $detailSQL)) {
                                    header("Location: ../addDish.php?error=sql3error");
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "ssss", $dishId, $attribute, $price, $added_on);
                                    mysqli_stmt_execute($stmt);
                                }
                            }

                            header("Location: ../addDish.php?status=successful");
                            exit();
                        }
                    }
                    
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        } else {
            header('Location: ../addDish.php?error=empty-fields');
            exit();
        }
    } else {
        header('Location: ../../not-found.php');
        exit();
    }
?>