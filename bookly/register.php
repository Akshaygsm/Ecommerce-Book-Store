<?php
include "config.php";

if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
    $user_type = $_POST['user_type'];

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = "user already exists";
    } else {
        if ($pass != $cpass) {
            $message[] = "confirm password not matched!";
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $register_query = "INSERT INTO `users` ( `name`, `email`, `password`, `user_type`) VALUES ( '$name', '$email', '$hash', '$user_type')";
            $result = mysqli_query($conn, $register_query);

            $message[] = 'registered successfully!';
            header('location:login.php');
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
    <title>register</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
        }
    }
    ?>



    <div class="form-container">

        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
            <h3>register now</h3>
            <input type="text" name="name" placeholder="enter your name" required class="box">
            <input type="email" name="email" placeholder="enter your email" required class="box">
            <input type="password" name="password" placeholder="enter your password" required class="box">
            <input type="password" name="cpassword" placeholder="confirm your password" required class="box">
            <select name="user_type" class="box">
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select>
            <input type="submit" name="submit" value="register now" class="btn">
            <p>already have an account? <a href="login.php">login now</a></p>
        </form>

    </div>

</body>

</html>