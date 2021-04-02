<?php
    if(!isset($_POST['submit'])) {
        header("Location: ../signup.php");
        exit();
    } 
    else {
        require 'connection.inc.php';
        $username = $_POST['username'];
        $email = $_POST['mail'];
        $password = $_POST['password'];
       
        if (empty($username) || empty($email) || empty($password)) {
            header("Location: ../signup.php?error=emptyfields&uuid=" . $username . "&mail=" . $email);
            exit();
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: ../signup.php?error=invalidmailuid");
            exit();
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../signup.php?error=invalidmail&uuid=" . $username);
            exit();
        } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: ../signup.php?error=invaliduid&mail=" . $email);
            exit();
        } else {
            $sql = "SELECT username FROM admin_users WHERE username=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../signup.php?error=sql1error");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck > 0) {
                    header("Location: ../signup.php?error=usertaken&mail=" . $email);
                    exit();
                } else {
                    $sql = "INSERT INTO admin_users (username, password, email) VALUES (?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../signup.php?error=sql2error");
                        exit();
                    } else {
                        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, "sss", $username, $hashedPwd, $email);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../signup.php?signup=success");
                        exit();
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }    
?>