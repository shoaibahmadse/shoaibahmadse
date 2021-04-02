<?php

    include "../includes/connection.inc.php";
    if(isset($_GET['category-name'])) {       
        $cat_name = mysqli_real_escape_string($conn, $_GET['category-name']);
        if($cat_name == 'all') {
            $sqlLine = '';
        } else {        
            $cat_id_sql = "SELECT id FROM category WHERE category=?";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $cat_id_sql)){
                echo "Query Error";
                die();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $cat_name);
                mysqli_stmt_execute($stmt);
                $cat_id_res = mysqli_stmt_get_result($stmt);
                $cat_id_row = mysqli_fetch_assoc($cat_id_res);
                $cat_id = $cat_id_row['id'];
                $sqlLine = "WHERE category_id='$cat_id'";
            }
        }
        
        $sql = "SELECT * FROM dish ".$sqlLine;
        $res = mysqli_query($conn, $sql);
        $dishes = mysqli_fetch_all($res, MYSQLI_ASSOC);
        echo json_encode($dishes);

    } else if(isset($_GET['dish-id'])) {
        
        $dish_id = mysqli_real_escape_string($conn, $_GET['dish-id']);
        $sql = "SELECT * FROM dish_details WHERE dish_id=? ORDER BY price ASC";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo "Query Error";
            die();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $dish_id);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $attr = mysqli_fetch_all($res, MYSQLI_ASSOC);
            echo json_encode($attr);
            }
        
    } 
    else {
        header("Location: ../dist/not-found.php");
    }