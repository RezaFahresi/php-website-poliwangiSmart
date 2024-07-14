<?php
session_start();

if (isset($_SESSION['user'])) {
    if ($_SESSION['role'] == "admin") {
        header('Location: ../admin/index.php');
        exit();
    }
}

require "../database/conn.php";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user['nama'];
            $_SESSION['role'] = "admin";
            if ($_SESSION['role'] == "admin") {
                header('Location: ../admin/index.php');
                exit();
            } else {
                $error = "Anda tidak memiliki akses sebagai admin.";
            }
        } else {
            $error = "Username atau password salah.";
        }
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.ico">
    <title>Login - Poliwangi SMART</title>
    <!-- Bootstrap core CSS-->
    <link href="../admin/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="../admin/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="../admin/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
<div class="container">
    <div class="card container card-login mx-auto mt-5">
        <h4 class="text-center" style="padding-top:8px;">Login</h4>
        <hr class="custom">
        <div class="card-body">
            <form method="post" action="">
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input class="form-control" id="username" type="text" name="username" aria-describedby="userlHelp" placeholder="Enter Username">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input class="form-control" id="password" name="password" type="password" placeholder="Password">
                </div>
                <?php if (isset($error)): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"> Remember Password
                        </label>
                    </div>
                </div>
                <div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
                    <a href="login-user.php">Login sebagai User</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="../admin/vendor/jquery/jquery.min.js"></script>
<script src="../admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="../admin/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
