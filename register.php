<?php


require_once __DIR__ . './db/connection.php';

$error = [];
$fail = null;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (!$_POST['username']) {
        $error['username'] = "Username is Required";
    }

    if ($_POST['username']) {
        if (strlen($_POST['username']) < 3) {
            $error['username'] = "Username must be of atleast 3 characters long";
        }
    }

    if (!$_POST['email']) {
        $error['email'] = "Email is Required";
    }

    if (!$_POST['password']) {
        $error['password'] = "Password is Required";
    }

    if ($_POST['password']) {
        if (strlen($_POST['password']) < 6) {
            $error['password'] = "Password must be of atleast 6 characters long";
        }
    }

    if (count($error) === 0) {

        // check for duplicate email
        $query = "SELECT * FROM `users` WHERE email = :email";
        $user = null;

        try {

            $statement = $pdo->prepare($query);
            $statement->execute(array(
                ':email' => $_POST['email'],
            ));

            $user = $statement->fetch();

            if ($user) {
                $error['email'] = "Email Already Exist";
            } else {

                $options = [
                    'cost' => 12,
                ];

                $password = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);

                $sql = "INSERT INTO `users` (username, email, password) VALUES (:username, :email, :password)";

                $statement = $pdo->prepare($sql);

                $statement->execute(array(
                    ':username' => htmlspecialchars($_POST['username']),
                    ':email' => htmlspecialchars($_POST['email']),
                    ':password' => $password,
                ));

                $location = 'Location: ' . __DIR__ . './login.php?message=Success';

                header("Location: login.php?message=Success");
                die();
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
    <title>Register</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="register-container">
        <div class="card">
            <div class="card-content">
                <p class="title">Create New Account</p>
                <form action="" method="post" class="form-container">
                    <div class="input-container">
                        <span><i class="fa-regular fa-user"></i></span>
                        <div>
                            <input type="text" id="username" name="username" placeholder="Username" value="<?= isset($_POST['username']) ? $_POST['username'] : "" ?>">
                            <?= isset($error['username']) ? "<em class='error-field'>* " . $error['username'] . "</em>" : '' ?>
                        </div>
                    </div>
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
                        <input type="submit" value="Register">
                    </div>
                    <?= isset($fail) ? "<p class='fail-error'>* " . $fail . "</p>" : "" ?>
                </form>
                <div class="nav-login-register">
                    <p>Already have an account? <a href="./login.php">Login</a> </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>