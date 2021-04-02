<?php 
    session_start();
    if(isset($_POST['submit']) && isset($_SESSION['userUId']) && $_SESSION['userUId'] !='' && $_POST['name'] !== '') {
        require "../../includes/connection.inc.php";
        require "../../includes/constant.inc.php";
        $catName = $_POST['name'];
        $catId = $_POST['id'];

        $sql = "SELECT * FROM category WHERE category=? AND id!=?";
        $stmt = mysqli_stmt_init($conn);
       

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../categories.php?error=sql1error");
            exit();

        } else {
            mysqli_stmt_bind_param($stmt, "ss", $catName, $catId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            
            if ($resultCheck > 0) {
                header("Location: ../categories.php?error=catalreadyexists");
                exit();

            } else {
                $sql = "UPDATE category SET category=? WHERE id=?";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../categories.php?error=sql2error");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "ss", $catName, $catId);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../categories.php?status=successful");
                    exit();
                }
            }
        }
    } else {
        header('Location: ../../not-found.php');
    }

?>