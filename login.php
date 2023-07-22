<?php

require_once __DIR__ . './db/connection.php';

$error = [];
$fail = "";


if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (!$_POST['email']) {
        $error['email'] = "Email is Required";
    }

    if (!$_POST['password']) {
        $error['password'] = "Password is Required";
    }

    if (count($error) === 0) {

        $query = "SELECT * FROM `users` WHERE email = :email";
        $user = null;

        try {
            $statement = $pdo->prepare($query);
            $statement->execute(array(
                ':email' => $_POST['email'],
            ));

            $user = $statement->fetch();

            if ($user) {

                if (password_verify($_POST['password'], $user['password'])) {

                    session_start();

                    session_regenerate_id();

                    $_SESSION['user'] = $user;

                    header('Location: index.php');
                    exit();
                } else {
                    $error['email'] = "Inavlid Credentials";
                    $error['password'] = "Inavlid Credentials";
                }
            } else {
                $error['email'] = "Inavlid Credentials";
                $error['password'] = "Inavlid Credentials";
            }
        } catch (PDOException $e) {
            $fail = "Something Went Wrong!";
        }
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="register-container">
        <div class="card">
            <div class="card-content">
                <?= isset($_GET['message']) ? "<p class='success'> Account Created Successfully </p>" : "" ?>
                <p class="title">Login</p>
                <form action="" method="post" class="form-container">
                    <div class="input-container">
                        <span><i class="fa-regular fa-envelope"></i></span>
                        <div>
                            <input type="email" id="email" name="email" placeholder="Email" value="<?= isset($_POST['email']) ? $_POST['email'] : "" ?>">
                            <?= isset($error['email']) ? "<em class='error-field'>* " . $error['email'] . "</em>" : '' ?>
                        </div>
                    </div>
                    <div class="input-container">
                        <span><i class="fa-solid fa-key"></i></i></span>
                        <div>
                            <input type="password" id="password" name="password" placeholder="Password">
                            <?= isset($error['password']) ? "<em class='error-field'>* " . $error['password'] . "</em>" : '' ?>
                        </div>
                    </div>
                    <div class="submit-btn">
                        <input type="submit" value="Login">
                    </div>
                    <div class="nav-login-register">
                        <p>Don't have an account? <a href="./register.php">Register</a> </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>