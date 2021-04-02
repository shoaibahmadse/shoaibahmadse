<?php
    session_start();
    if(isset($_POST['submit']) && isset($_SESSION['userUId']) && $_SESSION['userUId'] != ''){
        if(isset($_POST['phone']) && $_POST['phone'] !== '' && isset($_POST['email']) && $_POST['email'] !== ''){
            require "../../includes/connection.inc.php";
            require "../../includes/constant.inc.php";
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            
            if($_FILES['image']['name'] != '') {
                $type = $_FILES['image']['type'];
                if($type != 'image/jpeg' && $type != 'image/png'){
                    header('Location: ../index.php?invalid-file-format');
                    exit();
                } else {
                    $img = rand(111111111, 999999999).'_'.$_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], SERVER_MENU_IMAGE.$img);
                    $oldImgRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT menu_image FROM site_details WHERE id='$id'"));
                    $oldImg = $oldImgRow['image'];
                    
                    if(!empty($oldImg) && is_string($oldImg)){
                        unlink(SERVER_MENU_IMAGE.$oldImg);
                    }                            
                    
                    $sql = "UPDATE site_details SET phone_contact=?, email_contact=?, menu_image=? WHERE id=?";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../index.php?error=sql2error");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "ssss", $phone, $email, $img, $id);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../index.php?status=successful");
                        exit();
                    }
                }
                
            } else {
                $sql = "UPDATE site_details SET phone_contact=?, email_contact=? WHERE id=?";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../index.php?error=sql2error");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "sss", $phone, $email, $id);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../index.php?success");
                }
            }
        
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        } else {
            header('Location: ../index.php?error=empty-fields');
            exit();
        }
    } else {
        header('Location: ../../not-found.php');
        exit();
    }
?>