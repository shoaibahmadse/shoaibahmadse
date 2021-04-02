<?php   
    if(isset($_POST['submit'])){
        if(isset($_POST['name']) && $_POST['name'] !== '' && isset($_POST['category']) && $_POST['category'] !== '' && isset($_POST['details']) && $_POST['details'] !== ''){
            require "../../includes/connection.inc.php";
            require "../../includes/constant.inc.php";
            $id = $_POST['id'];
            $name = $_POST['name'];
            $catId = $_POST['category'];
            $dishDetail = $_POST['details'];
            $sql = "SELECT * FROM dish WHERE dish=? AND id!=?";
            $stmt = mysqli_stmt_init($conn);
            $added_on = date('Y-m-d');
            $attributeArr = $_POST['attribute'];
            $priceArr = $_POST['price'];            
            $dishDetailsId = $_POST['dish_details_id'];
            
            
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../dish.php?error=sql1error");
                exit();

            } else {
                mysqli_stmt_bind_param($stmt, "ss", $name, $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                
                if ($resultCheck > 0) {
                    header("Location: ../dish.php?error=dish-already-exists");
                    exit();

                } else {
                    if($_FILES['image']['name'] != '') {
                        $type = $_FILES['image']['type'];
                        if($type != 'image/jpeg' && $type != 'image/png'){
                            header('Location: ../dish.php?invalid-file-format');
                            exit();
                        } else {
                            $img = rand(111111111, 999999999).'_'.$_FILES['image']['name'];
                            move_uploaded_file($_FILES['image']['tmp_name'], SERVER_DISH_IMAGE.$img);
                            $oldImgRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM dish WHERE id='$id'"));
                            $oldImg = $oldImgRow['image'];
                            
                            if(!empty($oldImg) && is_string($oldImg)){
                                unlink(SERVER_DISH_IMAGE.$oldImg);
                            }                            
                            
                            $sql = "UPDATE dish SET category_id=?, dish=?, dish_detail=?, image=?, added_on=? WHERE id=?";
                            $stmt = mysqli_stmt_init($conn);
    
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                header("Location: ../dish.php?error=sql2error");
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, "ssssss", $catId, $name, $dishDetail, $img, $added_on, $id);
                                mysqli_stmt_execute($stmt);
                                header("Location: ../dish.php?status=successful");
                                exit();
                            }
                        }
                        
                    } else {
                        $sql = "UPDATE dish SET category_id=?, dish=?, dish_detail=?, added_on=? WHERE id=?";
                        $stmt = mysqli_stmt_init($conn);

                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ../dish.php?error=sql2error");
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "sssss", $catId, $name, $dishDetail, $added_on, $id);
                            mysqli_stmt_execute($stmt);

                            foreach($attributeArr as $key=>$val) {
                                $attribute = $val;
                                $price = $priceArr[$key];
                                if(isset($dishDetailsId[$key])){
                                    $detailSQL = "UPDATE dish_details SET attribute=?, price=? WHERE id=?";
                                    $stmt = mysqli_stmt_init($conn);
                                    if(!mysqli_stmt_prepare($stmt, $detailSQL)) {
                                        header("Location: ../dish.php?error=sql3error");
                                        exit();
                                    } else {
                                        mysqli_stmt_bind_param($stmt, "sss", $attribute, $price, $dishDetailsId[$key]);
                                        mysqli_stmt_execute($stmt);
                                    }
                                }else {
                                    $detailSQL = "INSERT INTO dish_details (dish_id, attribute, price, added_on) VALUES (?, ?, ?, ?)";                                    
                                    $stmt = mysqli_stmt_init($conn);
                                    if(!mysqli_stmt_prepare($stmt, $detailSQL)) {
                                        header("Location: ../dish.php?error=sql4error");
                                        exit();
                                    } else {
                                        mysqli_stmt_bind_param($stmt, "ssss", $id, $attribute, $price, $added_on);
                                        mysqli_stmt_execute($stmt);
                                    }
                                }
                            }

                            header("Location: ../dish.php?status=successful");
                            exit();
                        }    
                    }
                    

                    
                }
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        } else {
            header('Location: ../dish.php?error=empty-fields');
            exit();
        }
    } else {
        header('Location: ../../not-found.php');
        exit();
    }
?>