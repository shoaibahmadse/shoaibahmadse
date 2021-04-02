<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Signup</title>
</head>
<body class="bg-gray-200">
<div class="bg-gray-200 min-h-screen flex flex-col">
            <div class="container max-w-sm mx-auto flex-1 flex flex-col items-center justify-center px-2">
                <?php 
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == "emptyfields") {
                        echo "<p>Fill in all fields</p>";
                    } else if ($_GET['error'] == "invaliduidmail") {
                        echo "<p>Invalid User name and Email</p>";
                    } else if ($_GET['error'] == "invaliduidmail") {
                        echo "<p>Invalid Email</p>";
                    } else if ($_GET['error'] == "invaliduid") {
                        echo "<p>Invalid User name</p>";
                    } else if ($_GET['error'] == "passwordChrck") {
                        echo "<p>Passwords dont match!</p>";
                    } else if ($_GET['error'] == "usertaken") {
                        echo "<p>User name already taken!</p>";
                    } else if ($_GET['error'] == "pwdweak") {
                        echo "<p>Password too weak. Use 8 or more characters</p>";
                    } else if ($_GET['error'] == "sqlerror") {
                        echo "<p>An Error Occured. Please try again later</p>";
                    }
                }
                ?>
                <form class="bg-white px-6 py-8 rounded shadow-md text-black w-full" autocomplete="off" method="post" action="includes/signup.inc.php">
                    <h1 class="mb-8 text-3xl text-center">Sign up</h1>
                    <input 
                        name="username"
                        type="text"
                        class="block border border-grey-light w-full p-3 rounded mb-4"
                        name="fullname"
                        placeholder="Full Name" />

                    <input 
                        name="mail"
                        type="text"
                        class="block border border-grey-light w-full p-3 rounded mb-4"
                        name="email"
                        placeholder="Email" />

                    <input
                        name="password" 
                        type="password"
                        class="block border border-grey-light w-full p-3 rounded mb-4"
                        name="password"
                        placeholder="Password" />

                    <button
                        name="submit"
                        type="submit"
                        class="w-full text-center py-3 rounded bg-green text-black hover:bg-green-dark focus:outline-none my-1"
                    >Create Account</button>
                </form>

                <div class="text-grey-dark mt-6">
                    Already have an account? 
                    <a class="no-underline border-b border-blue text-blue" href="../login.php">
                        Log in
                    </a>
                </div>
            </div>
        </div>
</body>
</html>