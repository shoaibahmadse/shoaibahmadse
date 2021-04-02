<?php
session_start();

require_once "login/Auth.php";
require_once "login/Util.php";

$auth = new Auth();
$db_handle = new DBController();
$util = new Util();

require_once "login/authCookieSessionValidate.php";

if ($isLoggedIn) {
    $util->redirect("index.php");
}

if (!empty($_POST["login"])) {
    $isAuthenticated = false;
    $username = $_POST["member_name"];
    $password = $_POST["member_password"];

    $user = $auth->getMemberByUsername($username);
    if (isset($user[0]["member_password"])) {
        if (password_verify($password, $user[0]["member_password"])) {
            $_SESSION['userUId'] = $username;
            $isAuthenticated = true;
        }
    }

    if ($isAuthenticated) {
        $_SESSION["member_id"] = $user[0]["member_id"];

        // Set Auth Cookies if 'Remember Me' checked
        if (!empty($_POST["remember"])) {
            setcookie("member_login", $username, $cookie_expiration_time);

            $random_password = $util->getToken(16);
            setcookie("random_password", $random_password, $cookie_expiration_time);

            $random_selector = $util->getToken(32);
            setcookie("random_selector", $random_selector, $cookie_expiration_time);

            $random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
            $random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);

            $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);

            // mark existing token as expired
            $userToken = $auth->getTokenByUsername($username, 0);
            if (!empty($userToken[0]["id"])) {
                $auth->markAsExpired($userToken[0]["id"]);
            }
            // Insert new token
            $auth->insertToken($username, $random_password_hash, $random_selector_hash, $expiry_date);
        } else {
            $util->clearAuthCookie();
        }
        $util->redirect("index.php");
    } else {
        $message = "Invalid Login";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=MuseoModerno&family=Poppins&display=swap" rel="stylesheet">
    <title>Admin</title>
</head>

<body class="bg-orange-300 tracking-wider">
    <header>
        <p class="text-center font-bold text-orange-700 text-3xl mt-5 md:text-5xl md:mt-10">Modern Cafe Admin Panel</p>
    </header>
    <main class="w-full max-w-xs mx-auto mt-40">

        <form method="post" id="frmLogin" class="text-center">
            <div class="error-message text-red-500"><?php if (isset($message)) {
                                                        echo $message;
                                                    } ?></div>
            <div class="field-group">
                <div class="my-2">
                    <label for="login">Username</label>
                </div>
                <div class="my-2">
                    <input name="member_name" autocomplete="off" type="text" value="<?php if (isset($_COOKIE["member_login"])) {
                                                                                        echo $_COOKIE["member_login"];
                                                                                    } ?>" class="input-field rounded-lg p-1">
                </div>
            </div>
            <div class="field-group">
                <div class="my-2">
                    <label for="password">Password</label>
                </div>
                <div class="my-2">
                    <input name="member_password" type="password" value="<?php if (isset($_COOKIE["member_password"])) {
                                                                                echo $_COOKIE["member_password"];
                                                                            } ?>" class="input-field rounded-lg p-1">
                </div>
            </div>
            <div class="field-group">
                <div class="my-2">
                    <input type="checkbox" name="remember" id="remember" <?php if (isset($_COOKIE["member_login"])) { ?> checked <?php } ?> /> <label for="remember-me" class="text-gray-600">Remember me</label>
                </div>
            </div>
            <div class="field-group">
                <div class="my-2">
                    <input type="submit" name="login" value="Login" class="form-submit-button bg-orange-500 hover:bg-orange-700 border-orange-500 hover:border-orange-700 text-sm border-4 text-white py-1 px-2 roundedbg-orange-500 hover:bg-orange-700 border-orange-500 hover:border-orange-700 text-sm border-4 text-white py-1 px-2 rounded"></span>
                </div>
            </div>


        </form>
    </main>
</body>

</html>