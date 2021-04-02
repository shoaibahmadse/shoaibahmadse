<?php
    if(isset($_POST['submit']) && $_POST['submit'] != '') {
        include "../includes/connection.inc.php";
        include "../includes/constant.inc.php";
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $msg = $_POST['message'];       
        
        $sql = "SELECT * FROM site_details WHERE id=1";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);

        $subject = "Payala Front Contact Form";
        if($name == '' || $email == '' || $msg == '' || $phone == '') {
            header("Location: ../contact.php?error=empty-field&msg=$msg");
            die();
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../contact.php?error=invalid-email&msg=$msg");
            die();
        }
        if (!preg_match('/^[0-9]{11}+$/', $phone)) {
            header("Location: ../contact.php?error=invalid-number&msg=$msg");
            die();
        }
        
        $to = $row['email_contact'].", auawdigital@gmail.com";

        $body = " Name: $name\n E-mail: $email\n Phone: $phone\n Message:\n $msg";
        
        if(mail($to, $subject, $body)){
            header("Location: ../contact.php?status=success");
        } else {
            header("Location: ../contact.php?status=fail");
        }
    } else {
        header("Location: ../not-found.php");
    }

?>